<?php

add_action('wp_ajax_get_hero_for_modal', 'get_hero_for_modal');
add_action('wp_ajax_nopriv_get_hero_for_modal', 'get_hero_for_modal');
function get_hero_for_modal()
{
    if (!empty($_POST['heading']) && !empty($_POST['image'])) {
        global $wp_embed, $post;
        $hero_args = array(
            'heading' => $_POST['heading'],
            'description' => $_POST['description'],
            'image' => $_POST['image']
        );

        echo get_full_width_hero($hero_args);
    }
    die();
}
