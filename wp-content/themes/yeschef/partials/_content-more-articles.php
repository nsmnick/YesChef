<?php 
	
	// If post type has not been set by code, then this component has been selected via a page block
	// so set it from config variable
	
	$border_class="";

	if(!$posttype)
	{

		if ( have_rows('related_articles_panel') ) : the_row();
		

			$posttype = (get_sub_field('config_article_type') == "News" ? "post" : "nsm_case_study_post");
			$heading = get_more_heading($posttype);
			$border_class = ' no-top-border';


			//echo get_sub_field('config_article_type');
			// echo 'POST TYPE';
			// echo $posttype;
			// //echo die();

		endif;
	}


	$articles = get_related_articles($posttype);

  	


	//echo print_r($articles);
?>


<section class="panel content content__more-articles">
	<div class="container">

		<div class="more-articles<?php echo $border_class;?>">
			<h2 class="small"><?php echo $heading; ?></h2>


			<div class="more-articles__list">

				<?php
				foreach ( $articles as $post ) 
				{
					//echo print_r($post);

					$imageURL = get_the_post_thumbnail_url($post->ID);
					$category = get_post_default_category(get_the_ID(),$post->post_type)
				?>

	


					<article class="more-articles__list__article">


						<div class="more-articles__list__article__category"><?php echo $category; ?></div>

						<a href="<?php echo get_permalink($post->ID); ?>" class="more-articles__list__article__image" style="background-image: url('<?php echo $imageURL;?>');">
						</a> 

						<div class="more-articles__list__article__content">
							
							<div class="more-articles__list__article__content__title">
								<a href="<?php echo get_permalink($post->ID); ?>">
									<?php echo $post->post_title; ?>
								</a>
							</div>

							<div class="more-articles__list__article__content__link">
								<a href="<?php echo get_permalink($post->ID); ?>" class="button button--yellow fit-content center ">Read more</a>
							</div>

						</div>
							
						
						

					</article>



				<?php
				}
				?>

				


			</div>


		</div>
		
	</div>
</section>

<?php wp_reset_postdata(); ?>


