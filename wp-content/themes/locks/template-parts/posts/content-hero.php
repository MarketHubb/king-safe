<?php
$hero = get_field('page_banner_details');

if ($hero) :
    $heading = $hero['page_banner_heading'] > 0 ? $hero['page_banner_heading'] : get_the_title($post->ID);
    $bg_opacity = $hero['page_banner_image_opacity'] > 0 ? $hero['page_banner_image_opacity'] : .8;
    $linear_gradient = 'linear-gradient(to bottom, rgba(0,0,0,' .  $bg_opacity . ') 0%,rgba(0,0,0,' . $bg_opacity . ') 100%)';
    $text_align_class = $hero['page_banner_text_align'] = 'center' ? 'text-center' : '';

    ?>

    <div class="jumbotron bg-cover text-white single-post"
         style="background-image: <?php echo $linear_gradient; ?>,
             url(<?php echo $hero['page_banner_image']; ?>)">

        <div class="container <?php echo $text_align_class; ?>">

            <?php
            $categories = get_the_category($post->ID);
            ?>

            <div class="text-center">
                <p class="dib category-pill font-weight-bold text-white">Posted In: <em><?php echo $categories[0]->name; ?></em></p>
            </div>

            <h1 class="banner-heading font-weight-bold display-4 my-1 ttc"><?php echo $heading; ?></h1>

            <?php if ($hero['page_banner_description']) { ?>
                <p class="lead font-weight-bold text-white"><?php echo $hero['page_banner_description']; ?></p>
            <?php } ?>

            <?php
            $dates = compare_published_updated_dates($post->ID);
            foreach ($dates as $key => $val) {
                $published_read .= '<p class="text-white date-published font-weight-bold"><i class="fas fa-calendar-week pr-1"></i> ' . ucwords($key) . ': ' . $val . '</p>';
            }

            echo $published_read;
            ?>

        </div>
    </div>

<?php endif; ?>
