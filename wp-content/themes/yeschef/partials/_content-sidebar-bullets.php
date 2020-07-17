<?php 

while ( have_rows('bullets_group') ) : the_row();
?>

	<div class="sidebar__bullets-group">

		<h3><?php echo get_sub_field('sb_title');?></h3>


		<ul class="styled-list styled-list--yellow">

		<?php
		while ( have_rows('sb_bullets') ) : the_row(); 
		?>

			<li>
				<?php echo get_sub_field('sb_bullet');?>
			</li>

		<?php
		endwhile;
		?>

		</ul>

	</div>
		

<?php 
endwhile
?>