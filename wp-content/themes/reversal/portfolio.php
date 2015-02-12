<?php $t =& peTheme(); ?>
<?php $title = get_the_title(); ?>
<?php $pcontent = get_the_content(); ?> 
<?php $pcontent = apply_filters( 'the_content', $pcontent ); ?>
<?php $project =& $t->project; ?>
<?php list($portfolio) = $t->template->data(); ?>

<?php $content =& $t->content; ?>

	<?php while ($content->looping()): ?>
	<?php $meta =& $content->meta(); ?>
	<?php $hasFeatImage = $content->hasFeatImage(); ?>
	
	<div class="single-portfolio" id="<?php $content->slug(); ?>">
		<a class="portfolio-close"><i class="icon-remove"></i></a>
		<div class="container">
			<div class="row">
				<?php switch($content->format()): case "gallery": // Gallery post ?>
				<div class="span6">
					<?php $t->media->size($meta->gallery,460,300); ?>
					<?php $t->gallery->output($meta->gallery->id); ?>
					<?php $t->media->size(); ?>
				</div>
				<div class="span6">
					<h2><?php $content->title(); ?></h2>
					<?php $content->content(); ?>
				</div>
				<?php break; case "video": // Video post ?>
				<div class="span8">
					<?php $videoID = $t->content->meta()->video->id; ?>
					<?php if ($video = $t->video->getInfo($videoID)): ?>
					<div class="video-container">
						<?php switch($video->type): case "youtube": ?>
						<iframe width="650" height="350" src="http://www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php break; case "vimeo": ?>
						<iframe src="http://player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="650" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php endswitch; ?>
					</div>
				</div>
				<div class="span4">
					<h2><?php $content->title(); ?></h2>
					<?php $content->content(); ?>
				</div>
				<?php endif; ?>
				<?php break; default: // Standard post ?>
				<div class="span6">
					<div class="image-container">
						<a href="<?php echo $content->get_origImage(); ?>" class="fancybox">
							<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),460,300); ?>" alt="<?php echo esc_html(get_the_content()); ?>">
							<i class="icon-plus"></i>
						</a>
					</div>
				</div>
				<div class="span6">
					<h2><?php $content->title(); ?></h2>
					<?php $content->content(); ?>
				</div>
				<?php endswitch; ?>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
	
	<div class="container">
	
		<div class="row">
			<div class="span12">
				<h1><?php echo $title; ?></h1>
				<hr class="fancy-hr">
				<?php echo $pcontent; ?>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<nav class="portfolio-filter clearfix">
					<ul>
						<?php $project->filter('',"keyword"); ?>
					</ul>
				</nav>
			</div>
		</div>
							
		<div class="row portfolio-container">		

			<?php while ($content->looping()): ?>
			<?php $meta =& $content->meta(); ?>
			<div class="span4 portfolio-item <?php $project->filterClasses(); ?>">
				<a href="#" data-portfolio="<?php $content->slug(); ?>">
					<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),460,300); ?>" alt="<?php echo esc_html(get_the_content()); ?>">
					<i class="icon-plus"></i>
				</a>
			</div>
			<?php endwhile; ?>

		</div>
		
	</div>
