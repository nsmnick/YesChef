<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="entry-header">
		<div class="meta">
		<?php entry_meta(); ?>
		</div>
	</div>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<div class="navigation">
		<a class="button" href="/blog"><i class="fa fa-angle-left"></i> Back to all posts</a>
	</div>

</article><!-- #post-## -->