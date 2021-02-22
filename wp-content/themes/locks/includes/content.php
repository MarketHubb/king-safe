<?php

function compare_published_updated_dates($post_id) {
    $dates = [];
    $published_time = strtotime(get_the_date('', $post_id));
    $updated_time = strtotime(get_the_modified_date('', $post_id));
    $date_diff = $updated_time - $published_time;
    $days_diff = round($date_diff / (60 * 60 * 24));

    if ($days_diff > 30) {
        $dates['updated'] = get_the_modified_date('', $post_id);
    } else {
        $dates['published'] = get_the_date('', $post_id);
    }

    return $dates;
}

function get_first_category($post_id)
{
    $categories = get_the_category($post_id);
    return $categories[0];
}

function get_full_width_hero($hero_args=array())
{
    $gradient  = 'linear-gradient(to left,';
    $gradient .= 'rgba(0,0,0,0) 50%,#111 58%,#111 70%,#111 100%)';

    $opacity = isset($args['opacity']) ? $args['opacity'] : $hero['banner_image_opacity'];
    $bg_opacity = (isset($opacity) && $opacity > 0) ? $opacity : .75;
    $linear_gradient = 'linear-gradient(to bottom, rgba(0,0,0,' .  $bg_opacity . ') 0%,rgba(0,0,0,' . $bg_opacity . ') 100%)';

    $bg_opacity = .8;
    $linear_gradient = 'linear-gradient(to bottom, rgba(0,0,0,' .  $bg_opacity . ') 0%,rgba(0,0,0,' . $bg_opacity . ') 100%)';

    $hero  = '<div class="jumbotron bg-cover"';
    $hero .= 'style="background-image: ' . $gradient . ',';
//    $hero .= 'url(' . $hero_args['image'] . ')">';
    $hero .= 'url(' . 'http://ksl.test/wp-content/uploads/2021/01/Locksmith-Modal-Banner.jpg' . ')">';
    $hero .= '<div class="container">';
    $hero .= '<div class="row justify-content-start">';
    $hero .= '<div class="col-md-5">';
    $hero .= '<h1 class="text-white display-5 font-weight-bold my-0">' . $hero_args['heading'] . '</h1>';
    $hero .= '<p class="lead text-white mb-0">' . 'Serving all of Houston & the surrounding communities' . '</p>';
    $hero .= '</div></div></div></div>';

    return $hero;
}

function get_hero_button( $post_id )
{
    $btn_text = get_field('banner_button_text', $post_id);
    $btn_url = get_field('banner_button_type', $post_id) === 'Page' ? get_field('banner_button_link', $post_id) : get_field('banner_button_anchor', $post_id);

    if (get_field('banner_button_data_attributes', $post_id)) {

        if (have_rows('banner_attributes', $post_id)):
            $attr = '';
            while (have_rows('banner_attributes', $post_id)) : the_row();
                $attr_type = get_sub_field('banner_attributes_type', $post_id);

                if ($attr_type === 'image') {
                    $attr_val = get_field('banner_image', $post_id);
                } else {
                    $attr_val = get_sub_field('banner_attributes_value', $post_id);
                }

                $attr .= 'data-' . $attr_type . '="';
                $attr .= $attr_val . '" ';

            endwhile;
        endif;

    }

    if (!empty($btn_url)) {
        $btn = '<a href="' . $btn_url . '" ';
        $btn_close = '</a>';
    } else {
        $btn = '<button type="button"';
        $btn_close = '</button>';
    }

    $btn .= 'class="btn btn-primary font-weight-bold ttu lsw"';
    $btn .= $attr . '>' . $btn_text . '<i class="fas fa-chevron-right pl-2"></i>';
    $btn .= $btn_close;

    return $btn;
}
