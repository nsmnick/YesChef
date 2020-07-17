<?php 

$heading_color_class =  ' internal-fullwidth-hero--sub-page';
$color_class = ' sub-page';

?>

<section class="internal-fullwidth-hero<?php echo $heading_color_class; ?>">
	<div class="container">

		<div class="internal-fullwidth-hero__container">

			<div class="internal-fullwidth-hero__container__col">
				
				<h1 class="animate<?php echo $color_class; ?>"><?php echo get_the_title() ?></h1>
				<div class="intro<?php echo $color_class; ?>" class="animate"><?php echo $introduction; ?></div>

			</div>

		
		</div>
		
	</div>
</section>