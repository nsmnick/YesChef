<?php 
while ( have_rows('two_cols_60-40_panel') ) : the_row();


	$intro = get_sub_field('intro');
	
	$col_one = get_sub_field('col1');
	$col_two = get_sub_field('col2');


?>

	<section class="panel content content__two-cols-60-40">

		<div class="container">

			<h2><?php echo get_sub_field('heading');?></h2>

			
			<?php 
			$width_class = 'Narrow';
			include '_content-section-intro.php'; 
			?>


			<div class="two-cols-60-40-container">

				<div class="two-cols-60-40-container__col1">
					<?php echo $col_one;?>
				</div>

				<div class="two-cols-60-40-container__col2">
					<?php echo $col_two;?>
				</div>

			</div>

		</div>
		
	</section>


<?php 
endwhile
?>