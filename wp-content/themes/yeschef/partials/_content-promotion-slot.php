<?php

	$promotion_active = get_field('promotion_active','option');
	if($promotion_active)
	{

?>


<section class="panel content content__panel content__panel--soft-dark-green">

	<div class="container">


		<h2 class="small-bottom animate-fade"><?php echo get_field('home_page_promotion_heading','option'); ?></h2>

		<p class="sub-heading narrow--800 animate-fade-up"><?php echo get_field('home_page_promotion_sub_heading','option'); ?></p>

		<p class="narrow--800 large-bottom animate-fade-up"><?php echo get_field('home_page_promotion_content','option'); ?></p>




		<?php

		$promotion_meals = get_field('promotion_meals','option');
		if($promotion_meals)
		{
		?>
			
			<div class="four-cols-recipe-container animate">								
			<?php
			
			foreach ($promotion_meals as $promotion_meal) {
			
				$meal = $promotion_meal['promotion_meal'];

			
				$imageURL = get_the_post_thumbnail_url($meal->ID);
				$summary = get_post_meta($meal->ID,'summary_information',true);

				$skill_levels = get_the_terms($meal->ID,'nsm_meal_skill_level');
    			

    			$skill_level='';
			    if($skill_levels) {
			      $skill_level = $skill_levels[0]->name;
			    }

			    $skill_image = '';
			    $skill_label = '';
			    switch ($skill_level) {
			    	case 'Medium':
			    		$skill_image = 'icon_skill_medium.svg';
			    		$skill_label = 'MEDIUM';
			    		break;

			    	case 'Hard':
			    		$skill_image = 'icon_skill_hard.svg';
			    		$skill_label = 'HARD';
			    		break;
			    	
			    	default:
			    		$skill_image = 'icon_skill_easy.svg';
			    		$skill_label = 'EASY';
			    		break;
			    }



				$prep_time = get_post_meta($meal->ID,'prep_time',true);
				$cook_time = get_post_meta($meal->ID,'cook_time',true);
				
				//echo print_r($meal);
				
			?>

			<div class="four-cols-recipe-container__col">

				<div class="meal-panel meal-panel--small">
					
					<div class="meal-panel__image">
			 			<img src="<?php echo $imageURL;?>">
			 		</div>

			 			<?php 
							include '_content-meal-stats.php'; 
						?>

			 		<div class="meal-panel__content">
						<h2><?php echo $meal->post_title;?></h2>
						<p class="summary"><?php echo $summary;?></p>
					</div>

					

					<div class="meal-panel__cta">
			 			<a class="button button--view-details" href="<?php echo get_permalink($meal->ID);?>">View Details</a>
					</div>


				</div>


			</div>	


			<?php
				};
			?>
			</div>



		
		<?php
		}
		?>
		
		<br/>
		<br/>
		<a href="/place-your-order/" class="button button--dark-blue"><?php echo get_field('promotion_cta_button_text','option'); ?></a>


		

	</div>
		
</section>


<?php
	}
?>
