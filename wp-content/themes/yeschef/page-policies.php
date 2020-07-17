<?php
/**
* Template Name: Policy Page
*/

get_header();

while ( have_posts() ) : the_post(); 

?>

	<?php 
	include_once 'partials/_content-internal-hero.php';
	?>

	<section class="panel content content__policy-detail">

		<div class="container">

			<div class="content-container">
				<?php the_content(); ?>
			</div>

		</div>


		

	</section>

	




<?php
endwhile;
?>

<div class="container">
	<hr class="yellow height-3"/>
</div>

<?php
get_footer();
?>

