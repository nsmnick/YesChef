<?php 
while ( have_rows('team_col_panel') ) : the_row();
?>

	<section class="panel content content__team-cols-panel">

		<div class="container">

			<h2><?php echo get_sub_field('heading');?></h2>



			<?php

			renderTeam('senior_team');
			
			?>

			<hr/>


			<?php

			renderTeam('team');
			
			?>


		</div>
				
	</section>




	<script>


		jQuery(window).ready(function($) {
			
			var team_members = $('.team-cols-container__col__image');

		    if (team_members.length > 0) {
		    

		    	team_members.mouseover(
		    		function(){
			  			//$(this).next().slideDown();
			  			$(this).css( "z-index", "50" );
			  			$(this).siblings('.job-title').addClass('rollover');
			  			$(this).siblings('.team-cols-container__col__name').addClass('rollover');
			  			$(this).next().fadeIn();
			  		
			  		});

			  	team_members.mouseout(
			  		function(){
			  			$(this).css( "z-index", "10" );
			  			$(this).next().hide();
			  			$(this).siblings('.job-title').removeClass('rollover');
			  			$(this).siblings('.team-cols-container__col__name').removeClass('rollover');
				});
		     
		  	
		  	}

		});

	</script>



<?php 
endwhile
?>


<?php 

function renderTeam($team)
{
	
	if(have_rows($team))
	{
	
		echo '<div class="team-cols-container">';

			while ( have_rows($team) ) : the_row(); 

				echo '<div class="team-cols-container__col">';

					echo '<div class="team-cols-container__col__image">';
						echo '<img class="image" src="' . get_sub_field('photo') . '">';
					echo '</div>';

					echo '<div class="team-cols-container__col__rollover">';

					echo '<h3>' . get_sub_field('name') . '</h3>';
						echo '<p class="job-title">' . get_sub_field('job_title') . '</p>';
						echo get_sub_field('content');
					echo '</div>';


					echo '<div class="team-cols-container__col__name">';
						echo '<h3>' . get_sub_field('name') . '</h3>';
					echo '</div>';

					echo '<div class="job-title">';
						echo get_sub_field('job_title');
					echo '</div>';

				echo '</div>';
				
			endwhile;
			
		echo '</div>';
	
	}

}

?>

