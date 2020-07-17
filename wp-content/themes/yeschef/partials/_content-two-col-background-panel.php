<?php 
while ( have_rows('two_col_background_panel') ) : the_row();

	$background_image = get_sub_field('background_image');
	
	
	$heading = get_sub_field('heading');
	$intro = get_sub_field('intro');
	$cols = get_sub_field('cols');


?>			
	<section class="panel content content__two-cols-background" style="background-image: url('<?php echo $background_image;?>');">

		<div class="container">

			<h2><?php echo $heading;?></h2>

			
			<p class="intro"><?php echo $intro;?></p>


			<div class="two-cols-background-container">
			
			<?php

			foreach ($cols as $col) {
			?>				
				<div class="two-cols-background-container__col">


					<div class="image-container">
						<img src="<?php echo $col['icon'];?>">
					</div>


					<div class="content-container">

					
						<div class="content-container__text">											
							<h3><?php echo $col['heading'];?></h3>

							<p><?php echo $col['intro'];?></p>
						</div>

						
						<div class="content-container__button">									
							<a href="<?php echo $col['button_url'];?>" class="button"><?php echo $col['button_text'];?></a>
						</div>

					</div>
				
				</div>
			
			<?php
			}
			?>


			</div>
			

				<!-- <div class="two-cols-container__col">
					<?php //echo $col_one;?>
				</div>

				<div class="two-cols-container__col">
					<?php //echo $col_two;?>
				</div>
 -->
			</div>

			

		</div>
		
	</section>


<?php 
endwhile
?>