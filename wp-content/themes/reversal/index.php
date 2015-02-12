<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>

<section class="section blog" id="<?php $content->slug(); ?>">
	<div class="sec-bg-colorize"></div>
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="row">
						<div class="span9 col1">			
							<?php $t->content->loop(); ?>
						</div>
			
						<?php get_sidebar(); ?>
			
					</div>
				</div>
			</div>
		</div>
</section>

<?php get_footer(); ?>
