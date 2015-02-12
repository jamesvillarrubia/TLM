<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<section class="section" id="<?php $content->slug(); ?>">
	<div class="sec-bg-colorize"></div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1><?php $content->title(); ?></h1>
				<hr class="fancy-hr">
				<?php $showSkills = $meta->about->show === 'yes'; ?>
				<?php if ( $showSkills ) : ?>
				<div class="row">
					<div class="span8 content">
				<?php endif; ?>
				<?php $content->content(); ?>
				<?php if ( $showSkills ) : ?>
					</div>
					<div class="span4">
						
						<h3><?php echo $meta->about->skillstitle; ?></h3>
						<?php 
							$skills = array(
								'skill1' => array(
									'title'  => $meta->about->skill1,
									'amount' => $meta->about->skill1amount
								),
								'skill2' => array(
									'title'  => $meta->about->skill2,
									'amount' => $meta->about->skill2amount
								),
								'skill3' => array(
									'title'  => $meta->about->skill3,
									'amount' => $meta->about->skill3amount
								),
								'skill4' => array(
									'title'  => $meta->about->skill4,
									'amount' => $meta->about->skill4amount
								),
								'skill5' => array(
									'title'  => $meta->about->skill5,
									'amount' => $meta->about->skill5amount
								)
							);
							
							foreach( $skills as $skill ) { if ( $skill['title'] === '' ) continue; ?>
								
								<div class="progress">
									<div class="bar <?php if ( absint( $skill['amount'] ) < 40 ) echo 'empty'; ?>" style="width: <?php echo absint( $skill['amount'] ); ?>%;">
										<?php echo $skill['title']; ?>
									</div>
								</div>
								
							<?php } ?>
						
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>	
</section>