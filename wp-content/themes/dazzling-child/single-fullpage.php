<?php
/*
Template Name: Single Fullpage
*/

get_header();
?>

	<div class="container">
		<div class="row">
			<div id="front-masthead-title">Leadership through Transparency</div>
			<div id="front-masthead-subtitle">TLM Group LLC</div>

<?
	echo 'yes';
	// Use wp_get_theme() to get the theme object.
	$theme = wp_get_theme();
	print $theme;
	/**
	 * Set the prefix based on the theme object's 
	 * text domain. Text domains are required to use
	 * dashes in lieu of underscores, so we replace
	 * those here, as well as converting to string to
	 * lowercase in order to maintain consistency.
	 *
	 * i.e. the_textdomain_enable_less is more consistent
	 *      with other common WordPress filters than
	 *      Theme-TextDomain_enable_less.
	*/
	$prefix = strtolower( str_replace( '-', '_', $theme->get( 'TextDomain' ) ) );


	// Return our prefix, but allow users to modify if desired.
	print apply_filters( 'wptt_prefix', $prefix );


?>
		</div>
	</div>

<?php get_footer(); ?>