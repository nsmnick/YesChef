<?php

    /**
    * Template Name: Place Order
    */

	get_header();
?>
	
	
	<section class="panel content content__panel no-bottom bottom-green">
		<div class="container container--narrow-1000">
			<h2><?php echo get_field('heading');?></h2>

			<p class="intro"><?php echo get_field('intro');?></p>

		</div>
	</section>


	<section class="panel content content__panel--white">
		<div class="container">
			<h2 class="with-green-stars">To be delivered Tuesday, July 14th</h2>

			<div class="form-container">
				<?php
				//$simple_locations = get_custom_post_terms_simple(get_the_ID(), 'nsm_job_locations','');
				//$field_values = array('job_ref'=>$jobref,'job_title'=>get_the_title(),'job_location'=>$simple_locations)
				
				gravity_form( 1, false, false, false, '', true );

				?>
			</div>

			?>
		</div>
	</section>

	
	<section class="panel content content__panel">
		<div class="container">
			<h2 class="with-stars">Place an order by phone</h2>
			<p class="place-order-intro">If you’d prefer to place your order over the phone, you can call us on the number below.<br/>Please be sure to have your payment card ready.</p>
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



