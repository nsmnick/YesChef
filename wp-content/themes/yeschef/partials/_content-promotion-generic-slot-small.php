<?php

	$general_promotion_active = get_field('general_promotion_active','option');
	if($general_promotion_active)
	{

			$panel_bg = ' content__panel--blue';
			$button_bg = '';

?>


<section class="panel content content__panel<?php echo $panel_bg;?>">

	<div class="container">


		<h2 class="small-bottom animate-fade"><?php echo get_field('general_order_page_promotion_heading','option'); ?></h2>

		<p class="sub-heading narrow--800 animate-fade-up"><?php echo get_field('general_order_page_promotion_sub','option'); ?></p>

		<p class="narrow--800 large-bottom animate-fade-up"><?php echo get_field('general_order_page_promotion_content','option'); ?></p>




		<?php

		$general_content_slots = get_field('general_content_slots','option');
		if($general_content_slots)
		{
		?>
			
			<div class="four-cols-recipe-container animate">								
			<?php
			
			foreach ($general_content_slots as $general_slot) {
			
				$slot = $general_slot['general_content'];
		
			?>

			<div class="four-cols-recipe-container__col">

				<div class="generic-content-container">
					<?php echo $slot;?>
				</div>

			</div>	


			<?php
				};
			?>
			</div>



		
		<?php
		}
		?>


		<br/>

		<?php if(get_field('general_order_page_footer_content','option')) { ?>
			<p class="narrow--800 large-bottom animate-fade-up"><?php echo get_field('general_order_page_footer_content','option'); ?></p>
		<?php } ?>

		<br/>


<!-- 		<a href="<?php //echo get_field('general_promotion_url_link','option'); ?>" class="button<?php //echo $button_bg;?>"><?php //echo get_field('general_order_page_select_button_text','option'); ?></a>
 -->

		

	</div>
		
</section>


<?php
	}
?>
