<?php

    /**
    * Template Name: Search Additional Items
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom">
		<div class="container">
			<h2 class="animate-fade">Browse our recipes & meals</h2>

			<p class="animate">Aenean non mauris sapien. Praesent orci dolor, porta ut justo non, commodo dignissim ligula. Integer dui arcu, sollicitudin ut eros non, dignissim molestie urna. Aliquam erat volutpat.</p>

		</div>
	</section>

	<div id="additionalitem-search">
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



