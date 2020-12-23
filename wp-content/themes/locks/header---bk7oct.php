<?php

/**

 * The header for our theme.

 *

 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package locks

 */



?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">



<?php wp_head(); ?>

<!-- Google Tag Manager YP SearchPro -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-N3QNVF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N3QNVF');</script>
<!-- End Google Tag Manager -->

<!-- Start HSL Google Analytics -->
<script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-78250454-1', 'auto');  ga('send', 'pageview');</script>
<!-- End HSL Google Analytics -->

<!-- start callrail number swap -->
<script type="text/javascript" src="//cdn.callrail.com/companies/721531485/b4a446ee0ddd4e5a0f3b/12/swap.js"></script>
<!-- end callrail number swap -->

<!-- start number replacer -->
<script type="text/javascript"><!--
var vs_account_id = "CtjSaVKM3eEkBwAs";
//--></script>
<script type="text/javascript" src="http://27.xg4ken.com/media/number-changer/voicestar/number-changer.php">
</script>
<!-- end ad widget -->

</head>



<body <?php body_class(); ?>>

<div id="page" class="site <?php echo sanitize_post ( get_queried_object() )->post_name; ?>">


	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'locks' ); ?></a>



	<header id="masthead" class="site-header" role="banner">

		<div id="pre-nav">

			<div class="container-fixed">

				<div id="left-content">

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">

						<img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo-header-collapsed.png" alt="Houston Safe And Lock">

					</a>

				</div>

				<div id="right-content">

        <div id="social">

            <a href="<?php the_field( 'facebook_url', 'option' ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/header/fb-icon.png" alt="Facebook" target="_blank"></a>

            <a href="<?php the_field( 'twitter_url', 'option' ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/header/twitter-icon.png" alt="Twitter" target="_blank"></a>

        </div>

					<div id="links">

						<a id="blog" href="/blog">Blog</a>

						<a id="newsletter" href="<?php the_field( 'sign_up_for_our_newsletter_url', 'option' ); ?>" target="_blank">Newsletter Sign up</a>

					</div>

					<div id="search">

						<?php get_search_form(); ?>
                        

					</div>

				</div>

			</div>
            
            <div class="scrolling-brand-phone">

				<div class="brand-phone">

					<h3>Call us for emergency services</h3>

					<p><a href="tel:713-659-3951">(713) 659-3951</a></p>
                    

				</div>

			</div>

		</div>

		<div id="brand-info">

			<div class="container-fixed">

				<div id="brand-logo">

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">

						<img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo.png" alt="Houston Safe And Lock Logo" />

					</a>

				</div>

				<div id="brand-contact">

					<h3>Email or fax maintenance facilities work orders</h3>

					<span>Email: <a id="email" href="mailto:houstonsafeandlock@gmail.com">houstonsafeandlock@gmail.com</a></span>

					<span>Fax: <a href="tel:713-975-7534">(713) 975-7534</a></span>

				</div>

				<div id="brand-phone">

					<h3>Call us for emergency services</h3>

					<p><a href="tel:713-659-3951">(713) 659-3951</a></p>

				</div>

				<div id="menu-responsive">

					<button id="menu-responsive-trigger">

						<span class="closed-menu-text is-active">MENU</span>

						<span class="opened-menu-text">CLOSE</span>

						<div class="responsive-menu-icon">

							<span></span>

							<span></span>

							<span></span>

							<span></span>

						</div>

						<!--img src="<?php echo get_template_directory_uri(); ?>/images/header/responsive-menu-icon.png" alt="Menu Responsive"-->

					</button>

					<div id="menu-responsive-container">

						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'before' => '<div class="arrow"></div>' ) ); ?>
                        

						<div class="menu-responsive-bottom-container">

							<div class="lock-separator-container">

								<hr class="separator">

							<span class="lock">

								<img src="<?php echo get_template_directory_uri(); ?>/images/header/key-icon.png" alt="key icon">

							</span>

								<hr class="separator">

							</div>

							<div class="menu-responsive-icons-container">

								<a href="<?php the_field( 'facebook_url' );  ?>">

									<img src="<?php echo get_template_directory_uri(); ?>/images/header/fb-icon-responsive.png" alt="facebook icon">

								</a>

								<a href="<?php the_field( 'twitter_url' ); ?>">

									<img src="<?php echo get_template_directory_uri(); ?>/images/header/twitter-icon-responsive.png" alt="twitter icon">

								</a>

							</div>

						</div>

					</div>

					</div>

				
				
			</div>

		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">

			<div class="container-fixed">

				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>

			</div>

		</nav>

	</header><!-- #masthead -->



	<div id="content" class="site-content">





