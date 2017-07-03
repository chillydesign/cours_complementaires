<?php get_header(); ?>



<?php include('section-loop.php'); ?>


<div class="container">

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<?php if (false): ?> <h1><?php the_title(); ?></h1> <?php endif; ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>


</div>

<?php get_footer(); ?>