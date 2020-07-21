
<section class="panel content content__panel content__panel--blue">

	<div class="container">


		<h2 class="with-stars animate-fade"><?php echo get_field('heading'); ?></h2>

		
		<?php
		if(have_rows('meals'))
		{
		?>
			
			<div class="three-cols-container animate">								
			<?php
			while ( have_rows('meals') ) : the_row(); 

				$meal = get_sub_field('meal');

				//echo print_r($meal);

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

			<div class="three-cols-container__col">

				<div class="meal-panel">
					
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
				endwhile;
			?>
			</div>



		
		<?php
		}
		?>
		
		<br/>
		<br/>
		<a href="/recipes-meals/" class="button">View all recipes and meals</a>

	</div>
		
</section>
