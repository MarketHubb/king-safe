<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package locks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
  <div class="img">
  <?php 
	$pid=get_the_ID();
	$image_id=get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'img-polaroid');
	if($image_url[0]!='') {	$image_url=$image_url[0]; } 
	else { $image_url="";} 
	
	if($image_url!='') {
  ?>
        <img alt="" src="<?=$image_url?>" width="200px" height="200px">
 <?php } ?>		
  </div>
 
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		
		
		

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php locks_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php locks_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
