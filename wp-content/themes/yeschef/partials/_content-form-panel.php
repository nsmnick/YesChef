<?php 
while ( have_rows('form_panel') ) : the_row();

	$config_background_colour = get_sub_field('config_background_colour');
	$config_image_position = get_sub_field('config_image_position');
	
	switch ($config_background_colour) {
		case 'Yellow':
			$bg_class1 = ' content__form-panel--yellow';
			break;

		case 'Light Yellow':
			$bg_class1 = ' content__form-panel--light-yellow';
			break;
		
		default:
			$bg_class1 = ' content__form-panel--white';
			break;
	}


	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';

	

	$heading = get_sub_field('heading');
	$intro = get_sub_field('intro');
	$formID = get_sub_field('form_id');
	$form_footer_text = get_sub_field('form_footer_text');



?>

	<section class="panel content content__form-panel<?php echo $bg_class1;?><?php echo $bg_class2;?>">

		<div class="container">

	
			<div class="form-panel-container">

				<div class="form-panel-container__col1">
					<h2><?php echo $heading;?></h2>
					<p><?php echo $intro;?></p>
				</div>

				<div class="form-panel-container__col2">

					<div class="form-container">
						<?php
						gravity_form( $formID, false, false, false, null, true );
						?>

						<p class="privacy-text light-bg">
							<?php echo $form_footer_text;?>
						</p>

					</div>
						
				</div>

			</div>

			

		</div>
		
	</section>


<?php 
endwhile
?>