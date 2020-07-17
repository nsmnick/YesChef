<?php 

while ( have_rows('quote_group') ) : the_row();
?>

	<div class="sidebar__quote-group">

		<p class="quote"><?php echo get_sub_field('sb_quote');?></p>
		<p class="quote-by"><?php echo get_sub_field('sb_quote_by');?></p>

	</div>

	<div class="sidebar__quote-group__tag">						
		<img src="<?php echo IMAGES; ?>/quote-tag-yellow.png">
	</div>
		

<?php 
endwhile
?>