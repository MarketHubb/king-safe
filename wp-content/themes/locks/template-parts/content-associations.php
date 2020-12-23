<section class="associations imr">

    <div class="container-skew">

        <div class="container-straight">

            <div class="container-fixed">

                <h2>

                    <img src="<?php echo get_template_directory_uri() . '/images/about-us/Associations-icon.png'?>" alt="">

                    Associations

                </h2>

                <div class="brand-images">

                    <?php

                    $associations_images = get_field( 'associations_images', 'option' );



                    foreach ($associations_images as $image) {

                        echo '<img class="brand-image" src="'.$image["url"].'">';

                    }

                    ?>

                </div>

            </div>

        </div>

    </div>

</section>