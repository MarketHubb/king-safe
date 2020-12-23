<?php

    $category = sanitize_post( get_queried_object() );

    $args = array(

        'post_type' => 'safe',

        'tax_query' => array(

            array(

                'taxonomy' => $category->taxonomy,

                'field'    => 'slug',

                'terms'    => $category->slug,

            ),

        ),

    );

    $safe_lines = new WP_Query( $args );



?>



<?php if ( $safe_lines->have_posts() ) : ?>

<div class="category-safe-lines">

    <?php while( $safe_lines->have_posts() ): $safe_lines->the_post(); ?>



        <div class="single-safe-line">

            <div class="safe-line-image-container">

                <a href="<?php the_permalink(); ?>">

                    <?php the_post_thumbnail(); ?>

                </a>

            </div>

            <div class="safe-line-name">

                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

            </div>

            <div class="safe-line-description">

                <?php the_field( 'safe_line_description' ); ?>

            </div>

            <a href="<?php the_permalink(); ?>" class="view-inventory">View inventory</a>

        </div>



    <?php endwhile; ?>

</div>

<?php endif; ?>