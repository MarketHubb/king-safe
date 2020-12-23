<?php
/*
Plugin Name: AMS Google Webmaster Tools
Description: Adds Google Webmaster Tools verification meta-tag.
Author: Manoj Sathyavrathan
Version: 1.1
Text Domain: ams-gwm-tools
*/
namespace AMSGWMT_MS\MANOJ\SATHYAVRATHAN;

// Exit if accessed directly
defined('ABSPATH') or die();

/**
 * Plugin directory
 * @param const, AMSGWMT_DIR
 */
define( 'AMSGWMT_DIR', plugin_dir_path( __FILE__ ) );

class AMSGWMT_MS_GOOGLE_WEBMASTER_TOOLS {

	function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate_webmaster_tools')); // Register hook
		register_deactivation_hook(__FILE__, array($this, 'deactive_webmaster_tools')); // Deactivation hook
		$this->admin_setup();
	}

	// Plugin activation hook
	function activate_webmaster_tools() {
		
	}

	// Plugin deactivation hook
	function deactive_webmaster_tools() {
		delete_option('amsgwmt_setting');
	}

	// Register the setting
	function admin_init_webmaster_tools() {
		register_setting('amsgwmt_webmaster_tools', 'amsgwmt_setting');
	}

	// Options page
	function admin_menu_options_page() {
		if ( ! current_user_can('manage_options') )
			return;
		add_options_page(__('AMS Google Webmaster Tools', 'ams-gwm-tools'), __('AMS Google Webmaster Tools', 'ams-gwm-tools'), 'manage_options', 'amsgwmt_webmaster_tools', array($this, 'options_page_webmaster_tools'));
	}
	
	// Options page content
	function options_page_webmaster_tools() {
		include_once ( AMSGWMT_DIR . '/includes/amsgwmt-options.php' );		
	}

	// AMS Google Webmaster Tools in action
	function webmaster_tools() {
		$gwebmasters_code = get_option('amsgwmt_setting');
		?>

		<!-- AMS Google Webmaster Tools plugin for WordPress -->
		<?php echo $gwebmasters_code ?>

		<?php
	}

	function my_plugin_action_links( $links ) {
	   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=amsgwmt_webmaster_tools') ) .'">Settings</a>';
	   return $links;
	}
	// Initial setup
	function admin_setup() {
		if ( is_admin() ) {
			add_action( 'admin_init', array($this, 'admin_init_webmaster_tools') ); // Register setting hook
			add_action( 'admin_menu', array($this, 'admin_menu_options_page') ); // Options menu page hook
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'my_plugin_action_links') );
		}

		if ( ! is_admin() ) {
			add_action('wp_head', array($this, 'webmaster_tools')); // Display webmaster code
		}
	}
}
// Class initialization
if ( ! ( $amsgwmt_webmaster_manoj_s_vrathan instanceof \AMSGWMT_MS\MANOJ\SATHYAVRATHAN\AMSGWMT_MS_GOOGLE_WEBMASTER_TOOLS ) )
    $amsgwmt_webmaster_manoj_s_vrathan = new \AMSGWMT_MS\MANOJ\SATHYAVRATHAN\AMSGWMT_MS_GOOGLE_WEBMASTER_TOOLS();
?>