<?php 
while ( have_rows('stats_panel') ) : the_row();
?>

	<section class="panel content content__stats-panel" style="background-image: url('<?php echo get_sub_field('background_image');?>');">


		<div class="container">


			<div class="stats-panel-container">


				<div class="stats-panel-container__col1">

					<h2><?php echo get_sub_field('heading');?></h2>
					
					<div class="content">
						<?php echo get_sub_field('content');?>
					</div>

				</div>


				<div class="stats-panel-container__col2" style="background-image: url('<?php echo get_sub_field('background_image');?>');">

					<div class="stat-bubble stat-bubble--1">
						<img src="<?php echo IMAGES; ?>/stat-bubble.png" class="pulse-in pulse-in--1">
					</div>

					<div class="stat-bubble stat-bubble--2">
						<img src="<?php echo IMAGES; ?>/stat-bubble.png" class="pulse-in pulse-in--2">
					</div>

					<div class="stat-bubble stat-bubble--3">
						<img src="<?php echo IMAGES; ?>/stat-bubble.png" class="pulse-in pulse-in--3">
					</div>

				</div>

			</div>
		
	</section>


<?php 
endwhile
?>