<?php
$post_id = get_query_var('post_id');
?>
<div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="service-modal"">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--            </div>-->
            <div class="container-fluid p-0" id="modal-hero"></div>
            <div class="container text-center">
                <div class="wrapper">
                    <div class="row justify-content-center">
                        <div class="col-md-11">

                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <p class="lead phone-highlight">Need immediate assistance? Call us now <span class="font-weight-bold"><a href="tel:713-322-8758">(713) 322-8758</a></span></p>
                        <h1 class="display-5 font-weight-bold heading mt-2 mb-3">Fill out the form below to schedule an appointment</h1>
                        <div class="panel bg-grey bt-red p-md-5">
                            <?php gravity_form(1, $display_title=false, $display_description=false, $display_inactive=false, $field_values=$dynamic, $ajax=true, 1); ?>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Testimonial -->
                    <div class="row justify-content-center mt-5">
                        <div class="col col-sm-12 col-md-10 col-lg-10 text-center">
                            <p class="modal-dog-testimonial ">“Having two dogs trained by Golden State K-9 Training has been a very positive experience. The control I have is outstanding and their companionship is unequaled."</p>
                            <p class="modal-dog-testimonial-author"><strong>Ricky Watters</strong> | All-Pro Running Back</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>