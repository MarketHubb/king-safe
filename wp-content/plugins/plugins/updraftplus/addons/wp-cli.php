<?php
// @codingStandardsIgnoreStart
/*
UpdraftPlus Addon: wp-cli:WP CLI
Description: Adds WP-CLI commands
Version: 1.1
Shop: /shop/wp-cli/
RequiresPHP: 5.3.3
Latest Change: 1.14.6
*/
// @codingStandardsIgnoreEnd

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

if (!defined('WP_CLI') || !WP_CLI || !class_exists('WP_CLI_Command')) return;

/**
 * Implements Updraftplus CLI all commands
 */
class UpdraftPlus_CLI_Command extends WP_CLI_Command {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter('updraft_user_can_manage', '__return_true');
		add_filter('updraftplus_backupnow_start_message', array($this, 'backupnow_start_message'), 10, 2);
	}
	
	/**
	 * Take backup. If any option is not given to command, the default option will be taken to proceed
	 *
	 * ## OPTIONS
	 *
	 * [--exclude-db]
	 * : Exclude database from backup
	 *
	 * [--include-files=<include-files>]
	 * : File entities which will be backed up. Multiple file entities names should separate by comma (,).
	 *
	 * [--include-tables=<include-tables>]
	 * : Tables which will be backed up.  You should backup all tables unless you are an expert in the internals of the WordPress database. Multiple table names seperated by comma (,). If include-tables is not added in command, All tables will be backed up
	 * ---
	 * default: all
	 * ---
	 *
	 * [--send-to-cloud]
	 * : Whether or not send backup to remote cloud storage
	 *
	 * [--always-keep]
	 * : Only allow this backup to be deleted manually (i.e. keep it even if retention limits are hit)
	 *
	 * [--label=<label>]
	 * : Backup label
	 *
	 * [--incremental]
	 * : Start a incremental backup
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus backup --exclude-db --include-files="plugins,themes" --send-to-cloud --label="UpdraftplusCLI Backup"
	 *
	 * @when after_wp_load
	 *
	 * @param Array $args       A indexed array of command line arguments
	 * @param Array $assoc_args Key value pair of command line arguments
	 */
	public function backup($args, $assoc_args) {
		global $wpdb, $updraftplus;
		if (isset($assoc_args['exclude-db']) && filter_var($assoc_args['exclude-db'], FILTER_VALIDATE_BOOLEAN)) {
			$backupnow_db = false;
		} else {
			$backupnow_db = true;
		}
		if (isset($assoc_args['send-to-cloud'])) {
			$backupnow_cloud = filter_var($assoc_args['send-to-cloud'], FILTER_VALIDATE_BOOLEAN) ? true : false;
		} else {
			$backupnow_cloud = $this->get_default_send_to_cloud();
		}
		if (isset($assoc_args['always-keep']) && filter_var($assoc_args['always-keep'], FILTER_VALIDATE_BOOLEAN)) {
			$always_keep = true;
		} else {
			$always_keep = false;
		}
		if (isset($assoc_args['incremental']) && filter_var($assoc_args['incremental'], FILTER_VALIDATE_BOOLEAN)) {
			$incremental = true;
			$nonce = UpdraftPlus_Backup_History::get_latest_full_backup();
			if (empty($nonce)) WP_CLI::error(__('No previous backup found to add an increment to.', 'updraftplus'), true);
			$updraftplus->file_nonce = $nonce;
			add_filter('updraftplus_incremental_backup_file_nonce', array($updraftplus, 'incremental_backup_file_nonce'));
		} else {
			$incremental = false;
		}
		$only_these_file_entities = isset($assoc_args['include-files']) ? str_replace(' ', '', $assoc_args['include-files']) : $this->get_backup_default_include_files();
		if (isset($assoc_args['include-files'])) {
			$only_these_file_entities_array = explode(',', $only_these_file_entities);
			$backupable_entities = $updraftplus->get_backupable_file_entities(true, true);
			foreach ($only_these_file_entities_array as $include_backup_entity) {
				if (!isset($backupable_entities[$include_backup_entity])) {
					WP_CLI::error(sprintf(__("The given value for the '%s' option is not valid", 'updraftplus'), 'include-files'), true);
				}
			}
		} else {
			$only_these_file_entities = $this->get_backup_default_include_files();
		}
		$backupnow_files = empty($only_these_file_entities) ? false : true;
		$only_these_table_entities = !empty($assoc_args['include-tables']) ? str_replace(' ', '', $assoc_args['include-tables']) : '';
		if (isset($assoc_args['include-tables']) && '' == $assoc_args['include-tables'] && false == $backupnow_nodb) {
			WP_CLI::error(__('You have chosen to backup a database, but no tables have been selected', 'updraftplus'), true);
		}
		if (true === $only_these_table_entities || 'all' === $only_these_table_entities) {
			$only_these_table_entities = '';
		}
		if (!$backupnow_db && !$backupnow_files) {
			WP_CLI::error(__('If you exclude both the database and the files, then you have excluded everything!', 'updraftplus'), true);
		}
		$params = array(
			'backupnow_nodb'    => !$backupnow_db,
			'backupnow_nofiles' => !$backupnow_files,
			'backupnow_nocloud' => !$backupnow_cloud,
			'always_keep'		=> $always_keep,
			'backupnow_label'   => empty($assoc_args['label']) ? '' : $assoc_args['label'],
			'extradata'         => '',
			'incremental'       => $incremental,
		);
		if ('' != $only_these_file_entities) {
			$params['onlythisfileentity'] = $only_these_file_entities;
		}
		if ('' != $only_these_table_entities) {
			$temp_onlythesetableentities = explode(',',  $only_these_table_entities);
			foreach ($temp_onlythesetableentities as $onlythesetableentity) {
				if (0 === stripos($onlythesetableentity, $wpdb->prefix)) {
					$query = $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->esc_like($onlythesetableentity));
					// There is possible that table name like wp_wp_custom_table
					if ($onlythesetableentity == $wpdb->get_var($query)) {
						$new_onlythesetableentity = $onlythesetableentity;
					} else {
						$new_onlythesetableentity = $wpdb->prefix.$onlythesetableentity;
					}
				} else {
					$new_onlythesetableentity = $wpdb->prefix.$onlythesetableentity;
				}
				$params['onlythesetableentities'][] = array(
					'name'  => 'updraft_include_tables_wp',
					'value' => $new_onlythesetableentity
				);
			}
		}
		$params['background_operation_started_method_name'] = '_backup_background_operation_started';
		$this->set_commands_object();
		$this->commands->backupnow($params);
	}
	
	/**
	 * When backup started, It displays success message
	 *
	 * @return string $default_include_files default backup include files
	 */
	private function get_backup_default_include_files() {
		global $updraftplus;
		$default_include_files_array = array();
		$backupable_entities = $updraftplus->get_backupable_file_entities(true, true);
		// The true (default value if non-existent) here has the effect of forcing a default of on.
		$include_more_paths = UpdraftPlus_Options::get_updraft_option('updraft_include_more_path');
		foreach ($backupable_entities as $key => $info) {
			if (UpdraftPlus_Options::get_updraft_option("updraft_include_$key", apply_filters("updraftplus_defaultoption_include_".$key, true))) {
				$default_include_files_array[] = $key;
			}
		}
		$default_include_files = implode(',', $default_include_files_array);
		return $default_include_files;
	}
	
	/**
	 * Get default send to cloud options
	 *
	 * @return boolean $default_send_to_cloud default
	 */
	private function get_default_send_to_cloud() {
		global $updraftplus;
		$service = $updraftplus->just_one(UpdraftPlus_Options::get_updraft_option('updraft_service'));
		if (is_string($service)) $service = array($service);
		if (!is_array($service)) $service = array();
		$default_send_to_cloud = (empty($service) || array('none') === $service || 'none' === $service || array('') === $service) ? false : true;
		return $default_send_to_cloud;
	}
	
	/**
	 * When backup started, It displays success message
	 *
	 * @param array $msg_arr Message data
	 */
	public function _backup_background_operation_started($msg_arr) {
		WP_CLI::success($msg_arr['m']);
		WP_CLI::success(sprintf(__('Recently started backup job id: %s', 'updraftplus'), $msg_arr['nonce']));
	}
	
	/**
	 * Filter updraftplus_backupnow_start_message, backupnow_start_message message changed
	 *
	 * @param string $message backup start message
	 * @param string $job_id  backup job identifier
	 */
	public function backupnow_start_message($message, $job_id) {
		return sprintf(__('Backup has been started successfully. You can see the last log message by running the following command: "%s"', 'updraftplus'), 'wp updraftplus backup_progress '.$job_id);
	}
	
	/**
	 * Set commands variable as object of UpdraftPlus_Commands
	 */
	private function set_commands_object() {
		if (!isset($this->commands)) {
			if (!class_exists('UpdraftPlus_Commands')) include_once(UPDRAFTPLUS_DIR.'/includes/class-commands.php');
			$this->commands = new UpdraftPlus_Commands($this);
		}
	}
	
	/**
	 * See backup_progress
	 *
	 * ## OPTIONS
	 *
	 * <job_id>
	 * : The backup job identifier
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus backup_progress b290ee083e9e
	 *
	 * @when after_wp_load
	 *
	 * @param Array $args A indexed array of command line arguments
	 */
	public function backup_progress($args) {
		$params['job_id'] = $args[0];
		$this->set_commands_object();
		$data = $this->commands->backup_progress($params);
		WP_CLI::success($data['l']);
	}
	
	/**
	 * See log
	 *
	 * ## OPTIONS
	 *
	 * <job_id>
	 * : The backup job identifier
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus get_log b290ee083e9e
	 *
	 * @when after_wp_load
	 *
	 * @param  array $args A indexed array of command line arguments
	 */
	public function get_log($args) {
		$job_id = $args[0];
		$this->set_commands_object();
		$log_data = $this->commands->get_log($job_id);
		if (is_wp_error($log_data)) {
			if (isset($log_data->errors['updraftplus_permission_invalid_jobid'])) {
				WP_CLI::error(__("Invalid Job Id", 'updraftplus'));
					
			} else {
				WP_CLI::error(print_r($log_data, true));
			}
		}
		WP_CLI::log($log_data['log']);
	}
	
	/**
	 * See get_most_recently_modified_log
	 *
	 * ## EXAMPLES
	 *
	 *		wp updraftplus get_most_recently_modified_log
	 *
	 * @when after_wp_load
	 */
	public function get_most_recently_modified_log() {
		if (false === ($updraftplus = $this->_load_ud())) return new WP_Error('no_updraftplus');
		list($mod_time, $log_file, $job_id) = $updraftplus->last_modified_log();
		$this->set_commands_object();
		$log_data = $this->commands->get_log($job_id);
		WP_CLI::log($log_data['log']);
	}
	
	/**
	 * Gives global $updraftplus variable
	 *
	 * @return object - global object of UpdraftPlus class
	 */
	private function _load_ud() {
		global $updraftplus;
		return is_a($updraftplus, 'UpdraftPlus') ? $updraftplus : false;
	}
	
	/**
	 * Gives global $updraftplus_admin variable
	 *
	 * @return object - global object of UpdraftPlus_Admin class
	 */
	private function _load_ud_admin() {
		if (!defined('UPDRAFTPLUS_DIR') || !is_file(UPDRAFTPLUS_DIR.'/admin.php')) return false;
		include_once(UPDRAFTPLUS_DIR.'/admin.php');
		global $updraftplus_admin;
		return $updraftplus_admin;
	}
		
	/**
	 * Delete active_job
	 *
	 * ## OPTIONS
	 *
	 * <job_id>
	 * : The backup job identifier
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus activejobs_delete b290ee083e9e
	 *
	 * @when after_wp_load
	 *
	 * @param  array $args A indexed array of command line arguments
	 */
	public function activejobs_delete($args) {
		$job_id = $args[0];
		$this->set_commands_object();
		$delete_data = $this->commands->activejobs_delete($job_id);
		WP_CLI::log($delete_data['m']);
	}
	
	/**
	 * List existing_backups
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus existing_backups
	 *
	 * @when after_wp_load
	 */
	public function existing_backups() {
		if (false === ($updraftplus = $this->_load_ud())) return new WP_Error('no_updraftplus');
		if (false === ($updraftplus_admin = $this->_load_ud_admin())) return new WP_Error('no_updraftplus');
		
		$accept = apply_filters('updraftplus_accept_archivename', array());
		if (!is_array($accept)) $accept = array();
		
		$backup_history = UpdraftPlus_Backup_History::get_history();
		if (empty($backup_history)) {
			$backup_history = UpdraftPlus_Backup_History::get_history();
		}
		// Reverse date sort - i.e. most recent first
		krsort($backup_history);
		$items = array();
		foreach ($backup_history as $key => $backup) {
			$remote_sent = (!empty($backup['service']) && ((is_array($backup['service']) && in_array('remotesend', $backup['service'])) || 'remotesend' === $backup['service'])) ? true : false;
			$pretty_date = get_date_from_gmt(gmdate('Y-m-d H:i:s', (int) $key), 'M d, Y G:i');
			$esc_pretty_date = esc_attr($pretty_date);
			$nonce = $backup['nonce'];
			$jobdata = $updraftplus->jobdata_getarray($nonce);
			$date_label = $updraftplus_admin->date_label($pretty_date, $key, $backup, $jobdata, $nonce, true);
			// Remote backups with no log result in useless empty rows. However, not showing anything messes up the "Existing Backups (14)" display, until we tweak that code to count differently
			if ($remote_sent) {
				$backup_entities = __('Backup sent to remote site - not available for download.', 'updraftplus');
				if (!empty($backup['remotesend_url'])) {
					$backup_entities .= ' '.__('Site', 'updraftplus').': '.htmlspecialchars($backup['remotesend_url']);
				}
			} else {
				$row_backup_entities = array();
				$backup_entities_row = $this->get_backup_entities_row($backup, $accept);
				$backup_entities = implode(', ', $backup_entities_row);
			}
			
			$job_identifier = strip_tags($date_label).' ['.$nonce.']';
			if (!empty($backup['service'])) {
				 $job_identifier .= ' ('.implode(',', $backup['service']).')';
			}
			$items[] = array(
				'job_identifier'  => $job_identifier,
				'nonce'           => $nonce,
				'backup_entities' => $backup_entities,
			);
		}
		// @codingStandardsIgnoreLine
		WP_CLI\Utils\format_items('table', $items, array('job_identifier', 'nonce', 'backup_entities'));
	}

	/**
	 * Gets the last full backup in the backup history
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus get_latest_full_backup
	 *
	 * @when after_wp_load
	 */
	public function get_latest_full_backup() {
		$nonce = UpdraftPlus_Backup_History::get_latest_full_backup();
		if (empty($nonce)) WP_CLI::error(__('No previous full backup found.', 'updraftplus'), true);
		WP_CLI::success(__("Latest full backup found; identifier:", 'updraftplus') . " {$nonce}");
	}
	
	/**
	 * Get backup entities for existing backup table
	 *
	 * @param array $backup - backup entity row
	 * @param array $accept
	 *
	 * @return array $backup_entities_row - backup entities for rxisting_backup table
	 */
	private function get_backup_entities_row($backup, $accept) {
		$backup_entities_row = array();
		if (false === ($updraftplus = $this->_load_ud())) return new WP_Error('no_updraftplus');
		if (empty($backup['meta_foreign']) || !empty($accept[$backup['meta_foreign']]['separatedb'])) {
			if (isset($backup['db'])) {
				// Set a flag according to whether or not $backup['db'] ends in .crypt, then pick this up in the display of the decrypt field.
				$db = is_array($backup['db']) ? $backup['db'][0] : $backup['db'];
				if (!empty($backup['meta_foreign']) && isset($accept[$backup['meta_foreign']])) {
					$desc_source = $accept[$backup['meta_foreign']]['desc'];
				} else {
					$desc_source = __('unknown source', 'updraftplus');
				}
				$backup_entities_row[] = empty($backup['meta_foreign']) ? esc_attr(__('Database', 'updraftplus')) : (sprintf(__('Database (created by %s)', 'updraftplus'), $desc_source));
			}

			// External databases
			foreach ($backup as $bkey => $binfo) {
				if ('db' == $bkey || 'db' != substr($bkey, 0, 2) || '-size' == substr($bkey, -5, 5)) continue;
				$backup_entities_row[] = __('External database', 'updraftplus').' ('.substr($bkey, 2).')';
			}
		}
		$backupable_entities = $updraftplus->get_backupable_file_entities(true, true);
		foreach ($backupable_entities as $type => $info) {
			if (!empty($backup['meta_foreign']) && 'wpcore' != $type) continue;
			if ('wpcore' == $type) $wpcore_restore_descrip = $info['description'];
			if (empty($backup['meta_foreign'])) {
				$sdescrip = preg_replace('/ \(.*\)$/', '', $info['description']);
				if (strlen($sdescrip) > 20 && isset($info['shortdescription'])) $sdescrip = $info['shortdescription'];
			} else {
				$info['description'] = 'WordPress';
				$sdescrip = (empty($accept[$backup['meta_foreign']]['separatedb'])) ? sprintf(__('Files and database WordPress backup (created by %s)', 'updraftplus'), $desc_source) : sprintf(__('Files backup (created by %s)', 'updraftplus'), $desc_source);
				if ('wpcore' == $type) $wpcore_restore_descrip = $sdescrip;
			}
			if (isset($backup[$type])) {
				if (!is_array($backup[$type])) $backup[$type] = array($backup[$type]);
				$howmanyinset = count($backup[$type]);
				$expected_index = 0;
				$index_missing = false;
				$set_contents = '';
				if (!isset($entities)) $entities = '';
				$entities .= "/$type=";
				$whatfiles = $backup[$type];
				ksort($whatfiles);
				foreach ($whatfiles as $findex => $bfile) {
					$set_contents .= ('' == $set_contents) ? $findex : ",$findex";
					if ($findex != $expected_index) $index_missing = true;
					$expected_index++;
				}
				$entities .= $set_contents.'/';
				if (!empty($backup['meta_foreign'])) {
					$entities .= '/plugins=0//themes=0//uploads=0//others=0/';
				}
				$printing_first = true;
				foreach ($whatfiles as $findex => $bfile) {
					$pdescrip = ($findex > 0) ? $sdescrip.' ('.($findex+1).')' : $sdescrip;
					$backup_entities_row[] = $pdescrip;
				}
			}
		}
		return $backup_entities_row;
	}
	
	/**
	 * Rescan storage either local or remote
	 *
	 * ## OPTIONS
	 *
	 * <type>
	 * : Type of rescan storage. Its value should be either local or remote
		---
		default: remote
		options:
		  - remote
		  - local
		---
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus rescan-storage local
	 * wp updraftplus rescan-storage remote
	 *
	 * @subcommand rescan-storage
	 * @alias rescan_storage
	 * @when after_wp_load
	 *
	 * @param Array $args A indexed array of command line arguments
	 */
	public function rescan_storage($args) {
		$args_what_rescan = empty($args[0]) ? 'remote' : $args[0];
		if (!in_array($args_what_rescan, array('remote', 'local'))) {
			WP_CLI::error(sprintf(__("The given value for the '%s' option is not valid", 'updraftplus'), 'scan type'), true);
		}
		$what_rescan = ('remote' == $args_what_rescan) ? 'remotescan' : 'rescan';
		$this->set_commands_object();
		$history_statuses = $this->commands->rescan($what_rescan);
		if (!empty($history_statuses['n'])) {
			WP_CLI::success(__('Success', 'updraftplus'));
			WP_CLI::runcommand('updraftplus existing_backups');
		} else {
			WP_CLI::error(__('Error', 'updraftplus'));
		}
	}

	/**
	 * Creates a RSA keypair for migration one part is saved the other part needs to be copied/sent to the remote site.
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : the name of the key
	 *
	 * <size>
	 * : The size of the key
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus create_migration_key my_key_name 2048
	 *
	 * @when after_wp_load
	 *
	 * @param Array $args - A indexed array of command line arguments
	 */
	public function create_migration_key($args) {
		if (empty($args) || !isset($args[0]) || !isset($args[1])) WP_CLI::error(__("Missing parameters", 'updraftplus'));

		$data = array(
			'name' => $args[0],
			'size' => $args[1],
			'return_instead_of_echo' => true
		);

		$key = apply_filters('updraft_migrate_key_create_return', '', $data);

		WP_CLI::success(__("Migration key created:", 'updraftplus'));
		WP_CLI::log($key);
	}
	
	/**
	 * Restore a backup
	 *
	 * ## OPTIONS
	 *
	 * <nonce>
	 * : A nonce of backup which you would like to restore
	 *
	 * [--components=<components>]
	 * : The components to restore. Multiple component names should separate by comma (,). If you will not pass this argument, UpdraftPlus restore all backup entities which are exist in given backup
	 * ---
	 * default: all
	 * ---
	 *
	 * [--db-decryption-phrase=<db-decryption-phrase>]
	 * : If databse is encypted in the backup, Please give database decryption phrase
	 *
	 * [--over-write-wp-config=<over-write-wp-config>]
	 * : Whether wp-config.php file will be overwritten or not. This option will work if you have installed the "More files" addon.
	 *
	 * [--incremental-restore-point=<incremental-restore-point>]
	 * : Incremental restore point.  This option will work if you have installed the "Support for incremental backups" addon.
	 *
	 * [--migration=<migration>]
	 * : Whether restore is migration or not. If you are restoring another site backup, This options' value will be considered Otherwise ignored. This option will work if you have installed the "Migrator" addon.
	 *
	 * [--site-id-to-restore=<site-id-to-restore>]
	 * : To restore backup to specific site in a Multisite setup. The option value -1 is for restoring all sites. If you are restoring a Multisite backup, This options' value will be considered Otherwise ignored. this option only affects the restoration of the database and uploads - other file entities (such as plugins) in WordPress are shared by the whole network. This option will work if you have installed the "Network / Multisite" addon.
	 *
	 * [--delete-during-restore=<delete-during-restore>]
	 * : Delete a backup archives during the restore process as it proceeds. This is to minimise disk space use, so the restore can support as large a backup as possible.
	 *
	 * ## EXAMPLES
	 *
	 * wp updraftplus restore b290ee083e9e --component="db,plugins,themes" --db-decryption-phrase=="test"
	 *
	 * @subcommand restore
	 * @when after_wp_load
	 *
	 * @param Array $args       A indexed array of command line arguments
	 * @param Array $assoc_args Key value pair of command line arguments
	 */
	public function restore($args, $assoc_args) {
		global $updraftplus_restorer;
		if (false === ($updraftplus = $this->_load_ud())) return new WP_Error('no_updraftplus');
		if (false === ($updraftplus_admin = $this->_load_ud_admin())) return new WP_Error('no_updraftplus');
		
		$nonce = trim($args[0]);
		$components = $assoc_args['components'];
		$backup_set = UpdraftPlus_Backup_History::get_backup_set_by_nonce($nonce);
		if (empty($backup_set)) {
			// __('No such backup set exists', 'updraftplus')
			WP_CLI::error(__('No such backup set exists', 'updraftplus'), true);
		}
		
		if ('all' == $components) {
			$valid_restore_components = $this->get_valid_restore_components();
			$components_arr = array();
			foreach ($backup_set as $backup_info_key => $backup_info_val) {
				if (in_array($backup_info_key, $valid_restore_components)) {
					$components_arr[] = $backup_info_key;
				}
			}
		} else {
			$components_arr = array_unique(array_map('trim', array_filter(explode(',', $components))));
			// Sometime users uses database instead of db
			if (false !== ($database_element_key = array_search('database', $components_arr))) {
				$components_arr[$database_element_key] = 'db';
			}
			foreach ($components_arr as $component) {
				if (empty($backup_set[$component])) {
					WP_CLI::error(sprintf(__("The given value for the '%s' option is not valid", 'updraftplus'), 'components'), true);
				}
			}
		}
		
		if (in_array('db', $components_arr)) {
			if (is_array($backup_set['db'])) {
				$db_backup_name = $backup_set['db'][0];
			} else {
				$db_backup_name = $backup_set['db'];
			}
		}
		
		// Setup wp file system
		$wp_filesystem = $this->init_wp_filesystem();
		
		WP_CLI::log(__('UpdraftPlus Restoration: Progress', 'updraftplus'));

		// Set up job ID, time and logging
		$updraftplus->backup_time_nonce();
		$updraftplus->jobdata_set('job_type', 'restore');
		$updraftplus->jobdata_set('job_time_ms', $updraftplus->job_time_ms);
		$updraftplus->logfile_open($updraftplus->nonce);

		// Provide download link for the log file
		$log_url = add_query_arg(
			array(
				'page' => 'updraftplus',
				'action' => 'downloadlog',
				'updraftplus_backup_nonce' => $updraftplus->nonce,
			),
			UpdraftPlus_Options::admin_page_url()
		);
		WP_CLI::log(__('Follow this link to download the log file for this restoration (needed for any support requests).', 'updraftplus').': '.$log_url);
		WP_CLI::log(__('Run this command to see the log file for this restoration (needed for any support requests).', 'updraftplus').': wp updraftplus get_log '.htmlspecialchars($updraftplus->nonce));
		
		$entities_to_restore = array();
		foreach ($components_arr as $component) {
			$entities_to_restore[$component] = $component;
		}
		
		// This will be removed by self::post_restore_clean_up()
		set_error_handler(array($updraftplus, 'php_error'), E_ALL & ~E_STRICT);
		// Gather the restore options into one place - code after here should read the options, and not the HTTP variables
		$restore_options = array();
		$restore_options['updraft_encryptionphrase'] = empty($assoc_args['db-decryption-phrase']) ? '' : $assoc_args['db-decryption-phrase'];
		if (class_exists('UpdraftPlus_Addons_MoreFiles')) {
			if (isset($assoc_args['over-write-wp-config'])) {
				if (in_array('wpcore', $components_arr)) {
					if (isset($assoc_args['over-write-wp-config'])) {
						$restore_options['updraft_restorer_wpcore_includewpconfig'] = filter_var($assoc_args['over-write-wp-config'], FILTER_VALIDATE_BOOLEAN) ? true : false;
					}
				}
			} else {
				if (in_array('wpcore', $components_arr)) {
					$restore_options['updraft_restorer_wpcore_includewpconfig'] = false;
				}
			}
		} else {
			if (isset($assoc_args['over-write-wp-config'])) {
				$this->addon_not_exist_error('over-write-wp-config', 'More files', 'https://updraftplus.com/shop/more-files/');
			}
		}
		list ($mess, $warn, $err, $info) = $updraftplus->analyse_db_file($backup_set['timestamp'], array());
		if (class_exists('UpdraftPlus_Addons_Migrator')) {
			if (!empty($info['migration'])) {
				if (isset($assoc_args['migration'])) {
					$restore_options['updraft_restorer_replacesiteurl'] = filter_var($assoc_args['migration'], FILTER_VALIDATE_BOOLEAN) ? true : false;
				} else {
					$restore_options['updraft_restorer_replacesiteurl'] = true;
				}
			}
		} else {
			if (isset($assoc_args['migration'])) {
				$this->addon_not_exist_error('migration', 'Migrator', 'https://updraftplus.com/shop/migrator/');
			}
		}
		if (class_exists('UpdraftPlusAddOn_MultiSite')) {
			if (!empty($info['multisite']) && (in_array('db', $components_arr) || in_array('uploads', $components_arr))) {
				$valid_site_ids = $this->get_valid_site_ids();
				if (isset($assoc_args['site-id-to-restore'])) {
					$site_id_to_restore = $assoc_args['site-id-to-restore'];
					if (in_array($site_id_to_restore, $valid_site_ids)) {
						$restore_options['updraft_restore_ms_whichsites'] = $site_id_to_restore;
					} else {
						WP_CLI::error(sprintf(__("The given value for the '%s' option is not valid", 'updraftplus'), 'site-id-to-restore'), true);
					}
				} else {
					$restore_options['updraft_restore_ms_whichsites'] = -1;
				}
			}
		} else {
			if (isset($assoc_args['site-id-to-restore'])) {
				$this->addon_not_exist_error('site-id-to-restore', 'Network / Multisite', 'https://updraftplus.com/shop/network-multisite/');
			}
		}
		
		if (class_exists('UpdraftPlus_Addons_Incremental')) {
			if (isset($assoc_args['incremental-restore-point'])) {
				$incremental_restore_point = (int) $assoc_args['incremental-restore-point'];
				if (isset($backup_set[$timestamp]['incremental_sets'])) {
					$incremental_sets = array_keys($backups[$timestamp]['incremental_sets']);
					if (in_array($incremental_restore_point, $incremental_sets)) {
						$restore_options['incremental-restore-point'] = $incremental_restore_point;
					} else {
						WP_CLI::error(__('This is not an incremental backup', 'updraftplus'), true);
					}
				} else {
					WP_CLI::error(sprintf(__("The given value for the '%s' option is not valid", 'updraftplus'), 'incremental-restore-point'), true);
					WP_CLI::error(__('This is not an incremental backup', 'updraftplus'), true);
				}
			} else {
				$restore_options['incremental-restore-point'] = -1;
			}
		} elseif (isset($assoc_args['incremental-restore-point'])) {
			// TO DO: When we will sell incremental addon, Please change third parameter $addon_buy_url
			$this->addon_not_exist_error('incremental-restore-point', 'Support for incremental backups', 'https://updraftplus.com/shop/');
		}
		
		if (isset($assoc_args['delete-during-restore'])) {
			$restore_options['delete_during_restore'] = filter_var($assoc_args['delete-during-restore'], FILTER_VALIDATE_BOOLEAN) ? true : false;
		} else {
			$restore_options['delete_during_restore'] = false;
		}
		$updraftplus->jobdata_set('restore_options', $restore_options);
			
		// If updraft_incremental_restore_point is equal to -1 then this is either not a incremental restore or we are going to restore up to the latest increment, so there is no need to prune the backup set of any unwanted backup archives.
		if (isset($restore_options['updraft_incremental_restore_point']) && $restore_options['updraft_incremental_restore_point'] > 0) {
			$restore_point = $restore_options['updraft_incremental_restore_point'];
			foreach ($backup_set['incremental_sets'] as $increment_timestamp => $entities) {
				if ($increment_timestamp > $restore_point) {
					foreach ($entities as $entity => $backups) {
						foreach ($backups as $key => $value) {
							unset($backup_set[$entity][$key]);
						}
					}
				}
			}
		}
		
		// Restore in the most helpful order
		uksort($backup_set, array('UpdraftPlus_Manipulation_Functions', 'sort_restoration_entities'));
		// Now log. We first remove any encryption passphrase from the log data.
		$copy_restore_options = $restore_options;
		if (!empty($copy_restore_options['updraft_encryptionphrase'])) $copy_restore_options['updraft_encryptionphrase'] = '***';
		WP_CLI::log("Restore job started. Entities to restore: ".implode(', ', array_flip($entities_to_restore)).'. Restore options: '.json_encode($copy_restore_options));
		
		// We use a single object for each entity, because we want to store information about the backup set
		if (!class_exists('Updraft_Restorer')) include_once(UPDRAFTPLUS_DIR.'/restorer.php');

		WP_CLI::log(__('Final checks', 'updraftplus'));

		$updraftplus_restorer = new Updraft_Restorer(new Updraft_Restorer_Skin(), $backup_set, false, $restore_options);
		
		add_action('updraftplus_restoration_title', array($this, 'restoration_title'));
		$restore_result = $updraftplus_restorer->perform_restore($entities_to_restore, $restore_options);
		
		if (is_wp_error($restore_result)) {
			foreach ($restore_result->get_error_codes() as $code) {
				if ('already_exists' == $code) WP_CLI::error(__('Your WordPress install has old directories from its state before you restored/migrated (technical information: these are suffixed with -old).', 'updraftplus'));
				$data = $restore_result->get_error_data($code);
				if (!empty($data)) {
					$pdata = is_string($data) ? $data : serialize($data);
					$updraftplus->log(__('Error data:', 'updraftplus').' '.$pdata, 'warning-restore');
					if (false !== strpos($pdata, 'PCLZIP_ERR_BAD_FORMAT (-10)')) {
						$url = apply_filters('updraftplus_com_link', "https://updraftplus.com/faqs/error-message-pclzip_err_bad_format-10-invalid-archive-structure-mean/");
						WP_CLI::log(__('Follow this link for more information', 'updraftplus').': '.$url);
					}
				}
			}
		}
		
		if (true === $restore_result) {
			$updraftplus_admin->post_restore_clean_up(true, false);
		} else {
			$updraftplus_admin->post_restore_clean_up(false, false);
		}
		
		if (true === $restore_result) {
			UpdraftPlus_Backup_History::rebuild();
			$updraftplus->log_e('Restore successful!');
			$updraftplus->log("Restore successful");
		} elseif (is_wp_error($restore_result)) {
			$updraftplus->log_e('Restore failed...');
			$updraftplus->log_wp_error($restore_result);
			$updraftplus->log('Restore failed');
		} elseif (false === $restore_result) {
			$updraftplus->log_e('Restore failed...');
		}
	}
	
	/**
	 * Displays error message for relevant addon is not exist for a given option to command
	 *
	 * @param string $option        Option passed to coomand which is not supported without addon
	 * @param string $addon_title   Addon title
	 * @param string $addon_buy_url Addon buy link which is not filtered for affiliate
	 */
	private function addon_not_exist_error($option, $addon_title, $addon_buy_url) {
		$filtered_addon_buy_url = apply_filters('updraftplus_com_link', $addon_buy_url);
		WP_CLI::error(sprintf(__('You have given the %1$s option. The %1$s is working with "%2$s" addon. Get the "%2$s" addon: %3$s', 'updraftplus'), $option, $addon_title, $filtered_addon_buy_url), true);
	}
	
	/**
	 * Called when the restore process wants to print a title
	 *
	 * @param String $title - title
	 */
	public function restoration_title($title) {
		WP_CLI::log(str_repeat(".", 80));
		WP_CLI::log($title);
		WP_CLI::log(str_repeat(".", 80));
	}
	
	/**
	 * Get valid restore componenets
	 *
	 * @return Array An array which have valid restore components as values
	 */
	private function get_valid_restore_components() {
		global $updraftplus;
		$backupable_entities = $updraftplus->get_backupable_file_entities(true, false);
		// more files can't be restore
		unset($backupable_entities['more']);
		$valid_restore_components = array_keys($backupable_entities);
		$valid_restore_components[] = 'db';
		return $valid_restore_components;
	}
	
	/**
	 * Get valid site ids in a Multisite restore
	 *
	 * @return Array An array which have valid site ids as values
	 */
	private function get_valid_site_ids() {
		$valid_site_ids = array( -1 );
		// Check to see if latest get_sites (available on WP version >= 4.6) function is
		// available to pull any available sites from the current WP instance. If not, then
		// we're going to use the fallback function wp_get_sites (for older version).
		if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
			$network_sites = get_sites();
		} else {
			if (function_exists('wp_get_sites')) {
				$network_sites = wp_get_sites();
			}
		}
		
		// We only process if sites array is not empty, otherwise, bypass
		// the next block.
		if (!empty($network_sites)) {
			foreach ($network_sites as $site) {
				
				// Here we're checking if the site type is an array, because
				// we're pulling the blog_id property based on the type of
				// site returned.
				// get_sites returns an array of object, whereas the wp_get_sites
				// function returns an array of array.
				$valid_site_ids[] = is_array($site) ? $site['blog_id'] : $site->blog_id;
			}
		}
		return $valid_site_ids;
	}
	
	/**
	 * Initialize WP Filesystem
	 *
	 * @return object WP_Filesystem instance
	 */
	private function init_wp_filesystem() {
		global $wp_filesystem;
		WP_Filesystem();
		if ($wp_filesystem->errors->get_error_code()) {
			$url = apply_filters('updraftplus_com_link', "https://updraftplus.com/faqs/asked-ftp-details-upon-restorationmigration-updates/").'">';
			WP_CLI::error(__('Why am I seeing this?', 'updraftplus').': '.$url, false);
			foreach ($wp_filesystem->errors->get_error_messages() as $message) {
				WP_CLI::error($message, false);
			}
			exit;
		}
		return $wp_filesystem;
	}
}

WP_CLI::add_command('updraftplus', 'UpdraftPlus_CLI_Command');
