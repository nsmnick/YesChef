
<section class="panel content content__panel">

	<div class="container container--narrow-800">

		<h2 class="with-stars"><?php echo get_option('sp_title',''); ?></h2>

		<div class="two-cols-container">								

			<div class="two-cols-container__col">

				<div class="two-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('sp_col1_image',''); ?>">
				</div>

				<p><?php echo get_option('sp_col1_content',''); ?></p>
				<p class="price"><?php echo get_option('sp_col2_price',''); ?></p>

			</div>

			<div class="two-cols-container__col">

				<div class="two-cols-container__col__image">
					<img src="<?php echo site_url(); ?><?php echo get_option('sp_col2_image',''); ?>">
				</div>
				
				<p><?php echo get_option('sp_col2_content',''); ?></p>
				<p class="price"><?php echo get_option('sp_col2_price',''); ?></p>

			</div>

			
		</div>

	</div>
		
</section>
