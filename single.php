<?php get_header(); ?>

<div class="container">



	<main role="main">
		<!-- section -->
		<section class="row">
			<!-- article -->
			<article   class="col-sm-9">	
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>



						<!-- post title -->
						<h1>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h1>
						<!-- /post title -->
						<p class="meta">Posted: <?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></p>

						<?php the_content(); // Dynamic Content ?>

						<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
							<div class=" post_image">
								<?php the_post_thumbnail(); // Fullsize image for the single post ?>
							
							</div>
						<?php endif; ?>

						<?php edit_post_link(); // Always handy to have Edit Post Links available ?>



				<?php endwhile; ?>

			<?php else: ?>


				<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>



			<?php endif; ?>

		</article>
		<!-- /article -->

		<aside class="col-sm-3"  role="complementary">
			<?php  get_sidebar(); ?>

		</aside>

	</section>
	<!-- /section -->
</main>
</div>


<?php get_footer(); ?>
