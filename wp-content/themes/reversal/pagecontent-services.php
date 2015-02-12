<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $count = 0; ?>

<section class="section" id="<?php $content->slug(); ?>">
	<div class="sec-bg-colorize"></div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1><?php $content->title(); ?></h1>
				<hr class="fancy-hr">
			</div>
			<?php if ( wp_kses_post( $meta->services->introtxt !== '' ) ): ?>
			<div class="span9">
				<h3><?php echo wp_kses_post( $meta->services->introtxt ); ?></h3>
			</div>
			<div class="span3 last">
			<?php if ( $meta->services->introbtn !== '' ) echo '<a href="' . esc_attr( $meta->services->introbtnlink ) . '" class="button float-right content-menu-link">' . sanitize_text_field( $meta->services->introbtn ) . '</a>'; ?>
			</div>
			<?php echo '<div class="span12"><hr class="fancy-hr"></div>'; ?>
			<?php endif; ?>
		</div>
		<?php if (!empty($meta->services->services)): ?>
		<?php if ($content->customLoop(
								"service",-1,null,
								array(
									  "post__in" => $meta->services->services,
									  "orderby" => "post__in"
									  ),false)): 
		?>
		<div class="row features first">				
			<?php while ($content->looping() ) : ?>
			<?php if ( $count !== 0 && $count % 4 === 0  ) echo '</div><div class="row features">	'; ?>
			<?php $meta =& $content->meta(); ?>
			<div class="span3 feature-box">
				<div class="box-content">
					<i class="<?php echo $meta->info->icon; ?> feature-icon"></i>
					<h4><?php $content->title() ?></h4>
					<p><?php $content->content(); ?></p>
				</div>
	      	</div>
			<?php $count++; ?>
			<?php endwhile; ?>
			<?php $content->resetLoop(); ?>
		</div>
		<div class="row"><div class="span12"><hr class="fancy-hr"></div></div>
		<?php endif; ?>
		<?php endif; ?>
		<div class="row">
			<div class="span12">
				<?php $content->content(); ?>
			</div>
		</div>
	</div>	
</section>