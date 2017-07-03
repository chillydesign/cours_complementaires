<?php get_header(); ?>

<div class="container">

	<main role="main">
		<!-- section -->
		<section class="row">

			<!-- article -->
			<div   class="col-sm-9">	

			<h1><?php echo sprintf( __( '%s results for ', 'llyn' ), $wp_query->found_posts ); ?>"<?php echo get_search_query(); ?>"</h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

			</div>


		<aside class="col-sm-3"  role="complementary">
			<?php  get_sidebar(); ?>

		</aside>

		</section>
		<!-- /section -->
	</main>




</div>
<?php get_footer(); ?>
