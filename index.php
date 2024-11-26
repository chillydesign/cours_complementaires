<?php get_header(); ?>
<div class="container">
	<div class="row">

		<section class="col-sm-9">

			<h1><?php _e('Latest Posts', 'html5blank'); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>


		<aside class="col-sm-3" role="complementary">
			<?php get_sidebar(); ?>
		</aside>

	</div>
</div>


<?php get_footer(); ?>