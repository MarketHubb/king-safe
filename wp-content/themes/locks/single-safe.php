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
			<div class="container-fixed">
				<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				} ?>
			</div>
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
						<?php the_field( 'interest_section_content', 'option' ); ?>
					</section>

				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php
get_footer();
