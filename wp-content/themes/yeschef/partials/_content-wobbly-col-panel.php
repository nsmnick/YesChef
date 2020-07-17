<?php 
while ( have_rows('wobbly_col_panel') ) : the_row();

	$config_background_color = get_sub_field('config_background_colour');
	$config_image_position = get_sub_field('config_image_position');
	$config_heading_size = get_sub_field('config_heading_size');
	$config_narrow_icons = get_sub_field('config_narrow_icons');

	$bg_class1 = ($config_background_color=='Yellow' ? ' content__wobbly-cols--yellow' : ' content__wobbly-cols--white');
	
	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';

	$container_class = '';
	if($config_narrow_icons=='Yes')
		$container_class = " wobbly-cols-container--narrow";

	$size_class = ($config_heading_size=="Small" ? ' class="small"' : '');
	
	$intro = get_sub_field('intro');

?>

	<section class="panel content content__wobbly-cols<?php echo $bg_class1;?><?php echo $bg_class2;?>">

		<div class="container">


			<h2<?php echo $size_class;?>><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>


			<?php 
			
			$subheading = get_sub_field('subheading');

			if($subheading) { ?>
				<h3 class="subheading"><?php echo $subheading;?></h3>
			<?php } ?>





			<?php
			if(have_rows('cols'))
			{
			?>
				<div class="wobbly-cols-container<?php echo $container_class;?>">
												
				<?php
				while ( have_rows('cols') ) : the_row(); 
				?>	

					<div class="wobbly-cols-container__col">

						<div class="wobbly-cols-container__col__image">
							<img src="<?php echo get_sub_field('icon');?>">
						</div>

						<div class="wobbly-cols-container__col__title">
							<h3><?php echo get_sub_field('caption');?></h3>
						</div>

					</div>	


				<?php
				endwhile;
				?>
				</div>
			
			<?php
			}
			?>

		
		</div>
				
	</section>

<?php 
endwhile
?>

