<?php
$term_name = get_query_var('term_name');
$term_id = get_query_var('term_id');

$query_args = [
    'post_type' => 'product',
    'taxonomy' => $term_name,
    'terms' => $term_id
];

$query = new WP_Query($query_args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        echo get_the_title();
    endwhile;
    wp_reset_postdata();
endif;
?>
