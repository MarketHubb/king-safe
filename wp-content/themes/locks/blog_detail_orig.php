<?php 
get_header();
$blogid=$_REQUEST['blogdetail'];

global $wpdb;
$kw_posts= $wpdb->prefix."posts"; 
$b_data = $wpdb->get_row( "SELECT *  FROM $kw_posts where ID='".$blogid."' ", ARRAY_A );
?>
<script src='<?php echo get_template_directory_uri(); ?>/js/jquery.elevatezoom.js'></script>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

            <div id="header-hero" class="container-skew" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2016/08/safeMovingHeader.jpg');">

				<div class="container-straight">

					<div class="container-fixed">

						<h1>Safe Detail</h1>        </div>

				</div>

			</div>
        	<div class="container-fixed">

				
			<p id="breadcrumbs">
			      <span><a href="<?php echo get_site_url(); ?>" rel="v:url" property="v:title">Home</a> &gt; 
				  <span><a href="<?=get_option('home')."/blog/"?>">Blog</a> &gt;
			      <span class="breadcrumb_last">Article</span>
				  
				  </span>
				  </span>
				  </span>  
				  
		   </p>

			</div>

			<div class="post-content">

				<div class="container-fixed">

					  <div class="colLeft single_article">
<h2><?=$b_data['post_title']?></h2>
<div class="postDate">
  <?php echo ucwords(get_the_author_meta('nicename',$b_data['post_author'])); ?>,
   <?php echo date('M d, Y',strtotime($b_data['post_date'])); ?>
</div>

<p><?php echo stripslashes($b_data['post_content']); ?></p>



   <div class="btn-posts">
       <a href="<?=get_option('home')."/blog/"?>" class="btn see-all">Back</a>
   </div>

</div>
				</div>

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->

	

<?php

get_footer();
