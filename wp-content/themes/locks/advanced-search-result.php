<?php
// Get data from URL into variables
$s = $_GET['s'] != '' ? $_GET['s'] : '';



get_header(); ?>



	<div id="primary" class="content-area search-page">

		<main id="main" class="site-main" role="main">

			<div id="header-hero" class="container-skew" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2016/08/safeMovingHeader.jpg');">

				<div class="container-straight">

					<div class="container-fixed">

						<h1>Search Results</h1>        </div>

				</div>

			</div>

			<div class="container-fixed">

				<article>
                   <div class="entry-content">
				     <header class="page-header">
							<h2 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'locks' ), '<span>' . $s. '</span>' ); ?></h2>

						</header>
						<div class="safes-container">
                        <ul>
						<?php 
						global $wpdb;
						$tbl=$wpdb->postmeta;
						$result = $wpdb->get_results("select * from $tbl where meta_value like '%".$s."%' and meta_key like 'models_%_model_code'");

						 if(count($result)>0)
						 {
						   foreach ($result as $rs)
						   {
						     $tt=$rs->meta_key; 
							 $indx=str_replace('_model_code','',str_replace('models_','',$tt));
							 $img_ind='models_'.$indx.'_model_image';
							 $key_1_values = get_post_meta( $rs->post_id, $img_ind ,true);
							 $image_url=get_post_field('guid', $key_1_values);
						   
						    ?>
							<li>
							<article id="post-<?php echo $rs->post_id; ?>" <?php post_class(); ?>>
							  <header class="entry-header">
							  <h3 class="entry-title"><a href="<?php echo add_query_arg( array('post' =>$rs->post_id, 'model' => $indx+1),site_url()."/safe-details");?>"><?php echo $rs->meta_value;?></a></h3>
					       	<div class="img">
					       <?php 
					    if($image_url!='') {
					?><a class="detail-page-link" href="<?php echo add_query_arg( array('post' =>$rs->post_id, 'model' => $indx+1),
  site_url()."/safe-details");?>">
					<img alt="" src="<?=$image_url?>" width="200px" height="200px"> </a>
					<?php }?>		
					</div>
					
					</header>
							</article>
                              </li>
							<?php 
						   }

						 
						 }
						 else
						 { get_template_part( 'template-parts/content', 'none' ); }
						?>
						</ul>
				    
                   </div>
				</article>

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->



<?php

get_footer();

