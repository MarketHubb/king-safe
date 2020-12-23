<?php

    $phone_number = str_replace(' ', '-', str_replace( ["(", ")"], '', get_field( 'map_section_phone_number' ) ) );

    $fax_number = str_replace(' ', '-', str_replace( ["(", ")"], '', get_field( 'fax_phone_number' ) ) );

?>


<section id="contact-directions">

    <h2><?php the_field( 'title' ); ?></h2>

    <!--<a href="<?php //the_field( 'get_directions_url' ); ?>"class="map-container"></a>-->

    
    <div class="gmap">
    
    <?php the_field( 'map_box' ); ?>
    
	</div>
    

    <div class="directions-and-date-container">

        <div class="directions-container">

            <div class="phone"><a href="<?php echo 'tel:' . $phone_number; ?>"><?php the_field( 'map_section_phone_number' ); ?></a></div>

            <div class="address"><?php the_field( 'address' ); ?></div>

            <a class="get-directions open-modal" href="<?php the_field( 'get_directions_url' ); ?>" target="_blank">Get Directions ></a>

        </div>
        
       

        <div class="date-container">

            <div class="date-days"><?php the_field( 'first_day_interval' ); ?></div>

            <div class="date-time"><?php the_field( 'first_time_interval' ); ?></div>

        </div>

        <div class="date-container">

            <div class="date-days"><?php the_field( 'second_day_interval'); ?></div>

            <div class="date-time"><?php the_field( 'second_time_interval'); ?></div>

        </div>

    </div>

    <div class="quote-container">

        <?php the_field( 'quote' ); ?>

    </div>

    <div class="fax-text">

        <?php the_field( 'fax_text' ); ?>

        <span class="fax-phone"><a href="<?php echo 'tel:' . $fax_number; ?>"><?php the_field( 'fax_phone_number' ); ?></a></span>

    </div>

</section>


