<!--<section id="safes-videos">

    <div class="container-skew">

        <div class="container-straight">

            <div class="container-fixed">

                <h2><img src="<?php echo get_template_directory_uri(); ?>/images/body/safes-videos-icon.png" alt="Safe Videos">Safe Videos</h2>

                <div id="safes-videos-container">

                    <?php



                    // check if the repeater field has rows of data

                    if( have_rows('safes_videos') ):



                        // loop through the rows of data

                        while ( have_rows('safes_videos') ) : the_row(); ?>

                            

                                <div class="safe-video-single">

                                    <iframe src=" <?php the_sub_field('safe_video_url'); ?>" frameborder="0"></iframe>

                                    <h3><?php the_sub_field('safe_video_title'); ?></h3>

                                    <p><?php the_sub_field('safe_video_description'); ?></p>

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