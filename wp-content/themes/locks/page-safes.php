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

get_header(); the_post(); ?>

    <div id="primary" class="content-area page-safes">
        <a name="top"></a>
        <main id="main" class="site-main" role="main">
           <!--Page Hero Header Template Part-->
            <?php get_template_part( 'template-parts/content', 'header-hero-page'); ?>
            <!--Breadcrumb Template Part-->
            <!--Safes Template Part-->
            <?php get_template_part( 'template-parts/content', 'safes'); ?>

            <?php get_template_part( 'template-parts/content', 'available-safes-section'); ?>

            <!--Hot Deals Slider Template Part-->
            <?php get_template_part( 'template-parts/content', 'hot-deals-slider'); ?>
            <!--Content Safes Videos Template Part-->
            <?php get_template_part( 'template-parts/content', 'safes-videos'); ?>
            <!--Content Safes Videos Template Part-->
            <?php get_template_part( 'template-parts/content', 'used-safes'); ?>
        </main><!-- #main -->
    </div><!-- #primary -->
    
<?php
get_footer();
