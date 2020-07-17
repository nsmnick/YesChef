<?php 
while ( have_rows('image_panel') ) : the_row();
?>

	<section class="panel content content__content-image-panel">

		<div class="container">
			
			<h2 class="small"><?php echo get_sub_field('heading');?></h2>

			<div class="fullwidth-image">
				<img class="fullwidth-image__desktop" src="<?php echo get_sub_field('desktop_image');?>">
				<img class="fullwidth-image__mobile" src="<?php echo get_sub_field('mobile_image');?>">
			</div>

		</div>
				
	</section>

<?php 
endwhile
?>