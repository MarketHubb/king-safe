<section id="hot-deals-slider">

    <div class="container-skew skew-bottom skew-top gray no-skew">

        <div class="container-straight no-skew">

            <div class="container-fixed">

              <h2><i class="material-icons" style="font-size:36px;">&#xE80E;</i> Hot Deals</h2>

                <div class="owl-carousel">

                    <?php



                    // check if the repeater field has rows of data

                    if( have_rows('hot_deals') ):



                        // loop through the rows of data

                        while ( have_rows('hot_deals') ) : the_row(); ?>



                            <div class="slide">

                                <img src="<?php the_sub_field('hot_deal_img'); ?>" alt="Hot Deal Image">

                                <div>

                                    <h3><?php the_sub_field('hot_deal_title'); ?></h3>

                                    <p><?php the_sub_field('hot_deal_description'); ?></p>

                                    <a href="<?php the_sub_field('hot_deal_link'); ?>">View Details</a>

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

</section>