<?php
/**
* Template Name: Home Page
*/

get_header();


?>

	<?php 

	include_once 'partials/_content-home-hero.php';

	include_once 'partials/_content-three-images-col-panel.php';

	include_once 'partials/_content-promotion-slot.php';

	include_once 'partials/_content-latest-meals.php';

	include_once 'partials/_content-featured-additional-items.php';

	$top='green';
	$bottom='green';
	include_once 'partials/_content-how-it-works.php';

	include_once 'partials/_content-simple-pricing.php';
	

?>	

	<div id="additionalitem-modal"></div>


<?php
get_footer();
?>

