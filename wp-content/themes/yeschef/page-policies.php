<?php
/**
* Template Name: Policy Page
*/

get_header();

while ( have_posts() ) : the_post(); 

?>

	<section class="panel content content__panel no-bottom">
		<div class="container container--narrow-1000">
			<h2 class="animate-fade"><?php echo $post->post_title;?></h2>

		</div>
	</section>


	<section class="panel content content__panel">
		<div class="container">
			
			<?php echo the_content(); ?>		
						
		</div>

	</section>

	




<?php
endwhile;
?>


<?php
get_footer();
?>

