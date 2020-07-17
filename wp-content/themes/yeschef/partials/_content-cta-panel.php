<?php 
while ( have_rows('cta_panel') ) : the_row();

	$config_background_colour = get_sub_field('config_background_colour');

	$bg_class1 = ($config_background_colour=='Yellow' ? ' content__cta-panel--yellow' : ' content__cta-panel--grey');	
	$button_class1 = ($config_background_colour=='Yellow' ? '' : ' button--yellow' );	

?>

	<section class="panel content content__cta-panel<?php echo $bg_class1;?>">


		<div class="container">


			<div class="cta-panel-container">


				<div class="cta-panel-container__col1">

					<img src="<?php echo get_sub_field('image');?>">

				</div>


				<div class="cta-panel-container__col2">

					<h2><?php echo get_sub_field('heading');?></h2>
					
					<div class="intro">
						<?php echo get_sub_field('intro');?>
					</div>

					<div class="cta">
						<a class="button button--carat <?php echo $button_class1;?>" href="<?php echo get_sub_field('button_link');?>"><?php echo get_sub_field('button_text');?></a>
					</div>

				</div>

			</div>

		</div>
		
	</section>


<?php 
endwhile
?>