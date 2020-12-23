<?php
get_header();
global $wpdb;
require_once("pagination.class.php");
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
           
            <div id="header-hero" class="container-skew" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2016/08/safeMovingHeader.jpg');">

				<div class="container-straight">

					<div class="container-fixed">

						<h1>Blog</h1>        </div>

				</div>

			</div>
        	

			<div class="container-fixed">

			<p id="breadcrumbs">
     <span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb"><a href="<?=get_option('home')?>" rel="v:url" property="v:title">Home</a> &gt; <span class="breadcrumb_last">Blog</span></span></span>
</p>

			</div>

			<div class="post-content">

				<div class="container-fixed">
				
				   <div class="blog_sec">
   <?php 
 
   $p = new pagination;
   $limit="";
   $kw_posts= $wpdb->prefix."posts";/*and post_status = 'publish'*/
   $po= $wpdb->get_results( "SELECT *  FROM $kw_posts where post_type='post' and post_status = 'publish'");

   $items=count($po);
   if($items > 0) 
	   {
		$p->items($items);
		$p->limit(10);  
		$p->target("admin.php?page=Franchise");
		$p->currentPage($_REQUEST[$p->paging]);
		$p->calculate();
		$p->parameterName('paging');
		$p->adjacents(1);
		if(!isset($_REQUEST['paging']))
		 {
		   $p->page = 1;
		 }
		else 
		{
		$p->page = $_REQUEST['paging'];
		}
		$limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
		
	 }
	  
   // echo "SELECT *  FROM $kw_posts where post_type='post'  order by post_date DESC  $limit";
	 $post_ll= $wpdb->get_results( "SELECT *  FROM $kw_posts where post_type='post' and post_status = 'publish' order by post_date DESC  $limit");

	 if(count($post_ll) >0){
	 foreach($post_ll as $rr) 
	 { 
	?>	
  
		<div class="article_box"> 
		<h3> 
		<a href="<?=get_option('home')?>/blogdetail/<?=sanitize_title_with_dashes($rr->post_title)?>/<?=$rr->ID?>/">
		   <?php  if(strlen($rr->post_title) > 45) { echo substr($rr->post_title,0,45).'...';} else { echo $rr->post_title;} ?>
		</a>
		</h3>
		<div class="postDate"><?php echo date('M d, Y',strtotime($rr->post_date)); ?></div>
		        <?php $current_url=get_option('home')."/blogdetail/".sanitize_title_with_dashes($rr->post_title)."/".$rr->ID."/"; ?>
				<div class="share_icons">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri() . '/images/single-safe/fb-icon.png'; ?>" alt="Facebook"></a>
				
				<a href="https://twitter.com/home?status=<?php echo urlencode($current_url); ?>" target="_blank">
				<img src="<?php echo get_template_directory_uri() . '/images/single-safe/twitter-icon.png'; ?>" alt="Twitter" >
				</a>
				
				<a href="<?php echo 'mailto:' . get_field( 'email_address', 'option' ); ?>?subject=<?=$rr->post_title?>">
				<img src="<?php echo get_template_directory_uri() . '/images/single-safe/mail-icon.png'; ?>" alt="E-mail">
				</a>
				
				</div>
		<p> 
		 <?php 
		 if(strlen($rr->post_content) > 250) { echo substr($rr->post_content,0,250).'...';} else { echo $rr->post_content;} 
		 ?>
		</p> 
		
		<a href="<?=get_option('home')?>/blogdetail/<?=sanitize_title_with_dashes($rr->post_title)?>/<?=$rr->ID?>/" class="lock-butn"> Read More</a></div>
  <?php 
    }
  
   }  else { echo 'No  Blog Found';}  ?>

</div>

   
         <?php echo $p->show();  ?>
    


				<!--<div class="pagination">
                <ul>
                <li><a href="#"><</a></li>
                <li class="current"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">></a></li>
                </ul>
				</div>-->

			</div>

		</main><!-- #main -->

	</div><!-- #primary -->

	

<?php

get_footer();
