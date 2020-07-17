<?php 
while ( have_rows('accordion_panel') ) : the_row();

	
	$config_background_color = get_sub_field('config_background_colour');

	$bg_class2 = '--white';

	switch ($config_background_color) {
		case 'Pale Yellow':
			$bg_class1 = ' content__accordion-panel--pale-yellow';
			$bg_class2 = '--yellow';
			break;

		case 'Pale Grey':
			$bg_class1 = ' content__accordion-panel--pale-grey';
			$bg_class2 = '--grey';		
			break;

		default:
			$bg_class1 = ' content__accordion-panel--white';
			$bg_class2 = '--white';		
			break;
	}
	



	$config_anchor_tag = get_sub_field('config_anchor_tag');

	if($config_anchor_tag) {
		echo '<a name="'.$config_anchor_tag.'" id="'.$config_anchor_tag.'"></a>';
	}

	?>

	<section class="panel content content__accordion-panel<?php echo $bg_class1;?>">

		<div class="container">

			<h2<?php echo $size_class;?>><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>


			<?php
			if(have_rows('sections'))
			{

				
			?>


				<div class="accordion-container">
												
				<?php
				while ( have_rows('sections') ) : the_row(); 

					$heading = get_sub_field('heading');
					$content = get_sub_field('content');
				?>

					<div class="accordion accordion<?php echo $bg_class2;?>">
						<h3><?php echo $heading;?></h3>
					</div>

					<div class="accordion-panel">

						<div class="accordion-panel__inner">
							<?php echo $content;?>
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