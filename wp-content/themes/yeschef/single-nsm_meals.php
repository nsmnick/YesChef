<?php
get_header(); ?>


<?php
while ( have_posts() ) : the_post(); 
	// $locations = get_custom_post_terms(get_the_ID(), 'nsm_job_locations','');
	// $functions = get_custom_post_terms(get_the_ID(), 'nsm_job_functions','');
	// $job_types = get_custom_post_terms(get_the_ID(), 'nsm_job_types','');

	


	$skill_levels = get_the_terms($post->ID,'nsm_meal_skill_level');
    			

	$skill_level='';
    if($skill_levels) {
      $skill_level = $skill_levels[0]->name;
    }

    $skill_image = '';
    $skill_label = '';
    switch ($skill_level) {
    	case 'Medium':
    		$skill_image = 'icon_skill_medium_sg.svg';
    		$skill_label = 'MEDIUM';
    		break;

    	case 'Hard':
    		$skill_image = 'icon_skill_hard_sg.svg';
    		$skill_label = 'HARD';
    		break;
    	
    	default:
    		$skill_image = 'icon_skill_easy_sg.svg';
    		$skill_label = 'EASY';
    		break;
    }



	$prep_time = get_post_meta($post->ID,'prep_time',true);
	$cook_time = get_post_meta($post->ID,'cook_time',true);



	// $introduction = '<ul class="">'
	// 				. '<li><b>Location:</b> ' . $locations . '</li>'
	// 				. '<li><b>Job Function:</b> ' . $functions . '</li>'
	// 				. '<li><b>Job Type:</b> ' . $job_types . '</li>'
	// 				. '</ul>';

	?>

	<?php //include_once 'partials/_content-internal-dynamic-hero.php';


	?>

	<section class="panel content content__image-panel" style="background-image: url('<?php echo get_the_post_thumbnail_url();?>');">

	</section>

	<section class="panel content content__meal-detail">

		<div class="container">


			<h1><?php echo $post->post_title;?></h1>

			<div class="content-detail-container">

				<p class="summary"><?php echo get_post_meta($post->ID, 'summary_information',true);?></p>

				<div class="description"><?php the_content(); ?></div>

				<div class="stats-outer-container">

					<div class="stats-outer-container__inner">

					<?php 
						include 'partials/_content-meal-stats.php'; 
					?>

					</div>

				</div>



				<!-- Tabs -->
				<?php 

					$ingredients_for_two = get_field('ingredients')[0];
					$ingredients_for_four = get_field('ingredients')[1];

					//$ingredients = $ingredients_for_four['ingredients'];
					//echo print_r($ingredients);

					$tabs_html = '';
					$tabs_content_html = '';

					if($ingredients_for_two && $ingredients_for_four)
					{

						

						$tabs_html .= '<a class="ingredients__tabs__tab ingredients__tabs__tab--left" href="#two-people">'
									.'Ingredients for 2'
									.'</a>';

						$tabs_content_html .= '<div id="two-people" class="ingredients__media__tab">';
						$tabs_content_html .= '<div class="ingredients__media">';

						$ingredients = $ingredients_for_two['ingredients'];

						$tabs_content_html .= '<ul class="ingredients">';					
						foreach ($ingredients as $ingredient) {
							$tabs_content_html .= '<li>'.$ingredient['ingredient'].'</li>';
						}
						$tabs_content_html .= '</ul>';					

						$tabs_content_html .= '<hr/>';
						$tabs_content_html .= '<p class="footer-text">';
						$tabs_content_html .= $ingredients_for_two['footer_text'];
						$tabs_content_html .= '</p>';

						$tabs_content_html .= '</div>';
						$tabs_content_html .= '</div>';


						
						$tabs_html .= '<a class="ingredients__tabs__tab ingredients__tabs__tab--right" href="#four-people">'
									.'Ingredients for 4'
									.'</a>';

						$tabs_content_html .= '<div id="four-people" class="ingredients__media__tab">';
						$tabs_content_html .= '<div class="ingredients__media">';

						$ingredients = $ingredients_for_four['ingredients'];

						$tabs_content_html .= '<ul class="ingredients">';					
						foreach ($ingredients as $ingredient) {
							$tabs_content_html .= '<li>'.$ingredient['ingredient'].'</li>';
						}
						$tabs_content_html .= '</ul>';

						$tabs_content_html .= '<hr/>';
						$tabs_content_html .= '<p class="footer-text">';
						$tabs_content_html .= $ingredients_for_four['footer_text'];
						$tabs_content_html .= '</p>';

						


						$tabs_content_html .= '</div>';
						$tabs_content_html .= '</div>';

					}
		
				?>


				<div id="ingredients" class="ingredients">
					
					<div class="ingredients__tabs">
						<div class="container">
							<div class="ingredients__tabs__container">
							<?php
							echo $tabs_html;
							?>
							</div>
						</div>
					</div>
		
					<div class="ingredients__media">
						
						<?php
							echo $tabs_content_html;
						?>
						
						


					</div>






			</div>




		</div>
				
	</section>

	<section class="panel content content__meal-detail">

		<div class="container">
			<h2>Recipe method</h2>

			<div class="content-detail-container">
				<div class="steps">
				<?php 
					$recipe = get_field('receipe');

					//echo print_r($recipe);

					if($recipe)
					{
						foreach ($recipe as $step) {
						?>

							<div class="step">

								<div class="step__images">


									<img src="<?php echo $step['images'][0]['image'];?>">

									<?php 

									

									if(count($step['images']) > 1)
									{?>
										<img class="last" src="<?php echo $step['images'][1]['image'];?>">
									
									<?php
									}

									?>

								</div>

								<h3><?php echo $step['step_heading'];?></h3>

								<p><?php echo $step['instructions'];?></p>


							</div>


						<?php 	
						}
					}
				?>

				</div>
				

			</div>

			<img src="<?php echo get_field('nutrients_image'); ?>">

		</div>

		

	</section>


	<?php include_once 'partials/_content-order-first.php'; ?>

	<?php 
	$top='purple';
	$bottom='blue';
	include_once 'partials/_content-how-it-works.php'; 
	?>



<?php
endwhile;

get_footer();
?>

