<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

add_action('admin_menu', 'wcdc_register_disable_cat_page');

if (!function_exists('wcdc_register_disable_cat_page')) {

    function wcdc_register_disable_cat_page() {
        //add_submenu_page('TogiData Woo Categories', 'TogiData Woo Categories', 10, 'togi_woo_categories', 'togi_woo_categories','dashicons-networking');
        if(current_user_can('administrator') || current_user_can('shop_manager'))
            add_submenu_page('edit.php?post_type=product', __('Category Tree', "wc-disable-categories"), __('Category Tree', "wc-disable-categories"), 'manage_options', 'togi_woo_categories', 'wcdc_fun_togi_woo_categories');
    }

}

if (!function_exists('wcdc_getSubCat')) {

    function wcdc_getSubCat($category) {
        $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_url($thumbnail_id);
        //$image = '';
        $args = array(
            'option_none_value'  => '-1',
            'orderby'            => 'ID',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 0,
            'echo'               => 0,
            'exclude'            => array($category->term_id),
            'selected'           => $category->category_parent,
            'hierarchical'       => 1,
            'name'               => 'parent',
            'taxonomy'           => 'product_cat',
            'hide_if_empty'      => false,
            'value_field'        => 'term_id',
        ); 

        echo '<li id="recordsArray_' . $category->term_id . '" categ-id="'.$category->term_id .'" class=""><div class="ace-li-inner"><div class="ace-links-parent">
        <div class="ace-category-start"><div class="ace-cname"> ' . $category->name . '<span class="ace-links"><a target="_blank" href="' . get_admin_url() . 'edit-tags.php?action=edit&taxonomy=product_cat&tag_ID=' . $category->term_id . '&post_type=product">' . __("Edit", "wc-disable-categories") . '</a> <a href="javascript:void(0);" class="ace-quick-edit category_click" clicked-id="'.$category->term_id.'" selected-id="'.$category->category_parent.'" >' . __("Quick Edit", "wc-disable-categories") . '</a> <a href="' . get_term_link($category->term_id) . '" target="_blank">' . __("View", "wc-disable-categories") . '</a>';


        echo ' <a href="javascript:void(0);" onclick="deleteli(' . $category->term_id . ')" id="cat_delete" class=""> ' . __("Delete", "wc-disable-categories") . '</a>';


        echo '</span> </div><div class="ace-cdescription"> ' . substr(strip_tags($category->description), 0, 30) . '</div><div class="ace-cimage">';
        if ($image) {
            echo '<a class="lightbox" href="' . $image . '"><img src="' . $image . '" alt="cat-thumb"/></a>';
        } else {
            echo '<img src="' . WCDC_PLUGIN_URL . '/assets/images/placeholder.png" alt="catthumb"/>';
        }

        echo '</div>';

        //Customized by 2hats.
        $disabledCats = get_option('woo_disabled_categories');
        echo '<div class="ace-cstatus" style="float:left;">';
        if (!empty($disabledCats) && is_array($disabledCats) && in_array($category->term_id, $disabledCats)) {
            $queryArgs = add_query_arg(array(
                'woo-action' => 'activate-cat',
                'wooCatId' => $category->term_id,
                'goTo' => 0,
            ));
            echo '<img src="' . WCDC_PLUGIN_URL . '/assets/images/disable.png" alt="' . __("Is deactive", "wc-disable-categories") . '" data-tip="' . __("The functionality for deactivating categories is only available in the pro version.", "wc-disable-categories") . '" class="help_tip pro-notice" />';
        } else {
            $queryArgs = add_query_arg(array(
                'woo-action' => 'deactivate-cat',
                'wooCatId' => $category->term_id,
                'goTo' => 0,
            ));
            echo '<img src="' . WCDC_PLUGIN_URL . '/assets/images/enable.png" alt="' . __("Is active", "wc-disable-categories") . '" data-tip="' . __("The functionality for deactivating categories is only available in the pro version.", "wc-disable-categories") . '" class="help_tip pro-notice" />';
        }
        echo '</div>';
        //Customized by 2hats. ends..

        echo '<div class="ace-cslug"> ' . $category->slug . '</div><div class="ace-ccount"><a href="/?product_cat=' . $category->slug . '" target="_blank">' . $category->count . '</a></div>

        </div></div>';
        echo '<div class="quick_edit_form" id="ct_qe_'. $category->term_id.'"></div>';
    }

}

  //  add_action('admin_footer',  'my_admin_add_js_media',100);
function my_admin_add_js_media() {
 if(function_exists( 'wp_enqueue_media' )){
    wp_enqueue_media();
}else{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
}

//add_action('admin_print_footer_scripts',  'my_admin_add_js',100);
function my_admin_add_js() {

    ?>
    <!--     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  -->
    <script type="application/javascript">
        jQuery(document).ready(function($){
            var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
            $('#btn_upload').click(function(e) {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                _custom_media = true;
                wp.media.editor.send.attachment = function(props, attachment){
                    if ( _custom_media ) {
                        $("#txt_imageurl").val(attachment.url);
                    } else {
                        return _orig_send_attachment.apply( this, [props, attachment] );
                    };
                }
                wp.media.editor.open(this);
                return false;
            });
        });
    </script>

    <input type="text" name="txt_imageurl" id="txt_imageurl" />
    <input type="button" class="button btn_upload" name="btn_upload" id="btn_upload" value="Upload" />
    <?php
}

function arthur_image_uploader( $name) {

   $thumbnail_id = get_woocommerce_term_meta($name, 'thumbnail_id', true);
   $image = wp_get_attachment_url($thumbnail_id);
    // Set variables
   $options = get_option( 'categ_image' );
   $default_image = plugins_url('../img/placeholder.png', __FILE__);

   if ( $image!='' ) {

    $src = $image;
    $value = $options[$name];
} else {
    $src = $default_image;
    $value = '';
}

$text = __( 'Upload' );

    // Print HTML field
return '<div class="upload"><img data-src="' . $default_image . '" src="' . $src . '" style="max-width : 100px;" /><div><input type="hidden" name="categ_image[' . $name . ']" id="categ_image[' . $name . ']" value="' . $src . '" /><input type="hidden" class="hd_attachment_id" name="categ_image_id[' . $name . ']" id="categ_image_id[' . $name . ']" value="' . $thumbnail_id . '" /><button type="button" id="upload_image_button_' . $name . '" class="upload_image_button button" data-id="'.$name.'"  onclick="load_image_for_edit(' . $name . ')" >' . $text . '</button><button type="button" class="remove_image_button button"  onclick="remove_image_for_edit(' . $name . ')">&times;</button></div></div>';
}
function arthur_load_scripts_admin() {

    // WordPress library
    wp_enqueue_media();


}
add_action( 'admin_enqueue_scripts', 'arthur_load_scripts_admin' );

add_action('admin_footer','add_script_footer');

function add_script_footer() {
    if(isset($_GET['page']) && $_GET['page']=='togi_woo_categories') {
        // $args = array(
        //     'option_none_value'  => '-1',
        //     'orderby'            => 'ID',
        //     'order'              => 'ASC',
        //     'show_count'         => 0,
        //     'hide_empty'         => 0,
        //     'echo'               => 0,
        //     'hierarchical'       => 1,
        //     'name'               => 'parent',
        //     'taxonomy'           => 'product_cat',
        //     'hide_if_empty'      => false,
        //     'value_field'        => 'term_id',
        // ); 
        // $str = str_replace('\n', '', wp_dropdown_categories($args));
        // $str = str_replace('\r', '', $str);
        // $str = str_replace('\r\n\/', '', $str);
        // $str = str_replace(PHP_EOL, '', $str);
        // $str = str_replace("'", '"', $str);
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('img.wp-post-image').each(function() {
                    if(jQuery(this).attr('src')==''){ jQuery(this).attr('src','<?php echo site_url('wp-content/plugins/woocommerce/assets/images/placeholder.png'); ?>'); }
                });

                jQuery(".tips, .help_tip").tipTip({attribute:"data-tip",fadeIn:50,fadeOut:50,delay:200});
                jQuery('.category_click').click(function () {
                    var id= jQuery(this).attr('clicked-id');
                    var selected= jQuery(this).attr('selected-id');

                    // jQuery('.category_'+id).html('<?php echo ($str); ?>');
                    
                    // jQuery('.category_'+id+' select').val(selected);
                    // jQuery('.category_'+id+' select').prepend('<option value="0">Parent Category</option>');

                    // var data = {
                    //     'action': 'load_edit_image',
                    //     'term_id': id
                    // };
                    // jQuery.post(ajaxurl, data, function(response) {
                    //     jQuery('.image_loader_'+id).html(response);

                    // });
                    jQuery('.quick_edit_form').html('');
                    jQuery('#ct_qe_'+id).html('Loading data...');
                    var data = {
                        'action': 'quick_edit_form',
                        'term_id': id
                    };
                    jQuery.post(ajaxurl, data, function(response) {
                        jQuery('#ct_qe_'+id).html(response);
                        jQuery('.selectparent select#parent').prepend('<option value="0">Parent Category</option>');
                        jQuery('.selectparent select#parent').val(jQuery('#hd_parent_'+id).val());
                    });

                    
                });

            });
            function success() {
                jQuery.notify({
                    title: '<?php echo __('Done', "wc-disable-categories"); ?>',
                    text: '<?php echo __('Successfully edited a category!', "wc-disable-categories"); ?>',
                    image: "<h1  style='color : #fff'>&times;</h1>"
                }, {
                    style: 'metro',
                    className: 'success',
                    autoHide: false,
                    clickToHide: true
                });
                jQuery('.notifyjs-corner').css('top',30);
                setTimeout(function(){ 
                    jQuery('.notifyjs-corner').fadeOut(500);
                }, 3000);
            }
            function error() {
                jQuery.notify({
                    title: '<?php echo __('Done', "wc-disable-categories"); ?>',
                    text: '<?php echo __('Successfully deleted one item', "wc-disable-categories"); ?>',
                    image: "<h1 style='color : #fff;'>&times;</h1>"
                }, {
                    style: 'metro',
                    className: 'error',
                    autoHide: false,
                    clickToHide: true
                });
                jQuery('.notifyjs-corner').css('top',30);
                setTimeout(function(){ 
                    jQuery('.notifyjs-corner').fadeOut(500);
                }, 3000);
            }
        </script>
        <?php
    }
}


add_action( 'wp_ajax_load_edit_image', 'load_edit_image' );
add_action( 'wp_ajax_nopriv_load_edit_image', 'load_edit_image' );

function load_edit_image() {
    if(isset($_POST['term_id'])) {
        echo arthur_image_uploader($_POST['term_id']);
    } 
    exit;
}

add_action( 'wp_ajax_quick_edit_form', 'quick_edit_form' );
add_action( 'wp_ajax_nopriv_quick_edit_form', 'quick_edit_form' );

function quick_edit_form($term_id) {
    if(isset($_POST['term_id'])) {
        $term_id = $_POST['term_id'];
        $category = get_term_by( 'term_id', $term_id,'product_cat');
        $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_url($thumbnail_id);
        $args = array(
            'option_none_value'  => '-1',
            'orderby'            => 'ID',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 0,
            'echo'               => 0,
            'exclude'            => array($term_id),
            'selected'           => $category->parent,
            'hierarchical'       => 1,
            'name'               => 'parent',
            'taxonomy'           => 'product_cat',
            'hide_if_empty'      => false,
            'value_field'        => 'term_id',
        ); 
        echo '<form class="ace-cat-update-form" enctype="multipart/form-data" style="display:block;" name="update-cat" method="post" action="' . get_admin_url() . 'admin.php?page=togi_woo_categories">
        <input type="hidden" name="cid" value="' . $category->term_id . '">

        <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;overflow:hidden;word-break:normal;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;overflow:hidden;word-break:normal;}
        .tg .tg-yw4l{vertical-align:top}
        </style>
        <table class="tg">
        <tr>
        <th class="tg-yw4l">' .  __("Name", "wc-disable-categories") . '</th>
        <th class="tg-yw4l"><input type="text" name="cname" value="' . $category->name . '"></th>
        <td class="tg-yw4l" rowspan="3">'.arthur_image_uploader($category->term_id).     '</td>
        </tr>
        <tr>
        <td class="tg-yw4l">' . __("Slug", "wc-disable-categories") . '</td>
        <td class="tg-yw4l"><input type="text" name="slug" value="' . $category->slug . '"></td>
        </tr>
        <tr>
        <td class="tg-yw4l">' . __("Parent Category", "wc-disable-categories") . '</td>
        <td class="tg-yw4l selectparent">'. wp_dropdown_categories($args).'<input type="hidden" id="hd_parent_'.$category->term_id.'" class="hd_parent" name="hd_parent" value="'.$category->parent.'"></td>
        </tr>
        <tr>
        <td class="tg-yw4l"></td>
        <td class="tg-yw4l"></td>
        <td class="tg-yw4l"><input class="button button-primary" type="submit" name="acesubmit" value="' . __("Update", "wc-disable-categories") . '">
        <input type="button" name="cancel" value="' . __("Cancel", "wc-disable-categories") . '" class="ace-form-close button button-primary"/></td>

        </tr>

        </table>
        </form>';
    }
    exit();

}