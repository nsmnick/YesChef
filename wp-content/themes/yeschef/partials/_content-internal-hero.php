<?php 


$config_display = get_field('config_display');

if($config_display!="No")
{
	$page_type = get_field('page_type');
	$heading_color_class = ($page_type == 'Landing Page' ? '' : ' internal-hero--sub-page');
	$color_class = ($page_type == 'Landing Page' ? '' : ' sub-page');

	?>

	<section class="internal-hero<?php echo $heading_color_class; ?>">
		<div class="container">

			<div class="internal-hero__container">

				<div class="internal-hero__container__col1">
					
					<h1 class="animate<?php echo $color_class; ?>"><?php echo get_the_title() ?></h1>
					<div class="intro<?php echo $color_class; ?>" class="animate"><?php echo get_field('introduction');?></div>

				</div>

				<div class="internal-hero__container__col2">
					<img class="animate-fade" src="<?php echo get_field('hero_image');?>">
				</div>

			</div>
			
		</div>
	</section>

<?php 
} else { ?>
	<section class="internal-hero">
	</section>
<?php	
}
?>
