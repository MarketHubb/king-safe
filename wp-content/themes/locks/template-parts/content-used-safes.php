<!--<section id="used-safes-slider">

    <div class="container-skew">

        <div class="container-straight">

            <div class="container-fixed">

                <h2><img src="<?php echo get_template_directory_uri(); ?>/images/body/used-safes-icon.png" alt="Hot Deals">Used Safes</h2>

                <div class="owl-carousel">

                    <?php



                    // check if the repeater field has rows of data

                    if( have_rows('used_safes') ):



                        // loop through the rows of data

                        while ( have_rows('used_safes') ) : the_row(); ?>



                            <div class="slide">

                                <img src="<?php the_sub_field('used_safe_img'); ?>" alt="Hot Deal Image">

                                <div>

                                    <h3><?php the_sub_field('used_safe_title'); ?></h3>

                                    <p><?php the_sub_field('used_safe_description'); ?></p>

                                    <a href="<?php the_sub_field('used_safe_link'); ?>">View Details</a>

                                </div>

                            </div>



                        <?php endwhile;



                    else :



                        // no rows found



                    endif;



                    ?>

                </div>

            </div>

        </div>

    </div>

</section>-->