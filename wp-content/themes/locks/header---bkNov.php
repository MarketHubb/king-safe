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


<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">




<?php wp_head(); ?>

<!-- start callrail number swap -->
<script type="text/javascript" src="//cdn.callrail.com/companies/488894022/34494200929d98ff207c/12/swap.js"></script>
<!-- end callrail number swap -->

<!-- Google Tag Manager for YP SearchPro -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-N3QNVF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N3QNVF');</script>
<!-- End Google Tag Manager -->




<!-- start number replacer -->
<script type="text/javascript"><!--
var vs_account_id = "CtjSalKM3X0jBQBR";
//--></script>
<script type="text/javascript" src="http://27.xg4ken.com/media/number-changer/voicestar/number-changer.php">
</script>
<!-- end ad widget -->









<script type="text/javascript">

/*jQuery(function($){

    //   $('#mobile-search').html('<?php get_search_form(); ?>');

	alert('1'); 

	//$('#mobile-search').html('asdas'); 

	//document.getElementById("mobile-search").innerHTML='abccc';

//	alert('2');

});

*/</script>



<script type="text/javascript">

(function($) {

$.noConflict();

    $( document ).ready(function() {



        //Var Declaration



        var header = $('header.site-header'),



            pageContainer = $('#primary'),



            menuTrigger = $('button#menu-responsive-trigger'),



            menuContainer = $('div#menu-responsive-container');

			



        //Set Nav Search Trigger



        setSearchTrigger($);



        //Is User Scrolling



        isUserScrolling($, header, pageContainer);



        //Responsive Menu



        responsiveMenu(menuTrigger, menuContainer);



        //Smooth Scroll



        smoothScrolling($);

		

		var mobilesearch = '<li id="mobile-search"></li>';

		

		$('#primary-menu').append(mobilesearch);

		

		var Sform='<form id="searchform" method="get" action="<?php bloginfo('url'); ?>/"><label for="s" class="search-field-row"><input type="text" class="search-field" placeholder="SEARCH" name="s" id="s" size="25" /><button id="searchsubmit" href="javascript:void(0)"><div id="searchIcon" class="search-icon"></div></button></label></form>';

		$('#mobile-search').html(Sform);

		

		

		

	

	

	



        //Owl Slider



        $(".owl-carousel").owlCarousel({



            singleItem: true,



            pagination: true,

			

			autoPlay: true



        });









        // Mobile dropdown navigation



        showSubMenu($);







        var default_city = $('.city-select').find('option:selected').val();



        showCityCrimeData($, default_city)







        $('.city-select').on('change', function() {



            showCityCrimeData($, $(this).find('option:selected').val());



        });







        //Back to the top fuction



        backToTop($)



    });







})(jQuery);

</script>

</head>







<body <?php body_class(); ?>>



<div id="page" class="site <?php echo sanitize_post ( get_queried_object() )->post_name; ?>">





	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'locks' ); ?></a>







	<header id="masthead" class="site-header" role="banner">



		<div id="pre-nav">



			<div class="container-fixed">



				<div id="left-content">



					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">



						<img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo-header-collapsed.png" alt="King Safe And Lock">



					</a>



				</div>



				<div id="right-content">



        <div id="social">



            <a href="<?php the_field( 'facebook_url', 'option' ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/header/fb-icon.png" alt="Facebook" target="_blank"></a>



        



        </div>



					<div id="links">



						<a id="blog" href="/blog">Blog</a>



						<a id="newsletter" href="<?php the_field( 'sign_up_for_our_newsletter_url', 'option' ); ?>" target="_blank">Sign Up for Special Offers</a>



					</div>



					<div id="search">



						<?php get_search_form(); ?>

                        



					</div>



				</div>



			</div>

            

            <div class="scrolling-brand-phone">



				<div class="brand-phone">



					<h3>Call Us for Emergencies</h3>



					<p><a href="tel:713-465-0055">(713) 465-0055</a></p>

                    



				</div>



			</div>



		</div>



		<div id="brand-info">



			<div class="container-fixed">



				<div id="brand-logo">



					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">



						<img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo.png" alt="King Safe And Lock Logo" />



					</a>



				</div>



				<div id="brand-contact">



					<h3>Email or fax maintenance facilities work orders</h3>



					<span>Email: <a id="email" href="mailto:kingsafeandlock@gmail.com">kingsafeandlock@gmail.com</a></span>



					<span>Fax: <a href="tel:713-827-7601">(713) 827-7601</a></span>




				</div>



				<div id="brand-phone">



					<h3>Call Us for Emergencies</h3>



					<p><a href="tel:713-465-0055">(713) 465-0055</a></p>



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











