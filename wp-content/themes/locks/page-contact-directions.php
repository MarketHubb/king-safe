
<?php

/**
 * Template Name: ContactDirections
 **/
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php get_template_part( 'template-parts/content', 'header-hero-safe' ); ?>

            <div class="container-fixed">
                <?php if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                }
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content', 'contact-directions' );

                endwhile; // End of the loop.
                ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();