<!-- <div id="header-hero" class="container-skew banner-no-show" <?php echo single_post_hero_background(); ?>>


    <div class="container-straight">


        <div class="container-fixed"> -->
            <?php 
            if ( is_shop() ) {
               // echo '<h1 class="page-title">Safes For Sale</h1>';
            } else {
                // render_single_post_hero_headlines(); 
            }
            ?>


<!--         </div>


    </div>


</div> -->

<!-- Bannerless H1 ouput -->
<div class="bannerless-heading-container">
    <div class="container-fixed">
        <?php  
        $heading = render_single_post_hero_headlines();
        
        if ( is_shop() ) {
           $headline = 'Safes For Sale';
        } else {
            $headline =  $heading['headline'];
            $subheadline = $heading['subheadline'];
        }
        ?>
        
        <h1><?php echo $headline; ?></h1>
        <p><?php echo $subheadline; ?></p>
        
    </div>
</div>
