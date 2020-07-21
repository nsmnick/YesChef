<?php

    /**
    * Template Name: How it works
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom">
		<div class="container container--narrow-1000">
			<h2 class="animate-fade"><?php echo get_field('heading');?></h2>

			<p class="intro animate"><?php echo get_field('intro');?></p>

		</div>
	</section>

	<section class="panel content content__panel no-bottom">
		<div class="container">
		<?php 

			$panels = get_field('panels');

			echo '<div class="panel-content-container">';
			$row = 0;
			foreach ( $panels as $panel ) 
			{
				//(($c = !$c)?' class="odd"':'')

					
					echo '<div class="panel-content-container__row animate-fade">';

					$pos_class="";

					if($row == 0) {
						$pos_class=" left";
					}

			
								
					echo '<div class="panel-content-container__row__col panel' . $pos_class . '">';
						
						echo $panel['content'];

					echo '</div>';

					echo '<div class="panel-content-container__row__col image' . $pos_class . '">';

						echo '<div class="image">';
							echo '<img src="' .$panel['icon']. '">';
						echo '</div>';	

					echo '</div>';

				//}

					echo '</div>';				


				if($row == 0) 
					$row=1;
				else
					$row=1;
			
			}	

			echo '</div>';
			?>

			
			
		</div>





	</section>


	<?php include_once 'partials/_content-simple-pricing.php'; ?>

	<?php include_once 'partials/_content-order-first.php'; ?>

	


<?php
	get_footer();
?>



