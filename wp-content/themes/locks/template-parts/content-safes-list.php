<?php



$categories = get_terms( array(

    'taxonomy' => 'safe_category',

    'orderby'  => 'name'

) );



?>



<?php if (!empty($categories)): ?>

    <div id="safes-container">

        <?php foreach($categories as $category):  ?>

            <div class="safe-single">

                <?php $safe_image = get_field( 'featured_image', $category); ?>

                <?php $term_link = get_term_link( $category ); ?>

                <?php if ( !empty( $safe_image ) && !empty( $term_link ) && !is_wp_error( $term_link ) ): ?>

                <a href="<?php echo esc_url( $term_link ); ?>">

                    <img src="<?php echo $safe_image['url']; ?>" alt="<?php echo $category->name; ?>">

                </a>

                <?php endif; ?>

                <a href="<?php echo esc_url( $term_link ); ?>"><h3><?php echo $category->name; ?></h3></a>

                <p>

                    <?php the_field( 'small_description', $category );  ?>

                </p>

                <?php if (!empty($term_link) && !is_wp_error($term_link)): ?>

                    <a class="view-inventory" href="<?php echo esc_url( $term_link ); ?>">View Inventory</a>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>