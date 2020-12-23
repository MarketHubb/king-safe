<?php



    $background_image = get_field( 'hero_background' );

    $style_str = '';

    if ( !empty( $background_image ) ) {

        $style_str = 'style="background-image: url(\'' . $background_image['url'] . '\');"';

    } else {

        $style_str = 'style="background-image: url(\'<?php echo get_template_directory_uri(); ?>/images/header/safes-header.jpg\');"';

    }



?>



<div id="header-hero-page" class="container-skew" <?php echo $style_str; ?>>

    <div class="container-straight">

        <div class="container-fixed">

            <h1><?php the_field('page_headline'); ?></h1>

            <h2><?php the_field('page_sub_headline'); ?></h2>

        </div>

    </div>

</div>