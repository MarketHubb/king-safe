<?php



/**



 * Template Name: SafeDetails



**/







get_header(); the_post(); ?>







    <div id="primary" class="content-area about-us">



        <a name="top"></a>



        <main id="main" class="site-main " role="main">







            <?php get_template_part( 'template-parts/content', 'header-hero-safe'); ?>







            <section class="about-us-content">



                <div class="container-fixed">



                    <?php  echo '**************';if ( function_exists('yoast_breadcrumb') ) {



                        yoast_breadcrumb('<p id="breadcrumbs">','</p>');



                    }



                    the_content(); ?>

                    

                   



                </div>



            </section>











 <div id="safe-<?php echo $count; ?>" class="safe-line-modal mfp-hide">



                <section class="top-section">



                    <div class="image-container">



                        <?php $model_image = get_sub_field( 'model_image' ); if ( !empty( $model_image )): ?>



                            <img src="<?php echo $model_image['url']; ?>" alt="<?php echo $model_image['alt']; ?>">



                        <?php endif; ?>



                    </div>



                    <div class="features-container">



                        <?php the_sub_field( 'model_features' ); ?>



                    </div>



                    <div class="interest-container">



                        <div class="interest-content">



                            <?php the_field( 'modal_interest_content', 'option' ); ?>



                        </div>



                        <div class="interest-icons">



                            <a href="<?php the_field( 'facebook_url', 'option' ); ?>">



                                <img src="<?php echo get_template_directory_uri() . '/images/single-safe/fb-icon.png'; ?>" alt="Facebook">



                            </a>



                            <a href="<?php the_field( 'twitter_url', 'option' ); ?>">



                                <img src="<?php echo get_template_directory_uri() . '/images/single-safe/twitter-icon.png'; ?>" alt="Twitter">



                            </a>



                            <a href="<?php echo 'mailto:' . get_field( 'email_address', 'option' ); ?>">



                                <img src="<?php echo get_template_directory_uri() . '/images/single-safe/mail-icon.png'; ?>" alt="E-mail">



                            </a>



                            <a onclick="window.print();">



                                <img src="<?php echo get_template_directory_uri() . '/images/single-safe/print-icon.png'; ?>" alt="Print this">



                            </a>



                        </div>



                    </div>



                </section>



                <section class="bottom-section">



                    <table class="models-table responsive">



                        <thead>



                        <th>MODEL</th>



                        <th>EXTERIOR <span class="head-cell-extra-info">(HxWxD) </th>



                        <th>INTERIOR <span class="head-cell-extra-info">(HxWxD) </th>



                        <th>lbs</th>



                        <th>CAPACITY <span class="head-cell-extra-info">(Cubic Feet)</span></th>



                        </thead>



                        <tbody>



                        <tr>



                            <td><?php the_sub_field( 'model_code' )?></td>



                            <td><?php the_sub_field( 'model_exterior' )?></td>



                            <td><?php the_sub_field( 'model_interior' )?></td>



                            <td><?php the_sub_field( 'model_lbs' )?></td>



                            <td><?php the_sub_field( 'model_capacity' )?></td>



                        </tr>



                        </tbody>



                    </table>



                </section>



            </div>

















            <?php //get_template_part( 'template-parts/content', 'associations'); ?>







            <?php //get_template_part( 'template-parts/content', 'safes-videos' ); ?>







        </main><!-- #main -->



    </div><!-- #primary -->



 



<?php



get_footer();



