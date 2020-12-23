<section id="crime">



    <div class="container-skew">



        <div class="container-straight">



            <div class="container-fixed">



                <h2><i class="material-icons" style="font-size:36px;">&#xE32A;</i> Protect yourself against crime in the Houston area</h2>



                <?php the_field( 'crime_section_text' ); ?>



                <div class="crime-data-selection">



                    <div class="city-select-container">



                        <h3>Select Your City &nbsp;



                        <select name="" class="city-select"> </h3>



                            <?php while( have_rows( 'cities_data' ) ): the_row(); ?>



                                <option value="<?php the_sub_field( 'city' )?>"><?php the_sub_field( 'city' ); ?></option>



                            <?php endwhile; ?>



                        </select>



                    </div>



                    <div class="city-crime-data-container">



                        <?php while( have_rows( 'cities_data' ) ): the_row(); ?>



                        <div class="single-city-crime-data" data-city="<?php the_sub_field( 'city' )?>">



                            <table class="left-table">



                                <tr>



                                    <td>Population</td>



                                    <td><?php the_sub_field( 'population' ); ?></td>



                                </tr>



                                <tr>



                                    <td>Violent Crime</td>



                                    <td><?php the_sub_field( 'violent_crime'); ?></td>



                                </tr>



                                <tr>



                                    <td>Murder and Non-Negligent Manslaughter</td>



                                    <td><?php the_sub_field( 'murder' ); ?></td>



                                </tr>



                                <tr>



                                    <td>Forcible Rape</td>



                                    <td><?php the_sub_field( 'forcible_rape'); ?></td>



                                </tr>



                                <tr>



                                    <td>Robbery</td>



                                    <td><?php the_sub_field( 'robbery'); ?></td>



                                </tr>



                            </table>



                            <table class="right-table">



                                <tr>



                                    <td>Aggravated Assault</td>



                                    <td><?php the_sub_field( 'aggravated_assault'); ?></td>



                                </tr>



                                <tr>



                                    <td>Property Crime</td>



                                    <td><?php the_sub_field( 'property_crime'); ?></td>



                                </tr>



                                <tr>



                                    <td>Burglary</td>



                                    <td><?php the_sub_field( 'burglary' ); ?></td>



                                </tr>



                                <tr>



                                    <td>Larceny-Theft</td>



                                    <td><?php the_sub_field( 'larceny_theft'); ?></td>



                                </tr>



                                <tr>



                                    <td>Motor Vehicle Theft</td>



                                    <td><?php the_sub_field( 'motor_vehicle_theft'); ?></td>



                                </tr>



                            </table>



                        </div>



                    <?php endwhile; ?>



                    </div>



                </div>



                <?php the_field( 'text_under_table' ); ?>



               



            </div>



        </div>



    </div>



</section>