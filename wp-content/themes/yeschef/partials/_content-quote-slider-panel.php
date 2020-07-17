<?php 
while ( have_rows('sliding_quote_panel') ) : the_row();

	

?>

	<section class="panel content content__sliding_quote_panel">

		<div class="container">


			<div class="quote-slider-container">
			
				<ul id="slider-controls-quote" class="controls">

			  		<li class="prev" data-controls="prev" aria-controls="customize" tabindex="-1">
			        </li>
			        <li class="next" data-controls="next" aria-controls="customize" tabindex="-1">
			        </li>

				</ul>


				<div class="quote-slider" id="<?php echo get_sub_field('unique_slider_name');?>">
				
					<?php

					$color_alt=0;

					while ( have_rows('quotes') ) : the_row(); 

						$bg_class = ($color_alt==0 ? '' : ' quote__container--grey');



					?>

					  <div class="quote">

					  	<div class="quote__container<?php echo $bg_class;?>">
						  	
						  	<div class="quote__container__content"><?php echo get_sub_field('quote');?></div>
						  	<div class="quote__container__by"><?php echo get_sub_field('quote_by');?></div>

						</div>

						<div class="quote__tag">

							<?php if($color_alt) { ?>
								<img src="<?php echo IMAGES; ?>/quote-tag-grey.png">
							<?php } else { ?>
								<img src="<?php echo IMAGES; ?>/quote-tag-yellow.png">
							<?php } ?>
						</div>
 

					  	
					  </div>


					  <?php 

					  if($color_alt==0) {
							$color_alt=1;
					  } else {
							$color_alt=0;
					  }

						?>


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

				    controlsContainer: '#slider-controls-quote',
		      //       navContainerClass: 'slider-nav',
		      //        navClass: ['slider-nav__prev', 'slider-nav__next'],
		      //        center: true,

				     
				  });
		  	
		  	}

		});

	</script>


<?php 
endwhile
?>
