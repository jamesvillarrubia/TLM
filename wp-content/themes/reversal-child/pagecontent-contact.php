<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $contact =& $meta->contact; ?>
<?php $gmap =& $t->content->meta()->gmap; ?>
<?php $hasFeatImage = $content->hasFeatImage(); ?>

<section class="section contacts" id="<?php $content->slug(); ?>" <?php if ($hasFeatImage): echo 'style="background: url(' . $content->get_origImage() . ') no-repeat center center;"'; endif; ?>>
	<div class="sec-bg-colorize"></div>
	<div class="container">
		<div class="row">
			<div class="span7">
		
				<form name="htmlform" method="post" class="peThemeContactForm contact-form">
					<h1><?php $content->title(); ?></h1>
					<hr class="fancy-hr">
					<input type="text" name="author" class="required" placeholder="<?php e__pe("Your lovely Name"); ?>" required />
					<input type="email" name="email" class="required" placeholder="E-Mail" data-validation="email" required />
					<textarea name="message" cols="1" rows="5" class="required" placeholder="<?php e__pe("Tell us everything"); ?>" required ></textarea>
					<input name="send" type="submit" class="submit" value="<?php e__pe("Send"); ?>" />
					<!--alert success-->
					<div id="contactFormSent" class="formSent fade in hide">
						<?php echo $contact->msgOK; ?>
					</div>
				
					<!--alert error-->
					<div id="contactFormError" class="formError fade in hide">
						<?php echo $contact->msgKO; ?>
					</div>
				</form>
				
			</div>
			
			
			<div class="span4 offset1">
			
				<?php if (!empty($contact->info)): ?>		
				<div class="contact-info content">
				<?php echo $contact->info; ?>
				</div>		
				<?php endif; ?>
				
				<?php if (!empty($contact->socialLinks)): ?>		
				<div class="social">
					<h3 class="no-bottom-margin"><?php e__pe("Follow us"); ?></h3>
					<hr class="fancy-hr">
					<ul>
						<?php $t->content->socialLinks($contact->socialLinks); ?>
					</ul>
				</div>
				<?php endif; ?>
				
			</div>
			
			
			
		</div>		
	</div>
	
	<?php if ($gmap->show == "yes"): ?>
	<!-- Google Map -->
	<div id="google-map" class="gmap" data-latitude="<?php echo $gmap->latitude; ?>" data-longitude="<?php echo $gmap->longitude; ?>" data-title="<?php echo esc_attr($gmap->title); ?>" data-zoom="<?php echo $gmap->zoom; ?>" >
		<div class="description"><?php echo $gmap->description; ?></div>
	</div>
	<!-- /Google Map -->
	<?php endif; ?>
</section>