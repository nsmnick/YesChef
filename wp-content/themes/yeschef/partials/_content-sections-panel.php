<?php 

while ( have_rows('content_sections_panel') ) : the_row();

	$heading = get_sub_field('heading');
	$intro = get_sub_field('intro');


?>

	
	<section class="panel content content__content-sections-panel">

		<div class="container">


			<?php 


			if($heading) {
				echo '<h2>' . $heading . '</h2>';
			} ?>

			<?php 
				include '_content-section-intro.php'; 
			?>


			<?php
			if(have_rows('sections'))
			{

				
				while ( have_rows('sections') ) : the_row(); 

					$section_heading = get_sub_field('section_heading');
					$section_link = get_sub_field('section_link');

					$section_background_colour = get_sub_field('config_section_heading_background_colour');

					$bg_class1 = '';
					if($section_background_colour == 'Grey') {
						$bg_class1 = ' section-container__col1--heading--grey';
						$bg_class2 = ' section-container__col2--heading--grey';
					}



					
				?>



					<div class="section-container">

							<div class="section-container__col1 section-container__col1--heading<?php echo $bg_class1;?>">
								<h3><?php echo $section_heading;?></h3>
							</div>

							<div class="section-container__col2 section-container__col2--heading<?php echo $bg_class2;?>">
								<a class="button button--carat" href="<?php echo $section_link;?>">Find out More</a>
							</div>

					</div>


					<div class="section-container">

							<div class="section-container__col1">


								<?php 
									$col1_content = get_sub_field('col1_content'); 
									$col2_content = get_sub_field('col2_content'); 

									if($col2_content!='')
									{
										?>
										<div class="two-cols-container">

											<div class="two-cols-container__col">
												<?php echo get_sub_field('col1_content'); ?>
											</div>

											<div class="two-cols-container__col">
												<?php echo get_sub_field('col2_content'); ?>
											</div>

										</div>

									<?php 
									} else {

										?>
										

										<?php echo get_sub_field('col1_content'); ?>
									
										

									<?php 

									}
									?>

								

							</div>

							<div class="section-container__col2">
								<img src="<?php echo get_sub_field('col3_image'); ?>">
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