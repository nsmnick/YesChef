<?php 
while ( have_rows('content_panel') ) : the_row();


	$config_background_color = get_sub_field('config_background_colour');
	$config_image_position = get_sub_field('config_image_position');
	$config_section_top_border = get_sub_field('config_section_top_border');
	$config_anchor_link = get_sub_field('config_anchor_link');

	$bg_class1 = ($config_background_color=='Yellow' ? ' content__content-panel--yellow' : ' content__content-panel--white');
	
	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';

	$padding_top_class = '';
	if($config_section_top_border=='Yes')
		$padding_top_class = ' content__content-panel--no-top';

	
	$heading = get_sub_field('heading');
	$intro = get_sub_field('intro');



?>

	<?php 
	if($config_anchor_link) {
		echo '<a name="'.$config_anchor_link.'" id="'.$config_anchor_link.'">';
	}
	?>

	
	<section class="panel content content__content-panel<?php echo $bg_class1;?><?php echo $bg_class2;?><?php echo $padding_top_class;?>">

		<div class="container<?php echo $border_class;?>">


			<?php 

			if($config_section_top_border=='Yes') {
				echo '<hr class="yellow height-3"/>';
			}


			if($heading) {
				echo '<h2>' . $heading . '</h2>';
			} ?>

			<?php 
				include '_content-section-intro.php'; 
				
				echo get_sub_field('section_content');
			?>

		</div>
		
	</section>


<?php 
endwhile
?>