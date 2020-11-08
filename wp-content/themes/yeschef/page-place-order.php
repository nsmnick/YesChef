<?php

    /**
    * Template Name: Place Order
    */

	get_header();

	$courier_notice = get_field('courier_notice');
?>
	
	
	<section class="panel content content__panel no-bottom bottom-green">
		<div class="container container--narrow-1000">
			<h2 id="page-heading" class="animate-fade"><?php echo get_field('heading');?></h2>
			<p id="page-intro" class="intro animate"><?php echo get_field('intro');?></p>
		</div>
	</section>




	<?php 

		$date = get_next_order_date();
		$next_date = get_next_order_second_date();

		$heading = 'To be delivered<br/><small>' . $date->format('l dS M') . ' or ' . $next_date->format('l dS M') . '</small>';
	?>

	<section class="panel content content__panel--white">
		<div class="container">





			<h2 id="page-subheading" class="with-green-stars animate-fade"><?php echo $heading; ?></h2>

			<div class="form-container">
				<?php
				//$simple_locations = get_custom_post_terms_simple(get_the_ID(), 'nsm_job_locations','');
				
				$field_values = NULL; //array('order_date'=>$date->format('Y/m/d'));
				
				gravity_form( 5, false, false, false, $field_values , true );

				?>

				

			</div>



			<?php 
				if($courier_notice){
					echo '<p class="courier_notice">' . $courier_notice . '</p>';
				}
			?>
			

			

			
		</div>

		<div id="print-order-button">
			<a href="javascript:window.print();" class="button">Print Order</a>
		</div>

		
	</section>


	<?php include_once 'partials/_content-promotion-generic-slot-small.php'; ?>
	
	<section id="order-by-phone" class="panel content content__panel">
		<div class="container">
			<h2 class="with-stars animate-fade">Place an order by phone</h2>
			<p class="place-order-intro animate-fade">If you’d prefer to place your order over the phone, you can call us on the number below.<br/>Please be sure to have your payment card ready.</p>
			<p class="place-order-phone"><a href="tel:<?php echo get_option('company_phone_link', true); ?>"><?php echo get_option('company_phone', true); ?></a></p>
		</div>
	</section>

	<?php 
	$top='green';
	$bottom='blue';
	include_once 'partials/_content-how-it-works.php'; 
	?>

	

	<script>


		if (typeof fbq != "undefined") 
		{

			fbq('track', 'InitiateCheckout');
			console.log('fb event submitted');
		}
	

		<?php 

		$promotion_active = get_field('promotion_active','option');
		if($promotion_active)
		{
			$promotion_meals = get_field('promotion_meals','option');
			
			if($promotion_meals)
			{

		?>

				function populate_promotional_meals() 
				{
					console.log('pop meals');

					jQuery(function($) {

						<?php
						$count = 1;
						foreach ($promotion_meals as $promotion_meal) {
							$meal = $promotion_meal['promotion_meal'];
							
							echo "$('#input_1_".($count+4)."').val('".$meal->post_title."');";

							//echo "$('#input_1_".($count+4)."').hide();";

							$count++;

							?>
								console.log('<?php echo $meal->post_title;?>');
							<?php

						}
						?>
					});
				}

		<?php 
			}
		}
		?>


	</script>



<?php

	

	get_footer();
?>



