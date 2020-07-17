<?php 
while ( have_rows('three_circle_image_panel') ) : the_row();

	$background_image = get_sub_field('background_image');
	$intro = get_sub_field('intro');

	$bg_image='';
	if($background_image)
		$bg_image = 'style="background-image: url(\''. $background_image . '\');"';
?>

	<section class="panel content content__three-circle-image-panel" <?php echo $bg_image;?>>

		<div class="container">

			<h2><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>


			
			<div class="three-circle-image-container">
												
				<div class="three-circle-image-container__col">
					<img src="<?php echo get_sub_field('image_one');?>">
				</div>
					
				<div class="three-circle-image-container__col">
					<img src="<?php echo get_sub_field('image_two');?>">
				</div>

				<div class="three-circle-image-container__col">
					<img src="<?php echo get_sub_field('image_three');?>">
				</div>

			</div>	
				

		</div>
		
	</section>


<?php 
endwhile
?>