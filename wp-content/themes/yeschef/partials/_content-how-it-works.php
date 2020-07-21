<?php 

	$bg_top_class = ($top=='green' ? '' : ' top-purple');
	$bg_bottom_class = ($bottom=='green' ? '' : ' bottom-blue');

?>
<section id="how-it-works" class="panel content content__panel content__panel--soft-dark-green<?php echo $bg_top_class;?><?php echo $bg_bottom_class;?>">

	<div class="container">


		<h2 class="animate-fade"><?php echo get_option('hit_title',''); ?></h2>

		
		
		<div class="four-cols-container animate">								

			<div class="four-cols-container__col">

				<div class="four-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('hit_col1_image',''); ?>">
				</div>

				<h3><?php echo get_option('hit_col1_heading',''); ?></h3>
				<p><?php echo get_option('hit_col1_content',''); ?></p>
			</div>

			<div class="four-cols-container__col">

				<div class="four-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('hit_col2_image',''); ?>">
				</div>
				
				<h3><?php echo get_option('hit_col2_heading',''); ?></h3>
				<p><?php echo get_option('hit_col2_content',''); ?></p>

			</div>

			<div class="four-cols-container__col">

				<div class="four-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('hit_col3_image',''); ?>">
				</div>
				
				<h3><?php echo get_option('hit_col3_heading',''); ?></h3>
				<p><?php echo get_option('hit_col3_content',''); ?></p>

			</div>

			<div class="four-cols-container__col">

				<div class="four-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('hit_col4_image',''); ?>">
				</div>
				
				<h3><?php echo get_option('hit_col4_heading',''); ?></h3>
				<p><?php echo get_option('hit_col4_content',''); ?></p>

			</div>

			
		</div>


		<br/>
		<br/>
		<a href="<?php echo get_option('hit_button_link',''); ?>" class="button button--dark-blue"><?php echo get_option('hit_button_text',''); ?></a>

		<p class="hit-footer-content"><?php echo get_option('hit_footer_content',''); ?></p>

	</div>
		
</section>
