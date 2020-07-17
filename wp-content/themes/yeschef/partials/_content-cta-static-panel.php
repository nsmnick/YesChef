<?php 

	// Set $config_background_colour before include = 'Yellow';
	
	$cta_heading = get_option('static_cta_title');
	$cta_intro = get_option('static_cta_intro');
	$cta_button_text = get_option('static_cta_button_text');
	$cta_button_link = get_option('static_cta_button_link');

	$bg_class1 = ($config_background_colour=='Yellow' ? ' content__cta-panel--yellow' : ' content__cta-panel--grey');	
	$button_class1 = ($config_background_colour=='Yellow' ? '' : ' button--yellow' );	

	$imageURL = ($config_background_colour=='Yellow' ? 'talk-to-us-cta-icon-grey.svg' : 'talk-to-us-cta-icon.svg');	

?>

	<section class="panel content content__cta-panel<?php echo $bg_class1;?>">

		<div class="container">

			<div class="cta-panel-container">


				<div class="cta-panel-container__col1">

					<img src="<?php echo IMAGES . '/'. $imageURL;?>">

				</div>


				<div class="cta-panel-container__col2">

					<h2><?php echo $cta_heading;?></h2>
					
					<div class="intro">
						<?php echo $cta_intro;?>
					</div>

					<div class="cta">
						<a class="button button--carat <?php echo $button_class1;?>" href="<?php echo $cta_button_link;?>"><?php echo $cta_button_text;?></a>
					</div>

				</div>

			</div>

		</div>
		
	</section>


