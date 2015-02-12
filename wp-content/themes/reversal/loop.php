<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $isSingle = is_single(); ?>

<?php while ($content->looping() ) : ?>
<?php $meta =& $content->meta(); ?>
<?php $link = get_permalink(); ?>
<?php $type = $content->type(); ?>
<?php $hasFeatImage = $content->hasFeatImage(); ?>

<div class="post post-single">
	<div class="inner-spacer-right-lrg">
		<div class="post-title">
			<?php if ($isSingle): ?>
			<h2><?php $content->title() ?></h2>
			<?php else: ?>
			<h2><a href="<?php echo $link ?>"><?php $content->title() ?></a></h2>
			<?php endif; ?>
		</div>
			
		<hr class="fancy-hr-alt">
		
		<?php if (!is_singular('gallery') && !is_singular('video')): ?>
		<div class="post-meta">
		
			<div class="post-meta-date">
				<i class="icon-time"></i> <?php $t->content->date(); ?>
			</div>
			
			<?php if ($type === "post"): ?>
			<div class="post-meta-category">
				<i class="icon-folder-open"></i> <?php $content->category(); ?>
			</div>
			<?php endif; ?>
			
			<?php if (has_tag()): ?>
			<div class="post-meta-tags">
				<i class="icon-tags"></i> <?php the_tags('',', ',''); ?>
			</div>
			<?php endif; ?>
			
			<div class="post-meta-comments">
				<i class="icon-comment"></i> <a href="<?php echo $link ?>" class="active"><?php $t->content->comments() ?> <?php echo __pe("Comments"); ?></a>
			</div>			
			
		</div>
		<?php endif; ?>

		<div class="post-media clearfix">
			<?php if (is_singular('gallery')): ?>
			<?php $t->gallery->output(get_the_id()); ?>
			<?php $t->media->size(); ?>
			<?php endif; ?>
			<?php if (is_singular('video')): ?>
			<?php $videoID = get_the_id(); ?>
					<?php if ($video = $t->video->getInfo($videoID)): ?>
					<div class="video-container">
						<?php switch($video->type): case "youtube": ?>
						<iframe width="650" height="350" src="http://www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php break; case "vimeo": ?>
						<iframe src="http://player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="650" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php endswitch; ?>
					</div>
					<?php endif; ?>
			<?php endif; ?>
			<?php switch($content->format()): case "gallery": // Gallery post ?>
			<?php $t->media->size($meta->gallery,700,340); ?>
			<?php $t->gallery->output($meta->gallery->id); ?>
			<?php $t->media->size(); ?>
			<?php break; case "video": // Video post ?>
			<?php $videoID = $t->content->meta()->video->id; ?>
					<?php if ($video = $t->video->getInfo($videoID)): ?>
					<div class="video-container">
						<?php switch($video->type): case "youtube": ?>
						<iframe width="650" height="350" src="http://www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php break; case "vimeo": ?>
						<iframe src="http://player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="650" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						<?php endswitch; ?>
					</div>
					<?php endif; ?>
			<?php break; default: // Standard post ?>
			<?php if ($hasFeatImage): ?>
			<?php $imgLink = $isSingle ? $content->get_origImage() : $link; ?>
			<?php if (false): ?>
			<a href="<?php echo $imgLink; ?>"><?php $content->img(650,0); ?></a>
			<?php else: ?>
			<?php $content->img(650,0); ?>
			<?php endif; ?>
			<?php endif; ?>
			<?php endswitch; ?>

		</div>
		
		<div class="post-body">
			<?php $content->content(); ?>
		</div>

		<?php if ($isSingle): ?>
		<?php get_template_part("common","prevnext"); ?>
		<?php endif; ?>
	</div>
</div>
<?php if ($isSingle): ?>
<?php comments_template(); ?>
<?php endif; ?>
<?php endwhile; ?>
<?php if (!$isSingle): ?>
<?php $t->content->pager(); ?>
<?php endif; ?>
