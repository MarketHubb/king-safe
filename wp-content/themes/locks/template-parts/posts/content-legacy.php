<div class="container-fluid bg-blue my-4">
    <div class="wrapper">
        <div class="row py-3">
            <div class="col-md-12 text-center">

                <?php
                $categories = get_the_category($post->ID);
                ?>

                <div class="text-center mt-2">
                    <p class="dib category-pill font-weight-bold ">Posted In: <em><?php echo $categories[0]->name; ?></em></p>
                </div>

                <h1 class="font-weight-bold display-4 mt-0"><?php echo get_the_title(); ?></h1>

                <?php
                $dates = compare_published_updated_dates($post->ID);
                foreach ($dates as $key => $val) {
                    $published_read .= '<p class="date-published font-weight-bold"><i class="fas fa-calendar-week pr-1"></i> ' . ucwords($key) . ': ' . $val . '</p>';
                }

                echo $published_read;
                ?>
            </div>
        </div>
    </div>
</div>
