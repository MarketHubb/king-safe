<?php

/**

 * The template for displaying search results pages.

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result

 *

 * @package locks

 */



get_header(); ?>



	<div id="primary" class="content-area search-page">

		<main id="main" class="site-main" role="main">

			<div id="header-hero" class="container-skew" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2016/08/safeMovingHeader.jpg');">

				<div class="container-straight">

					<div class="container-fixed">

						<h1>Search Results</h1>        </div>

				</div>

			</div>

			<div class="container-fixed">

				<article>





					<div class="entry-content">





						<?php
$cnt=0;
						if ( have_posts() ) : ?>



						<header class="page-header">

							<h2 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'locks' ), '<span>' . get_search_query() . '</span>' ); ?></h2>

						</header>

						<!--<div class="search-results-container">-->
						<div class="safes-container">
                        <ul>




							<?php
							

							/* Start the Loop */

							while ( have_posts() ) : the_post();

                           $cnt++;

								/**

								 * Run the loop for the search to output the results.

								 * If you want to overload this in a child theme then include a file

								 * called content-search.php and that will be used instead.

								 */

								get_template_part( 'template-parts/content', 'search' );



							endwhile;



							the_posts_navigation();



							else :



								get_template_part( 'template-parts/content', 'none' );



							endif; ?>
</ul>
						</div>

					</div>

				</article>

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->



<?php

get_footer();

