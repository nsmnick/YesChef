
<section class="panel content content__three_image_cols">

	<div class="container container--narrow-1000">

		
		<?php
		if(have_rows('cols'))
		{
		?>
			
			<div class="three-cols-images-container">								
			<?php
			while ( have_rows('cols') ) : the_row(); 

				$image = get_sub_field('image');
				$title = get_sub_field('title');
				$content = get_sub_field('content');
				
			?>

				<div class="three-cols-images-container__col">

					<div class="three-cols-images-container__col__image">
						<img src="<?php echo $image;?>">
					</div>

					<div class="three-cols-images-container__col__title">
						<h3><?php echo $title;?></h3>
					</div>
					
					<div class="three-cols-images-container__col__intro">
						<p><?php echo $content;?></p>
					</div>

				</div>	


			<?php
			endwhile;
			?>
			</div>



		
		<?php
		}
		?>


		<div class="three-cols-images-container__subcontent">
			<?php echo get_field('sub_content'); ?>
		</div>
			

	</div>
		
</section>
