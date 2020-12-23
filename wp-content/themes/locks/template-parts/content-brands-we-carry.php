<div class="container-skew">

    <div class="container-straight">

        <div class="container-fixed">

            <h2>

                <i class="material-icons" style="font-size:36px;">&#xE885;</i> 

                <span> Brands we carry</span>

            </h2>

            <div class="brand-images">

                <?php

                    $brands = get_field( 'brand_images', 'option' );



                    foreach ($brands as $brand) {

                        echo '<img class="brand-image" src="'.$brand["url"].'">';

                    }

                ?>

            </div>

        </div>

    </div>

</div>