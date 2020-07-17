
<section class="panel content content__panel">

	<div class="container">


		<h2 class="with-stars"><?php echo get_field('fai_heading'); ?></h2>

		<!-- <p class="intro"><?php //echo get_field('fai_intro'); ?></p> -->

		
		<?php
		if(have_rows('additional_items'))
		{
		?>
			
			<div class="three-cols-container">								

				<?php

				$array = [];

				while ( have_rows('additional_items') ) : the_row(); 

					

					$additional_item = get_sub_field('additional_item');

					//echo print_r($additional_item);

					$imageURL = get_the_post_thumbnail_url($additional_item->ID);
					$price = get_post_meta($additional_item->ID,'price',true);
					$content = $additional_item->post_content;
				
					//echo print_r($additional_item);
					
					$array[$additional_item->ID] = [
						'title' => $additional_item->post_title
						, 'content' => $content
					];

				?>


					<div class="three-cols-container__col">

						<div class="meal-panel">
					
							<div class="meal-panel__image with-margin">
					 			<img src="<?php echo $imageURL;?>">
					 		</div>
			

					 		<div class="meal-panel__content">
								<h2><?php echo $additional_item->post_title;?></h2>
								<p class="price"><?php echo $price;?></p>

							</div>

							<div class="meal-panel__cta">
			 					<a class="button button--view-details additionalitem__link" href="#" data-id="<?php echo $additional_item->ID;?>">View Details</a>
			 					
								
				
							</div>

						</div>
					</div>


			<?php
				endwhile;



				$html .= '<script id="additionalitem-json" type="application/json">'
						.json_encode($array)
						.'</script>';
					echo $html;
				
				?>
		
					

			</div>





		<?php

		}
		?>
		
		

		<br/>
		<br/>
		<a class="button">View all our additional items</a>

	</div>

	<div id="additionalitem-modal"></div>;

		
</section>
