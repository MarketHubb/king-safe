<section id="bonded-and-insured">



    <div class="container-skew">



        <div class="container-straight">



            <div class="container-fixed">



                <div class="section-intro">



                    <h1><?php the_field( 'home_title' ); ?><span></h1><h2><?php the_field( 'home_subtitle'); ?></span></h2>



                    <div class="gold-text-container">



			<span class="gold">Commercial &bull; Residential &bull; Business</span>



                    </div>



                    <p><?php the_field( 'home_description' );?></p>



                </div>



                <div class="lock-container">



                    <img src="<?php echo get_template_directory_uri() . '/images/header/key-icon.png'; ?>" alt="">



                </div>



                <div class="services-included-text">



                    <?php the_field( 'services_included_heading' ); ?>



                </div>



                <div class="services-list-container">



                    <div class="left-content">



                        <?php if ( have_rows( 'services_included_left' ) ): ?>



                        <ul>



                            <?php while( have_rows( 'services_included_left' ) ): the_row(); ?>



                                <li><?php the_sub_field( 'service' ); ?></li>



                            <?php endwhile; ?>



                        </ul>



                        <?php endif; ?>



                        <a href="<?php the_field( 'services_included_left_learn_more_url' ); ?>"><?php the_field( 'services_included_left_learn_more_text' ); ?></a>



                    </div>



                    <div class="right-content">



                        <?php if ( have_rows( 'services_included_right' ) ): ?>



                            <ul>



                                <?php while( have_rows( 'services_included_right' ) ): the_row(); ?>



                                    <li><?php the_sub_field( 'service' ); ?></li>



                                <?php endwhile; ?>



                            </ul>



                        <?php endif; ?>



                        <a href="<?php the_field( 'services_included_right_learn_more_url' ); ?>"><?php the_field( 'services_included_right_learn_more_text' ); ?></a>



                    </div>



                </div>







            </div>



        </div>



    </div>



</section>