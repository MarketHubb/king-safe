<section id="available-safes">

    <div class="container-skew">

        <div class="container-straight">

            <div class="container-fixed">
            
             <h2 class="available-safes-title" style="text-align: center;">Available kinds of safes</h2>

                <div class="available-safes-list">

                   

                    <?php

                    $available_safes = get_field( 'available_safes' );

                    $count = 0;

                    ?>

                    <?php while( have_rows( 'available_safes' ) ): the_row(); ?>

                        <?php if ($count % 3 == 0): ?>

                            <ul class="safe-list-column">

                        <?php endif; ?>



                        <li><?php the_sub_field( 'safe_item' ) ?></li>



                        <?php if ( ($count % 3 == 2) || ($count == count($available_safes) ) ): ?>

                            </ul>

                        <?php endif; ?>

                    <?php $count++; endwhile; ?>

                </div>


				<div class="safes-brands-list-container">

                    <h3 class="safes-brands-list-title" style="text-align: center;"><?php the_field( 'brands_safe_list_title' );?></h3>

                    <?php if ( have_rows( 'brands_safe_list' ) ): ?>

                    <div class="safes-brands-list">

                    <?php while( have_rows( 'brands_safe_list') ): the_row(); ?>

                        <span class="safe-brand"><?php the_sub_field( 'item' ); ?></span>

                    <?php endwhile; ?>

                    </div>

                    <?php endif; ?>

                </div>



                <div class="visit-our-showroom-container">

                        <div class="showroom-text">

                            <?php the_field( 'showroom_text' ); ?>

                        </div>

                </div>



                

            </div>

        </div>

    </div>



</section>