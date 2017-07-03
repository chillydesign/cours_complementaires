<?php get_header(); ?>

<div class="container">



	<main role="main">
		<!-- section -->
		<section class="row">
			<!-- article -->
			<article   class="col-sm-9">	
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

						<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

					<?php $school =   get_field('school') ; ?>
					<?php $times =   get_field('times') ; ?>

					<strong>School:</strong> <?php echo $school->post_title; ?>
					<br/>
					<br/>


					<?php foreach($times as $time) : ?>

								<?php  $url = get_permalink($time['teacher']->ID  ); ?>


						<strong>Teacher:</strong> <a href="<?php echo $url; ?>" ><?php echo $time['teacher']->post_title; ?></a><br/>
						<strong>Time:</strong> <?php print_r($time['time']) ?>




						<br/>
						<br/>

					<?php endforeach; ?>


				<?php endwhile; ?>
			<?php endif; ?>

		</article>
		<!-- /article -->

	</section>
	<!-- /section -->
</main>
</div>


<?php get_footer(); ?>
