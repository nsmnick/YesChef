<?php

    /**
    * Template Name: Place Order
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom bottom-green">
		<div class="container container--narrow-1000">
			<h2 id="page-heading" class="animate-fade"><?php echo get_field('heading');?></h2>

			<p id="page-intro" class="intro animate"><?php echo get_field('intro');?></p>

		</div>
	</section>

	<?php 

		
		// Create a new DateTime object
		$date = new DateTime();
		$date->modify('next tuesday');


		$heading = 'To be delivered ' . $date->format('l dS F');
	?>

	<section class="panel content content__panel--white">
		<div class="container">
			<h2 id="page-subheading" class="with-green-stars animate-fade"><?php echo $heading; ?></h2>

			<div class="form-container">
				<?php
				//$simple_locations = get_custom_post_terms_simple(get_the_ID(), 'nsm_job_locations','');
				//$field_values = array('job_ref'=>$jobref,'job_title'=>get_the_title(),'job_location'=>$simple_locations)
				
				gravity_form( 1, false, false, false, '', true );

				?>

				<script>
				
				</script>

			</div>

			
		</div>
	</section>

	
	<section id="order-by-phone" class="panel content content__panel">
		<div class="container">
			<h2 class="with-stars animate-fade">Place an order by phone</h2>
			<p class="place-order-intro animate-fade">If you’d prefer to place your order over the phone, you can call us on the number below.<br/>Please be sure to have your payment card ready.</p>
			<p class="place-order-phone">01622 000 000</p>
		</div>
	</section>

	<?php 
	$top='green';
	$bottom='blue';
	include_once 'partials/_content-how-it-works.php'; 
	?>

<?php
	get_footer();
?>



