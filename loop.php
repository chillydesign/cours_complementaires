<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article class="search_results" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<p class="meta">Posted: <?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></p>
		<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>


	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>
	</article>
	<!-- /article -->

<?php endif; ?>
