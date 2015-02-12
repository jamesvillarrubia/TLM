<?php $t =& peTheme(); ?>
<?php list($pid,$conf,$loop) = $t->template->data(); ?>
<?php $isSingular = ( is_singular('gallery') || is_singular('video') || is_singular('project') || is_singular( 'post' ) ) ? true : false; ?> 
<?php $id = $pid; ?>
<?php $w = ( $isSingular || ( is_page() && $post->post_type !== 'project' ) ) ? 650 : 460; ?>
<?php $w = ( is_page() && $post->post_type === 'page' ) ? 940 : $w; ?>
<?php 
	switch( $w ):
		case( 940 ): $h = 613; break;
		case( 650 ): $h = 424; break;
		case( 460 ): $h = 300; break;
	endswitch;
?>

<?php $slider = $t->gallery->getSliderLoop($id); ?>
<?php if ($slider): ?>
<!-- Slider -->
<div class="gallery-container">
	<div class="flexslider">
		<ul class="slides">
			<?php while ($slide =& $slider->next()): ?>
			<?php $img = $t->image->resizedImgUrl($slide->img,$w,$h); ?>
			<li>
				<?php if (!empty($slide->link)): ?>
				<a href="<?php echo $slide->link; ?>">
					<img src="<?php echo $img; ?>"/>
				</a>
				<?php else: ?>
				<img src="<?php echo $img; ?>"/>
				<?php endif; ?>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<!-- /Slider -->
<?php endif; ?>