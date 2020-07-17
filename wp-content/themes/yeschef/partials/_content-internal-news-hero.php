

<section class="internal-news-hero">
	<div class="container">

		<div class="internal-news-hero__container">

			<div class="internal-news-hero__container__col1">
				
				<?php 

				$imageURL = get_the_post_thumbnail_url(get_the_ID());
				$clientLogo = get_field('client_logo');

				if($category)
				{
					echo '<div class="category">' . $category . '</div>';
				}

				?>

				
				<h1 class="animate"><?php echo get_the_title() ?></h1>

				<?php 
				if($clientLogo)
				{
					echo '<div class="client-logo">';
						echo '<img src="'.$clientLogo.'">';
					echo '</div>'; 
				}
				?>

			</div>

			


				
			<div class="internal-news-hero__container__col2">
				<img class="animate-fade" src="<?php echo $imageURL;?>">
			</div>

		</div>
		
	</div>
</section>