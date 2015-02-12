<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<section class="section" id="<?php $content->slug(); ?>">
	<div class="sec-bg-colorize"></div>
	<div class="container">
		<div class="row">
			<div class="span12 content">
				<h1><?php $content->title(); ?></h1>
				<hr class="fancy-hr">
				<div class="clearfix"></div>
				<?php $content->content(); ?>
			</div>
		</div>
	</div>	
</section>