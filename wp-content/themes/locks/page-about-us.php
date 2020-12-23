<?php



/**



 * Template Name: AboutUsPage



**/







get_header(); the_post(); ?>





<link rel='stylesheet' href="<?php echo get_site_url(); ?>/wp-content/themes/locks/css/magnific-popup.css" type="text/css" media="all" />



    <div id="primary" class="content-area about-us">



        <a name="top"></a>



        <main id="main" class="site-main " role="main">







            <?php get_template_part( 'template-parts/content', 'header-hero-safe'); ?>







            <section class="about-us-content">



                <div class="container-fixed">



                    <?php if ( function_exists('yoast_breadcrumb') ) {



                        yoast_breadcrumb('<p id="breadcrumbs">','</p>');



                    }



                    the_content(); ?>



                </div>



            </section>





















<section class="associations">

    <div class="container-skew">

        <div class="container-straight">

            <div class="container-fixed">

                <h2>

                    <img src="<?php echo get_template_directory_uri(); ?>/images/about-us/Associations-icon.png" alt="">

                    Associations

                </h2>

                <div class="brand-images">

                    <div class="Box">

        	<div class="outer">

            	<img src="<?php echo get_site_url(); ?>/wp-content/uploads/2016/09/hpd.png" />

                <p>The mission of the <a href="http://www.houstonpolice.org/" target="_blank" rel="nofollow">Houston Police Department</a> is to enhance the quality of life in the city of Houston by working cooperatively with the public to prevent crime, enforce the law, preserve the peace, and provide a safe environment.</p>

            </div>

        </div>

                    <div class="Box">

                        <div class="outer">

                            <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2016/09/tla.png" />

                            <p>The <a href="https://www.texaslocksmiths.org/" target="_blank" rel="nofollow">Texas Locksmiths Association</a> is a business league with an educational mission to develop a higher standard of public service and security, increase the knowledge of all TLA members through continuing education, improve the image of the locksmith in his community via outreach and education and promote the spirit of cooperation among locksmiths.</p>

                        </div>

                    </div>

                    <div class="Box">

                        <div class="outer">

                            <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2016/09/savta-1.png" />

                            <p><a href="http://savta.org/" target="_blank" rel="nofollow">SAVTA</a> is the world's leading trade organization for safe and vault technicians. Since 1986, SAVTA has helped technicians increase their technical knowledge and professionalism.</p>

                        </div>

                    </div>

                    <div class="Box">

                        <div class="outer">

                            <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2016/11/ghla.png" />

                            <p>GHLA members follow a code of ethics that require integrity, honor and fair dealing toward the general public; compliance with all laws; truth in advertising and selling; standing behind guarantees givn during the sales of security devices; and the exposure of fraud and deception against the security-buying public.</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>







            <?php //get_template_part( 'template-parts/content', 'associations'); ?>







            <?php //get_template_part( 'template-parts/content', 'safes-videos' ); ?>







        </main><!-- #main -->



    </div><!-- #primary -->





<script type='text/javascript' src='<?php echo get_site_url(); ?>/wp-content/themes/locks/js/jquery.magnific-popup.min.js?ver=1.1.0'></script>



<?php

get_footer();



