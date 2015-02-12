<?php

class PeThemeReversalTemplate extends PeThemeTemplate  {

	public function __construct(&$master) {
		parent::__construct($master);
	}

	public function paginate_links($loop) {
		if (!$loop) return "";
?>
<div class="row-fluid post-pagination">
	<div class="<?php echo $loop->main->class ?>">
		<div class="pagination">
				<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
				<span class="page-info">
					<?php e__pe("Page"); ?> 
					<?php echo ' ' . $paged . ' '; ?>
					<?php e__pe("of"); ?>
					 <?php echo $loop->last + 1; ?>
				</span>
				<?php while ($page =& $loop->next()): ?>
				<a href="<?php echo $page->link; ?>" class="<?php echo $page->class; ?>"><?php echo $page->num; ?></a>
				<?php endwhile; ?>
		</div>  
	</div>
</div>
<?php
	}


}

?>