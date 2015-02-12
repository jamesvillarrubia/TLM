<?php $t =& peTheme();?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $replace = array("page-"=>"",".php"=>""); ?>
<?php if ( !is_404() ) $template = strtr($content->pageTemplate(),$replace); ?>
<nav id="main-nav" <?php if ( is_404() || $template !== "home") echo 'class="nothome"'; // make sure menu displays nicely when not home template ?>>
	
	<?php $t->menu->show("main"); ?>

	<a href="<?php echo home_url(); ?>" class="logo">
		<img alt="logo" src="<?php echo $t->options->get("logo") ?>">
	</a>

	<a href="#" id="responsive-nav">
		<i class="icon-list"></i>
	</a>

</nav>