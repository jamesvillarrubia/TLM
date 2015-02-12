<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<section class="section blog" id="<?php $content->slug(); ?>">
	<div class="sec-bg-colorize"></div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1><?php $content->title(); ?></h1>
				<hr class="fancy-hr">
				<div class="row">
					<div class="span9 col1">			
						<?php $content->blog($meta->blog,false); ?>
					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</section>