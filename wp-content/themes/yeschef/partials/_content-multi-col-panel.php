<?php 
while ( have_rows('multi_col_panel') ) : the_row();
?>

	<section class="panel content content__multi-cols-panel">

		<div class="container">

			<h2 class="small"><?php echo get_sub_field('heading');?></h2>

			<?php
			if(have_rows('cols'))
			{
			?>
			
				<div class="multi-cols-container">

					<?php
					while ( have_rows('cols') ) : the_row(); 
					?>

						<div class="multi-cols-container__col">

							<div class="multi-cols-container__col__image">
								<img src="<?php echo get_sub_field('icon');?>">
							</div>

							<div class="multi-cols-container__col__title">
								<h3><?php echo get_sub_field('title');?></h3>
							</div>

							<div class="multi-cols-container__col__text">
								<p><?php echo get_sub_field('content');?></p>
							</div>

						</div>	

						<?php
					endwhile;
					?>
				</div>
			
			<?php
			}
			?>


		</div>
				
	</section>

<?php 
endwhile
?>

