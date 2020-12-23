<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// Check if WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
    return;

if (!class_exists('WC_Disable_Categories')) {

    include 'includes/disable-functions.php';
    include 'includes/admin-functions.php';
    include 'includes/main-functions.php';
    include 'includes/updateDB.php';
    include 'includes/class-ads.php';

    define('WCDC_PLUGIN_URL', plugins_url('product-category-tree'));
    define('WCDC_PLUGIN_DIR', plugin_dir_path(__FILE__));
    define('WCDC_PLUGIN_PRO_UPGRADE_URL', 'http://togidata.dk/en/product-category-tree/');

    class WC_Disable_Categories {

        public function __construct() {

            load_plugin_textdomain('wc-disable-categories', false, dirname(plugin_basename(__FILE__)) . '/languages/');

            add_action('admin_enqueue_scripts', array($this, 'action_enqueue_assets_admin'));
            add_action('wp_head', array($this, 'action_enqueue_assets'));
            add_action('plugin_row_meta', array($this, 'add_plugin_meta'), 10, 2);

            add_filter('manage_edit-product_cat_columns', 'wcdc_productCatDisableColumns');
            add_filter('manage_product_cat_custom_column', 'wcdc_productCatDisableColumn', 100, 3);
            add_filter( 'product_cat_row_actions',array($this, 'categ_tree_options'), 10, 2 );
            add_action('admin_footer', array($this, 'categ_tree_admin_add_js'));

            $ads = new WCDC_Admin_Ads();
            $ads->add_hooks();
        }

        public function action_enqueue_assets() {
            wp_register_style('WCDisableCategories-style', WCDC_PLUGIN_URL . '/assets/css/style.css');
            wp_enqueue_style('WCDisableCategories-style');
            wp_enqueue_script('jquery');
        }

        /**
         * Enqueue backend dependencies.
         */
        public function action_enqueue_assets_admin() {
            wp_register_style('WCDisableCategories-style-admin', WCDC_PLUGIN_URL . '/assets/css/admin.css');
            wp_enqueue_style('WCDisableCategories-style-admin');
            wp_register_style('woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION);
            wp_enqueue_style('woocommerce_admin_styles');
            wp_enqueue_script('jquery');
            // Register scripts
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
            wp_register_script('woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin' . $suffix . '.js', array('jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip'), WC_VERSION);
            wp_enqueue_script('woocommerce_admin');
        }

        public function add_plugin_meta($plugin_meta, $plugin_file) {
            if ($plugin_file == 'product-category-tree/init.php') {
                $plugin_meta['upgrade'] = '<a target="_blank" href="https://awesometogi.com/product-category-tree-plugin-for-wordpress/">' . __('Update to pro', 'wc-disable-categories') . '</a>';
            }

            return $plugin_meta;
        }
        public  function categ_tree_options($actions, $tag)
        {
            $actions['edit_in_category_tree'] = '<a href="'.admin_url('edit.php?post_type=product&page=togi_woo_categories&term_id='.$tag->term_id).'" class="facebook_link">' . __('Edit in Category Tree') . '</a>';

            return $actions;
        }


        public function categ_tree_admin_add_js() {
            ?>
            <script>
                jQuery(document).ready(function () {
                    setTimeout(function(){ 
                        var edit_id = <?php echo isset($_GET['term_id']) && $_GET['term_id']>0 ?$_GET['term_id']:0; ?>;
                        if(edit_id>0 ){

                            var res = load_root_parent(edit_id);

                            
                            jQuery('#recordsArray_'+edit_id+' .ace-quick-edit').click();
                        }
                    }, 1000);

                    
                    
                    
                });

                function load_root_parent(categ_id) {

                 var prnt = jQuery('#recordsArray_'+categ_id).closest("ul").attr('parent');
                 jQuery('#recordsArray_'+categ_id+' i').first().click();
                 if(prnt >0) {
                  return load_root_parent(prnt);
              }
              return categ_id;
          }

          function readURL(input,term_id) {
            console.log(input.files);
            if (input.files && input.files[0]) {

                var reader = new FileReader();



                reader.onload = function (e) {

                    jQuery('#img_'+term_id).attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);

            }

        }

        $('.upload_image_button').click(function() {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                $(button).parent().prev().attr('src', attachment.url);
                $(button).prev().val(attachment.id);
                $(button).prev().val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false;
        });

        $('.remove_image_button').click(function() {
            var answer = confirm('Are you sure?');
            if (answer == true) {
                var src = $(this).parent().prev().attr('data-src');
                $(this).parent().prev().attr('src', src);
                $(this).prev().prev().val('');
                $(this).prev().val('');
                error();
                jQuery('.notifyjs-corner').css('top',30);
            }
            return false;
        });

	    function load_image_for_edit(i) {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                var button = jQuery('#upload_image_button_'+i);
                wp.media.editor.send.attachment = function(props, attachment) {
                    jQuery(button).parent().prev().attr('src', attachment.url);
                    jQuery(button).prev().val(attachment.id);
                    jQuery(button).prev().val(attachment.id);
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open(button);
                return false;
            }
            function remove_image_for_edit(id) {
                var answer = confirm('Are you sure?');
                if (answer == true) {
                    var src = jQuery('#upload_image_button_'+id).parent().prev().attr('data-src');
                    jQuery('#upload_image_button_'+id).parent().prev().attr('src', src);
                    jQuery('#upload_image_button_'+id).prev().prev().val('');
                    jQuery('#upload_image_button_'+id).prev().val('');
                    error();
                    jQuery('.notifyjs-corner').css('top',30);
                }
                return false;
            }

    </script>
    <?php

}

}


}
