<?php /* Template Name: Category - Gun Safes */

get_header(); ?>

<?php get_template_part('template-parts/content', 'banner'); ?>

<?php
$tax_term = 'product_cat';
$gun_safe_terms = [47, 36, 35,38];
$content = '';
foreach ($gun_safe_terms as $term_id) {
    $term =  get_terms([
       'taxonomy' => $tax_term,
       'include' => $term_id
    ]);
    $acf_field_param = $tax_term . '_' . $term[0]->term_id;
    $cat_name = 'AMSEC ' . get_field('categoy_safes_category_name', $acf_field_param);
    $cat_attr = get_field('category_safes_fire_rating', $acf_field_param) . ' Minute Fire Proof Gun Safes';

    $content .= '<div class="bg-white">';
    $content .= '<div class="safe-category-container">';
    $content .= '<div class="container">';
    // Category Name
    $content .= '<div class="row category-name-container">';
    $content .= '<div class="col">';
    $content .= '<h2>' . $cat_name . '</h2>';
    $content .= '<h3>' . $cat_attr . '</h3>';
    $content .= '<p>' . get_field('category_safes_description', $acf_field_param) . '</p>';
    $content .= '</div></div>';
    // Category Attributes
    if( have_rows('category_safes_attributes', $acf_field_param) ):
        $content .= '<div class="row category-attributes-container">';
        while ( have_rows('category_safes_attributes', $acf_field_param) ) : the_row();
            $content .= '<div class="col-md-4">';
            $attribute_heading = get_icon_for_category_attribute(get_sub_field('category_safes_attributes_category', $acf_field_param));
            $content .= $attribute_heading;
            if( have_rows('category_safes_attributes_items', $acf_field_param) ):
                $content .= '<ul class="left-aligned">';
                while ( have_rows('category_safes_attributes_items', $acf_field_param) ) : the_row();
                    $content .= '<li>' . get_sub_field('category_safes_attributes_items_item', $acf_field_param) . '</li>';
                endwhile;
                $content .= '</ul>';
            endif;
            $content .= '</div>';
        endwhile;
        $content .= '</div></div></div>';
    endif;

    // Product List
    $content .= '<div class="container">';
    $query_args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => $tax_term,
                'terms'    => $term_id
            ),
        ),
    ];
    $query = new WP_Query($query_args);

    if ($query->have_posts()) :
        $content .= '<div class="row product-grids-container">';
        $i = 0;
        while ($query->have_posts()) : $query->the_post();
            if ($i > 0 && $i % 3 === 0) {
                $content .= '</div>';
                $content .= '<div class="row product-grids-container">';
            }
            $content .= '<div class="col-md-4 text-center">';
            $content .= '<div class="product-container">';

            $product_manufacturer  = get_field('category_safes_manufacturer', $acf_field_param) . ' ';
            $product_num = get_clean_product_name($post->ID);
            $fire_rating = get_field('category_safes_fire_rating', $acf_field_param) . ' Minute Fire Rating ';
            $gun_capacity = get_field('post_product_gun_gun_capacity') . ' Gun Capacity';

            $content .= '<h4 class="product-list-name">' . $product_manufacturer . ' ' . $product_num . '</h4>';
            $content .= '<p class="product-list-fire-rating">' . $gun_capacity . '</p>';
            $content .= '<img src="' . get_the_post_thumbnail_url() . '"/>';
            $content .= '<div class="text-center">';
            $content .= '<a href="' . get_permalink() . '" class="product-cta-btn">' . 'View ' . $product_num . ' Details <i class="fas fa-long-arrow-right ml-1"></i>' . '</a>';
            $content .= '</div></div></div>';

            $i++;
        endwhile;
        $content .= '</div>';
        wp_reset_postdata();
    endif;
    $content .= '</div>';

}
echo $content;
?>


<?php get_footer(); ?>