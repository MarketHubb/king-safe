<?php if (have_rows( 'models' )): ?>

<section id="model-images">



<?php $count = 1; while (have_rows( 'models' )): the_row(); ?>

    

    <div class="single-safe-model">

        <div class="model-image-container">

            <a class="open-modal" href="#safe-<?php echo $count; ?>">

            <?php $model_image = get_sub_field( 'model_image' ); if ( !empty( $model_image )): ?>

                <img src="<?php echo $model_image['url']; ?>" alt="<?php echo $model_image['alt']; ?>">

            <?php endif; ?>

            </a>

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

                        <th>EXTERIOR <span class="head-cell-extra-info">(HxWxL) </th>

                        <th>INTERIOR <span class="head-cell-extra-info">(HxWxL) </th>

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

        </div>

        <a class="open-modal" href="#safe-<?php echo $count; ?>"><span class="model-code"><?php the_sub_field( 'model_code' ); ?></span></a>

    </div>



<?php $count++; endwhile; ?>



</section>

<?php endif; ?>

