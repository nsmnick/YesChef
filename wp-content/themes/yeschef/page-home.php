<?php
/**
* Template Name: Home Page
*/

get_header();
?>

	<?php 

	include_once 'partials/_content-home-hero.php';

	include_once 'partials/_content-three-images-col-panel.php';

	include_once 'partials/_content-latest-meals.php';

	include_once 'partials/_content-featured-additional-items.php';

	$top='green';
	$bottom='green';
	include_once 'partials/_content-how-it-works.php';

	include_once 'partials/_content-simple-pricing.php';
	

?>	


<?php
get_footer();
?>

