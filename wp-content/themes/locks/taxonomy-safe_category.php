<?php
/**
 * The template for displaying safe categories.
 *
 * @package locks
 */

get_header(); $category = sanitize_post ( get_queried_object() ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php get_template_part( 'template-parts/content', 'header-hero-safe'); ?>
			<div class="container-fixed">
				<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				} ?>
			</div>
			<section class="safe-category-description">
				<div class="container-fixed">
					<?php echo $category->description;  ?>
				</div>
			</section>

			<section class="safe-lines">
				<div class="container-fixed">
					<?php get_template_part( 'template-parts/content', 'safe-category'); ?>
				</div>
			</section>

			<section class="brands">
				<?php get_template_part( 'template-parts/content', 'brands-we-carry')?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
