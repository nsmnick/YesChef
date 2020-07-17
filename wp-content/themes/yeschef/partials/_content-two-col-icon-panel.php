<?php 
while ( have_rows('two_col_icon_panel') ) : the_row();


	$config_background_color = get_sub_field('config_background_colour');
	$config_image_position = get_sub_field('config_image_position');

	$bg_class1 = ($config_background_color=='Yellow' ? ' content__two-cols-icon-panel--yellow' : ' content__two-cols-icon-panel--white');
	
	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';

	
	$intro = get_sub_field('intro');
	$heading_icon = get_sub_field('heading_icon');



?>

	<section class="panel content content__two-cols-icon-panel<?php echo $bg_class1;?><?php echo $bg_class2;?>">

		<div class="container">

			<?php 

			if($heading_icon)
			{ ?>
				<div class="section-heading-icon">
					<img src="<?php echo $heading_icon;?>">
				</div>
			<?php } ?>


			

			<h2><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>

			<?php echo get_sub_field('body_content'); ?>



			<?php
			if(have_rows('icons'))
			{
			?>
				<div class="two-cols-icon-container">
												
				<?php
				while ( have_rows('icons') ) : the_row(); 
				?>

					<div class="two-cols-icon-container__col">

						<div class="two-cols-icon-container__col__image">
							<img src="<?php echo get_sub_field('icon');?>">
						</div>

						<div class="two-cols-icon-container__col__content">
							<p><?php echo get_sub_field('content');?></p>
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