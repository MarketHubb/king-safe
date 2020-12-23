<?php
/**
 * Template Name: ShowDetail
**/
get_header(); the_post();
$postid=(int)$_GET['post'];
$model=(int)$_GET['model'];
global $post;global $wpdb;
$lastposts = get_post( $postid, ARRAY_A );
$post = get_post( $postid);
setup_postdata( $post ); 

print_r($post);
 ?>

<style>

@media print {

  body * {

    visibility: hidden !important;

  }

  #printableDiv, #printableDiv * {

    visibility: visible !important;

  }

  #printableDiv {

    position: absolute;

    left: 0;

    top: 0;

	height:100%;

	overflow:hidden;

  }

  

  div.safe-line-modal section.bottom-section table.models-table {

    border-collapse: collapse !important;

    border-spacing: 1px !important;

}

  div.safe-line-modal section.bottom-section table.models-table thead tr th {

	  border:1px solid #000 !important;

	  box-shadow:inset 1px 1px 1px 1000px #ccc !important;

  }

  table tbody tr td {

	  border:1px solid !important;

  }

 div.safe-line-modal {

	margin-bottom:0;

	padding-bottom:0; 

 }

}

</style>

<script src='<?php echo get_template_directory_uri(); ?>/js/jquery.elevatezoom.js'></script>
	<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
			<?php //get_template_part( 'template-parts/content', 'header-hero-safe'); ?>
      <div id="header-hero" class="container-skew" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2016/08/safeMovingHeader.jpg');">
				<div class="container-straight">
					<div class="container-fixed">
						<h1>Safe Detail</h1>        </div>

				</div>
			</div>
        	<?php 
			$mod='';
			$mm=$model-1;
            $m_modle='models_'.$mm.'_model_code';
            global $wpdb;
		   $tbl=$wpdb->postmeta;
           $result = $wpdb->get_results("SELECT meta_value FROM  $tbl where post_id='".$postid."' and meta_key='".$m_modle."' limit 1");
			foreach ( $result as $rs ) 
			{
				$mod=$rs->meta_value;
			}
		

		   $tbl2=$wpdb->posts; $post_title='';
           $result2 = $wpdb->get_results("SELECT post_title FROM  $tbl2 where ID='".$postid."' limit 1");
			foreach ( $result2 as $rs2 ) 
			{
			$post_title=$rs2->post_title;
			}

	       $tbl3=$wpdb->term_relationships;  $term_taxonomy_id='';
           $result2 = $wpdb->get_results("SELECT term_taxonomy_id FROM  $tbl3 where object_id='".$postid."' limit 1");
			foreach ( $result2 as $rs2 ) 
			{
				$term_taxonomy_id=$rs2->term_taxonomy_id;
			}
	
		   $tbl4=$wpdb->terms;  $name_cat='';
           $result2 = $wpdb->get_results("SELECT name,slug FROM  $tbl4 where term_id='".$term_taxonomy_id."' limit 1");
			foreach ( $result2 as $rs2 ) 
			{
				$name_cat=$rs2->name;
				$slug_cat=$rs2->slug;
			}
			//echo "SELECT term_taxonomy_id FROM  $tbl3 where object_id='".$postid."' limit 1";
			?>
      



			<div class="container-fixed">



				<?php /*if ( function_exists('yoast_breadcrumb') ) {



					yoast_breadcrumb('<p id="breadcrumbs">',' > <span>'.$mod.'</span></p>');



				}*/ ?>

           

			<p id="breadcrumbs">

			      <span><a href="<?php echo get_site_url(); ?>" rel="v:url" property="v:title">Home **</a> &gt; 

				  <span><a href="<?php echo get_site_url(); ?>/safe-category/<?=$slug_cat?>"><?php echo $name_cat; ?></a> &gt;

			      <span class="breadcrumb_last"><a href="<?php echo get_the_permalink();?>"><?php echo $post_title; ?></a></span> &gt;

				  <span><?php echo $mod; ?></span>

				  </span>

				  </span>

				  </span>  

				  

		   </p>



			</div>



			<div class="post-content">



				<div class="container-fixed">



					<?php

					



					$recordcount=0;

					

					foreach($lastposts as $post)

					{

						if($recordcount!=0)

						break;

						$recordcount++;

						//setup_postdata( $post );

						?>   <!--Back to <a href="<?php //the_permalink(); ?>"><?php //the_title(); ?></a>-->

						<?php if( have_rows('models') ): ?>



						<?php 

							$counter=0;

							while( have_rows('models') ): the_row(); 

                           

                            // vars

                           

						     $counter++;

							 if($counter!=$model)

							  continue;

							  $row = get_row();

							?>

                             

                            <div id="printableDiv" class="single-safe-model single-safe-model-detailpage">



        <div class="model-image-container model-image-container-detailpage">



           

            <div id="safe-<?php echo $counter; ?>" class="safe-line-modal safe-line-modal-detailpage">



                <section class="top-section top-section-detailpage">



                    <div class="image-container image-container-detailpage">





                        <?php $model_image = get_sub_field( 'model_image' ); if ( !empty( $model_image )): ?>



                            <img id="zoom_01" src="<?php echo $model_image['url']; ?>" alt="<?php echo $model_image['alt']; ?>" data-zoom-image="<?php echo $model_image['url']; ?>">

							

                        <?php endif; ?>

						<div class="zoomicon"><img src="<?php echo get_template_directory_uri(); ?>/images/body/zoom-icon-white.png"></div>

                    </div>

                    



                    <div class="features-container features-container-detailpage">



                        <?php the_sub_field( 'model_features' ); ?>



                    </div>



                    <div class="interest-container interest-container-detailpage">



                        <div class="interest-content">



                            <?php the_field( 'modal_interest_content', 'option' ); ?>



                        </div>

  <?php $current_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>



                        <div class="interest-icons">

						  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/single-safe/fb-icon.png'; ?>" alt="Facebook"></a>

						

                         

			             <a href="https://twitter.com/home?status=<?php echo urlencode($current_url); ?>">

                         <img src="<?php echo get_template_directory_uri() . '/images/single-safe/twitter-icon.png'; ?>" alt="Twitter">               </a>

          

		                 <a href="<?php echo 'mailto:' . get_field( 'email_address', 'option' ); ?>?subject=<?=$mod?>">

                         <img src="<?php echo get_template_directory_uri() . '/images/single-safe/mail-icon.png'; ?>" alt="E-mail">

                         </a>



                         <a onclick="window.print();">

                         <img src="<?php echo get_template_directory_uri() . '/images/single-safe/print-icon.png'; ?>" alt="Print this">

                          </a>

							

							

							 <!--  <a href="<?php the_field( 'facebook_url', 'option' ); ?>">

                                <img src="<?php echo get_template_directory_uri() . '/images/single-safe/fb-icon.png'; ?>" alt="Facebook">              </a>

						 <a href="<?php the_field( 'twitter_url', 'option' ); ?>">

                         <img src="<?php echo get_template_directory_uri() . '/images/single-safe/twitter-icon.png'; ?>" alt="Twitter">                   </a>		

								

								https://twitter.com/home?status=https%3A//twitter.com/houstonsafelock

								-->



                        </div>



                    </div>



                </section>



                <section class="bottom-section">



                    <table class="models-table responsive">



                        <thead>



                        <th>MODEL   ***</th>



                        <th>EXTERIOR <span class="head-cell-extra-info">(HxWxD) </th>



                        <th>INTERIOR <span class="head-cell-extra-info">(HxWxD) </th>



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



       

    </div>

                    <?php

                        	endwhile; ?>

                    

                    	<?php endif; ?>

						<?php

						



					}

				?>







					<?php get_template_part( 'template-parts/safe', 'images' ); ?>







					<section id="safe-line-features">



						<?php the_field( 'safe_line_features' ); ?>



					</section>







					<?php get_template_part( 'template-parts/safe', 'models-data' ); ?>







					<section id="interest-callout">



						<?php the_field( 'interest_section_content', 'option' ); ?>



					</section>







				</div>



			</div>



		</main><!-- #main -->



	</div><!-- #primary -->



	



<?php



get_footer();

