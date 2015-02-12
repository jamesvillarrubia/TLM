<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>

<section class="404" id="404">
		<div class="container">
			<div class="row">
				<div class="span12">
				<h1><?php e__pe("Page Not Found");  ?></h1>
				<hr class="fancy-hr">
				<p>
					<?php echo $t->options->get("404content"); ?>
				</p>
				</div>
			</div>
		</div>
</section>

<?php get_footer(); ?>