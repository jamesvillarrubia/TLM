<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $bg = empty($meta->bg->background) ? false : $meta->bg->background;  ?>

<?php if ($bg): ?>
<?php 
$params = array( 'grayscale' => true, 'brightness'=>250);
$image = bfi_thumb( $meta->bg->background, $params );
$image = esc_url($image);

?>

<section id="intro" class="section intro" style="background-image: url('<?php echo $image; ?>')">
	<div class="sec-bg-colorize"></div>
<?php else: ?>
<section id="intro" class="section intro">
	<div class="sec-bg-colorize"></div>
<?php endif; ?>
	<div class="container">
		<div class="row">
			<h1><?php echo wp_kses_post( $meta->bg->introtitle ); ?></h1>
			<h2><?php echo wp_kses_post( $meta->bg->intro ); ?></h2>
			<?php if (!empty($meta->bg->label)): ?>
			<a class="get-started content-menu-link" href="<?php echo get_permalink() . esc_attr($meta->bg->url) ?>"><?php echo $meta->bg->label ?></a>
			<?php endif; ?>
			
		</div>
	</div>
	
</section>