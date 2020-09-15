<?php

    /**
    * Template Name: Search Meals
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom">
		<div class="container">
			
			<?php 
				$heading = get_field('heading');
				$intro = get_field('intro');
			?>

			<h2 class="animate-fade"><?php echo $heading;?></h2>

			<?php 
			if($heading)
			{
				echo '<p class="animate">'.$intro.'.</p>';
			}
			?>

		</div>
	</section>

	<div id="meal-search">
	</div>


	<?php include_once 'partials/_content-order-first.php'; ?>

	<?php 
	$top='purple';
	$bottom='blue';
	include_once 'partials/_content-how-it-works.php'; 
	?>



<?php
	get_footer();
?>



