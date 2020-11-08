<?php

$promotion_active = get_field('oc_promotion_active','option');
if($promotion_active)
{

	$panel_bg = ' content__panel--purple';
	$button_bg = '';

?>


<section class="panel content content__panel<?php echo $panel_bg;?>">

	<div class="container">

		<h2 class="small-bottom animate-fade"><?php echo get_field('oc_offer_code_heading','option'); ?></h2>
		<p class="narrow--800 large-bottom animate-fade-up"><?php echo get_field('oc_offer_code_text','option'); ?></p>

	</div>
		
</section>


<?php
	}
?>
