<?php /* Template Name: Parent */

get_header(); ?>

<?php
if (get_field('include_banner')) {
    get_template_part('template-parts/global/hero-split');
}
?>

<?php get_footer(); ?>
