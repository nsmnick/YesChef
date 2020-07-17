<?php 
while ( have_rows('sliding_block_panel') ) : the_row();
?>

	<section class="panel content content__sliding_block_panel">

		<div class="container">

			<h2><?php echo get_sub_field('heading');?></h2>

			<?php include '_content-section-intro.php'; ?>



			<div class="block-slider-container">
			
				<ul id="slider-controls-block" class="controls">

			  		<li class="prev" data-controls="prev" aria-controls="customize" tabindex="-1">
			        </li>
			        <li class="next" data-controls="next" aria-controls="customize" tabindex="-1">
			        </li>

				</ul>


				<div class="block-slider" id="<?php echo get_sub_field('unique_slider_name');?>">
				
					<?php
					while ( have_rows('blocks') ) : the_row(); 
					?>

					  <div class="block">

					  	<div class="block__container">

						  	<div class="block__container__image">
						  		<img src="<?php echo get_sub_field('icon');?>">
						  	</div>

						  	<div class="block__container__title"><?php echo get_sub_field('title');?></div>
						  	<div class="block__container__text"><?php echo get_sub_field('content');?></div>

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
				    items: 1,
				    slideBy: 1,
				    nav: false,
				    autoplay: false,
				    autoHeight: false,

				    controlsContainer: '#slider-controls-block',
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
