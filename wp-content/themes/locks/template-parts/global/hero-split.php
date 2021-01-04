<div class="container-fluid banner section">
    <div class="wrapper">
        <div class="row align-items-center">

            <div class="col-md-6 pr-md-4">
                <h1 class="display-4 mb-3 heading">
                    <span class="dib font-weight-bold"><?php the_field('banner_heading_main'); ?></span><br>
                    <span class="dib font-weight-lighter"><?php the_field('banner_heading_sub'); ?></h1>
                <p class="lead"><?php the_field('banner_description'); ?></p>
                
                <?php
                if (get_field('banner_include_button')) {
                    echo get_hero_button($post->ID);
                }
                 ?>
            </div>
            <div class="col-md-6">
                <img src="<?php the_field('banner_image'); ?>" alt="">
            </div>

        </div>
    </div>
</div>
