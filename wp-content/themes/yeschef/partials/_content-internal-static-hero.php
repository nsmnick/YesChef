<?php 

$heading_color_class =  ' internal-fullwidth-hero--sub-page';
$color_class = ' sub-page';

?>

<section class="internal-fullwidth-hero<?php echo $heading_color_class; ?>">
	<div class="container">

		<div class="internal-fullwidth-hero__container">

			<div class="internal-fullwidth-hero__container__col">
				
				<h1 class="animate<?php echo $color_class; ?>"><?php echo $heading; ?></h1>

				<?php if($introduction) { ?>
					<div class="intro<?php echo $color_class; ?>" class="animate"><?php echo $introduction; ?></div>
				<?php } ?>
				
			</div>

		
		</div>
		
	</div>
</section>