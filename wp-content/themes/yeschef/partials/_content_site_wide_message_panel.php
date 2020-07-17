<?php 


	$site_wide_background_image = stripslashes(get_option('site_wide_background_image',''));
	$site_wide_heading = stripslashes(get_option('site_wide_heading',''));
	$site_wide_intro = stripslashes(get_option('site_wide_intro',''));
	$site_wide_button_text = stripslashes(get_option('site_wide_button_text',''));
	$site_wide_button_link = stripslashes(get_option('site_wide_button_link',''));


?>			
	<section class="panel content content__site-wide-panel" style="background-image: url('<?php echo $site_wide_background_image;?>')">

		<div class="container">

			<div class="site-wide-two-cols-container">

				
				<div class="site-wide-two-cols-container__col1">

					<h2 class="heading"><?php echo $site_wide_heading;?></h2>

					<div class="intro"><?php echo $site_wide_intro;?></div>

					<a href="<?php echo $site_wide_button_link;?>" class="button"><?php echo $site_wide_button_text;?></a>

				</div>

				<div class="site-wide-two-cols-container__col2">
				</div>


			</div>
		</div>
		
	</section>


