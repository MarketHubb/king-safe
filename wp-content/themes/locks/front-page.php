<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package locks
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <a name="top"></a>
        <main id="main" class="site-main" role="main">
            <!--Header Image Template Part-->
            <?php get_template_part( 'template-parts/content', 'header-hero'); ?>
            <!--Bonded And Insured Template Part-->
            <?php get_template_part( 'template-parts/content', 'bonded-and-insured'); ?>
            <!--Hot Deals Template Part-->
            <?php get_template_part( 'template-parts/content', 'hot-deals'); ?>
            <!--Safes Template Part-->
            <?php get_template_part( 'template-parts/content', 'safes-home'); ?>
            <!-- Crime Section Template Part -->
            <?php get_template_part( 'template-parts/content', 'crime-section'); ?>
            <!--Testimonials Template Part-->
            <?php get_template_part( 'template-parts/content', 'testimonials'); ?>
            <!--Lock Services Template Part-->
            <?php get_template_part( 'template-parts/content', 'lock-services'); ?>
            <!--About Us Template Part-->
            <?php get_template_part( 'template-parts/content', 'about-us'); ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
