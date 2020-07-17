<?php

    /**
    * Template Name: Search Meals
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom">
		<div class="container">
			<h2>Browse our recipes & meals</h2>
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



