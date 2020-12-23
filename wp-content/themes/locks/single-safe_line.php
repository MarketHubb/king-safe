<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package locks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php get_template_part( 'template-parts/content', 'header-hero-safe'); ?>
			<div class="post-content">
				<div class="container-fixed">
					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'single-safe' );

					endwhile; // End of the loop.
					?>

					<?php get_template_part( 'template-parts/safe', 'images' ); ?>

					<section id="safe-line-features">
						<?php the_field( 'safe_line_features' ); ?>
					</section>

					<?php get_template_part( 'template-parts/safe', 'models-data' ); ?>

					<section id="interest-callout">
						<p>Interested in these safes?</p>
						<p>Visit us at 10210 Westheimer Rd. Houston, TX 77042</p>
						<p>Or call us at <a href="tel:713-659-3951">713 659-3951</a></p>
					</section>

				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
