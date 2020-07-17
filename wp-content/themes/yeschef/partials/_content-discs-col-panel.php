<?php 
while ( have_rows('sliding_disc_panel') ) : the_row();

	$config_background_color = get_sub_field('config_background_colour');
	$config_heading_size = get_sub_field('config_heading_size');
	$config_padding_top = get_sub_field('config_padding_top');
	$config_image_position = get_sub_field('config_image_position');


	$bg_class1 = ($config_background_color=='White' ? ' content__disc-cols--white' : ' content__disc-cols--image');
	$padding_class1 = ($config_padding_top=='None' ? ' content__disc-cols--no-top' : '');
	$button_controls_class1 = ($config_background_color=='White' ? ' black' : '');
	$button_class1 = ($config_background_color=='White' ? ' button--grey' : '');
	
	$size_class = ($config_heading_size=="Small" ? ' class="small"' : '');

	$button_text = get_sub_field('button_text');
	$button_link = get_sub_field('button_link');
	
	$intro = get_sub_field('intro');

	if($config_image_position=='Left')
		$bg_class2 = $bg_class1 . '--left';

	if($config_image_position=='Right')
		$bg_class2 = $bg_class1 . '--right';

	if($config_image_position=='None')
		$bg_class2 = '';


?>

	<section class="panel content content__disc-cols<?php echo $bg_class1;?><?php echo $bg_class2;?><?php echo $padding_class1;?>">

		<div class="container">

			<h2<?php echo $size_class;?>><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>

			

			<div class="disc-slider-container">
			
				<ul id="slider-controls" class="controls">

			  		<li class="prev<?php echo $button_controls_class1;?>" data-controls="prev" aria-controls="customize" tabindex="-1">
			        </li>
			        <li class="next<?php echo $button_controls_class1;?>" data-controls="next" aria-controls="customize" tabindex="-1">
			        </li>

				</ul>


				<div class="disc-slider" id="<?php echo get_sub_field('unique_slider_name');?>">
				
					<?php
					while ( have_rows('discs') ) : the_row(); 

						$icon = get_sub_field('icon');
					?>

					  <div class="disc">

					  	<div class="disc__container">


					  		<div class="disc__container__image">
					  		
					  		<?php 
					  		if($icon) {
					  		?>
						  		<img src="<?php echo $icon;?>">
						  	<?php 
					  		}
					  		?>

					  		</div>

						  	<div class="disc__container__title"><?php echo get_sub_field('title');?></div>
						  	<div class="disc__container__text"><?php echo get_sub_field('content');?></div>

						</div>
					  	
					  </div>


					<?php
					endwhile;
					?>


				</div>

			</div>


			<?php if($button_text) { ?>
				<div class="disc-cols-button-container">
					<a class="button<?php echo $button_class1;?> wrap" href="<?php echo $button_link;?>"><?php echo $button_text;?></a>
				</div>
			<?php } ?>

		</div>
				
	</section>


	<script>


		jQuery(window).ready(function($) {
			
			var climate_wrap = $('#<?php echo get_sub_field('unique_slider_name');?>');

		    if (climate_wrap.length > 0) {
		    
		      	var <?php echo get_sub_field('unique_slider_name');?> = tns({
				    container: '#<?php echo get_sub_field('unique_slider_name');?>',
				    items: 1,
				    slideBy: 1,
				    nav: false,
				    autoplay: false,
				    autoHeight: false,

				    controlsContainer: '#slider-controls',
		      //       navContainerClass: 'slider-nav',
		      //        navClass: ['slider-nav__prev', 'slider-nav__next'],
		      //        center: true,

				     responsive: {
				      640: {
				        items: 1
				      },
				      900: {
				        items: 2
				      },
				      1200: {
				        items: 3
				      }
				    }
				  });
		  	
		  	}

		});

	</script>


<?php 
endwhile
?>
