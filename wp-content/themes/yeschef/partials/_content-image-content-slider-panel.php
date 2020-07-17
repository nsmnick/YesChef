<?php 


while ( have_rows('image_content_slider') ) : the_row();

	$config_image_layout = get_sub_field('config_image_layout');

	$container_class='';
	$image_class='';
	$content_class = '';
	$subtitle_class = '';


	if($config_image_layout == "Circle")
	{
		$container_class = " content-section__container__image--circle";
		$image_class = 'circle';
		$content_class = ' circle';
		$subtitle_class = ' intro--circle';
	}

?>


	<section class="content content__image-content-slider-panel">

		<div class="container">
			

			<div class="image-content-slider-container">
			
				<ul id="slider-controls-case" class="controls">

			  		<li class="prev" data-controls="prev" aria-controls="customize" tabindex="-1">
			        </li>
			        <li class="next" data-controls="next" aria-controls="customize" tabindex="-1">
			        </li>

				</ul>


				<div class="image-content-slider" id="<?php echo get_sub_field('unique_slider_name');?>">
				  
				 
				 	<?php
					while ( have_rows('slides') ) : the_row(); 
					?>

						<div class="content-section">

						  	<div class="content-section__container">

							  	<div class="content-section__container__image<?php echo $container_class;?>">
							  		<img class="<?php echo $image_class;?>" src="<?php echo get_sub_field('photo');?>">
							  	</div>

							  	<div class="content-section__container__content<?php echo $content_class;?>">
							  		
							  		<h3><?php echo get_sub_field('heading');?></h3>

							  		<p class="intro<?php echo $subtitle_class;?>"><?php echo get_sub_field('sub_heading');?></p>

							  		<p><?php echo get_sub_field('content');?></p>

							  	</div>

							</div>
						  	
						</div>

				  	<?php
					endwhile;
					?>


				</div>

			</div>

		</div>
				
	</section>


	<script>


		jQuery(window).ready(function($) {
			
			var <?php echo get_sub_field('unique_slider_name');?>_wrap = $('#<?php echo get_sub_field('unique_slider_name');?>');
	    
		    if (<?php echo get_sub_field('unique_slider_name');?>_wrap.length > 0) {

		    
		      	var <?php echo get_sub_field('unique_slider_name');?> = tns({
				    container: '#<?php echo get_sub_field('unique_slider_name');?>',
				    center: true,
				    items: 1,
				    slideBy: 1,
				    nav: false,
				    autoplay: false,
				    autoHeight: false,
				    controlsContainer: '#slider-controls-case',
		      
				});
		  	
		  	}

		});

	</script>


<?php 
endwhile
?>
