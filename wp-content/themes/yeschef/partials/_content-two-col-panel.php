<?php 
while ( have_rows('two_cols_group') ) : the_row();

	$config_background_colour = get_sub_field('config_background_colour');
	
	switch ($config_background_colour) {
		case 'Yellow':
			$bg_class1 = ' content__two-cols--yellow';
			break;

		case 'Light Yellow':
			$bg_class1 = ' content__two-cols--light-yellow';
			break;
		
		default:
			$bg_class1 = ' content__two-cols--white';
			break;
	}
	

	$anchor_tag = get_sub_field('anchor_tag');
	$pre_heading = get_sub_field('pre_heading');
	$intro = get_sub_field('intro');
	$top_content = get_sub_field('top_content');
	$bottom_content = get_sub_field('bottom_content');

	$col_one = get_sub_field('col_one');
	$col_two = get_sub_field('col_two');



	
	if($anchor_tag) {
		echo'<a id="' . $anchor_tag . '" name="' . $anchor_tag . '"></a>';
	}


?>			
	<section class="panel content content__two-cols<?php echo $bg_class1;?>">

		<div class="container">


			<?php 

			if($pre_heading) {
				echo'<h2 class="pre-heading">' . $pre_heading . '</h2>';
			}

			?>
			<h2<?php echo $size_class;?>><?php echo get_sub_field('heading');?></h2>

			
			<?php 
			$width_class = 'Narrow';
			include '_content-section-intro.php'; 
			?>


			<div class="content content__two-cols--top-content">
				<?php echo $top_content;?>
			</div>


			<div class="two-cols-container">

				<div class="two-cols-container__col">
					<?php echo $col_one;?>
				</div>

				<div class="two-cols-container__col">
					<?php echo $col_two;?>
				</div>

			</div>

			<div class="content content__two-cols--bottom-content">
				<?php echo $bottom_content;?>
			</div>

		</div>
		
	</section>


<?php 
endwhile
?>