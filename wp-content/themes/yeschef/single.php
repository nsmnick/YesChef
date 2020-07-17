<?php
get_header(); ?>


<?php
while ( have_posts() ) : the_post(); ?>

	
	<?php 

	$posttype = get_post_type();
	$category=get_post_default_category(get_the_ID(),$posttype);
	
	
	include_once 'partials/_content-internal-news-hero.php';

	?>


	<section class="panel content content__news-detail">

		<div class="container">

		    <div class="breadcrumb">

		    	<?php echo get_backlink($posttype); ?>

	            
		    </div>


		    <div class="content-container">

		    	<div class="content-container__col1">
		    		
		    		<div class="article-content-container">
			    		<?php
						the_content(); 
						?>
					</div>
		    	</div>

		    	<div class="content-container__col2">
		    		
		    		<?php include_once 'partials/_content-side-blocks.php';?>

		    	</div>


		    </div>
			


		</div>
				
	</section>



<?php

	$heading = get_more_heading($posttype);

	include_once 'partials/_content-more-articles.php';

	include_once 'partials/_content-cta-static-panel.php';



endwhile;

get_footer();








?>

