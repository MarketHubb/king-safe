<!-- related topics -->
<?php // BOF: CLW Related Topics & Children
  $count=0; $RTs='';
  $sibTs = get_pages( array( 'parent' => $post->post_parent, 'hierarchical' => 0, 'exclude' => $post->ID, 'meta_key' => 'wp_is_topic', 'meta_value' => 1));
  $subTs = get_pages( array( 'parent' => $post->ID, 'hierarchical' => 0, 'meta_key' => 'wp_is_topic', 'meta_value' => 1));
  $RelatedTs = array_merge($sibTs, $subTs);
   
  if (count($RelatedTs) > 0 ) :
	foreach ($RelatedTs as $topic) {
		$RTs .= '<li><a href="'. get_page_link($topic->ID) .'">'. $topic->post_title .'</a></li>';
		$count++;
		if ($count===3){ $RTs .= "</ul>\n\t  <ul>"; $count=0;}
	}
?>
<h3>Related Topics:</h3>
<!--<table width="90%" id="rel_topics">-->
 <ul class="rel_topics_links clear"><?php echo $RTs; ?></ul>
<!--</table>-->
<?php endif; ?>

<?php 
	$others = get_pages( array( 'parent' => $post->ID, 'exclude' => $post->ID, 'hierarchical' => 0, 'meta_key' => 'wp_is_topic', 'meta_value' => 0));
	if (count($others) > 0 ) { ?> 
		<h3>Back to main topic: <a href="<?php echo get_page_link($post->post_parent); ?>"><?php echo get_the_title($post->post_parent); ?></a></h3>
		<ul class="rel_posts_links">
			<?php foreach ($others as $child) { 
				if (!empty($child->post_content) && (strpos($child->post_content, '<!--more-->'))) {
					$post_snippet = substr($child->post_content, 0, strpos($child->post_content, '<!--more-->')) .'<a href="'. get_page_link($child->ID) .'"> Read more...</a>';
			?>
			<li><p><a href="<?php echo get_page_link($child->ID); ?>"><?php echo $child->post_title; ?></a><br /><?php echo $post_snippet; ?></p></li>
<?php } else { ?>
			<li><a href="<?php echo get_page_link($child->ID); ?>"><?php echo $child->post_title; ?></a></li>
<?php } } ?>
		</ul>
<?php } // EOF: CLW Related Topics & Children ?>
