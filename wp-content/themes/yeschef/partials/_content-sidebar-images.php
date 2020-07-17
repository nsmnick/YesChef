<?php 

while ( have_rows('images_group') ) : the_row();
?>

	<div class="sidebar__images-group">

		<?php
		while ( have_rows('sb_images') ) : the_row(); 
		?>

			<div class="sidebar__images-group__image">
				<img src="<?php echo get_sub_field('sb_image');?>">
			</div>

		<?php
		endwhile;
		?>
	</div>
		

<?php 
endwhile
?>