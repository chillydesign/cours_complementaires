<?php get_header(); ?>

<div class="container">



	<main role="main">
		<!-- section -->
		<section class="row">
			<!-- article -->
			<article   class="col-sm-9">	
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>



					<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>



				<?php
					// FUNCTIONS ARE IN FUNCTIONS.PHP
					$teacher_time_meta = get_teacher_time_meta();
					$course_ids = get_teacher_course_ids( $teacher_time_meta );
					$times = get_teacher_course_times( $teacher_time_meta );
					
				?>

				<?php foreach($course_ids as $course_id) : ?>

					<?php $course = get_post( $course_id); ?>
					<?php $url = get_permalink( $course_id); ?>

					<strong>Course:</strong> <a href="<?php echo $url; ?>" ><?php echo $course->post_title; ?></a><br/>
					<?php foreach ($times as $time) : ?>
						<?php if(  $time->post_id == $course_id  ): ?>
							<?php echo ($time->meta_value); ?><br/>
					<?php endif; ?>
					<?php endforeach; ?>
					<br/><br/>


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
