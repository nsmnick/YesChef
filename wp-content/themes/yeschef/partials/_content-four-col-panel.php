<?php 
while ( have_rows('four_cols_group') ) : the_row();


	$config_background_color = get_sub_field('config_background_colour');
	$config_image_position = get_sub_field('config_image_position');
	$config_heading_size = get_sub_field('config_heading_size');
	$config_col_heading_colour = get_sub_field('config_col_heading_colour');


	switch ($config_background_color) {
		case 'Yellow':
			$bg_class1 = ' content__four-cols--yellow';
			break;

		case 'Grey':
			$bg_class1 = ' content__four-cols--grey';
			break;
		
		default:
			$bg_class1 = ' content__four-cols--white';
			break;
	}
	
	
	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';

	$c_class1 = '';
	if($config_col_heading_colour=='White')
		$c_class1 = ' white';

	$size_class = ($config_heading_size=="Small" ? ' class="small"' : '');
	
	$intro = get_sub_field('intro');
	$body_content = get_sub_field('body_content');
	$bottom_content = get_sub_field('bottom_content');



?>

	<section class="panel content content__four-cols<?php echo $bg_class1;?><?php echo $bg_class2;?>">

		<div class="container">

			<h2<?php echo $size_class;?>><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>


			<?php if($body_content) {

				echo '<div class="four-cols-content-container">';
				echo $body_content;
				echo '</div>';
			}
			?>





			<?php
			if(have_rows('cols'))
			{
			?>
				<div class="four-cols-container">
												
				<?php
				while ( have_rows('cols') ) : the_row(); 
				?>

					<div class="four-cols-container__col">

						<div class="four-cols-container__col__image">
							<img src="<?php echo get_sub_field('icon');?>">

						</div>

						<div class="four-cols-container__col__title<?php echo $c_class1;?>">
							<h3><?php echo get_sub_field('title');?></h3>
						</div>

						<div class="four-cols-container__col__intro">
							<p><?php echo get_sub_field('content');?></p>
						</div>

						<?php 
							$button_text = get_sub_field('button_text');

							if($button_text)
							{
						?>

						<div class="four-cols-container__col__button">
							<a class="button button--large" href="<?php echo get_sub_field('button_link');?>"><?php echo get_sub_field('button_text');?></a>
						</div>

						<?php 
						}
						?>


					</div>	


				<?php
				endwhile;
				?>
				</div>
			
			<?php
			}
			?>

			<?php if($bottom_content) {

				echo '<div class="four-cols-content-container no-margin-bottom">';
				echo $bottom_content;
				echo '</div>';
			}
			?>
				

		</div>
		
	</section>


<?php 
endwhile
?>