
if (false):
?>
<div class="container">

<h1><?php echo  $course->post_title;  ?></h1>

<?php if(  $school[0]->post_title == 'CPMDT' ) : ?>
<p><a href="inscription?course_id=<?php echo $course->ID; ?>" class="inscription_button">Inscription</a></p>
<?php endif; ?>


<div class="row">
	<div class="col-sm-6">
		

	<p><strong>Category:</strong> <?php  echo $cat;  ?></p>

	<p><strong>School:</strong> <?php echo $school[0]->post_title;  ?></p>
	<div class="school_image school_image_<?php echo $school[0]->post_name;  ?>"></div>


	<?php if (is_array($times)): ?>

	<ul class="times">
		<?php foreach($times as $time) : ?>
			<li class="time">
			<?php $teachers = $time['teachers']; ?>
			<?php if (is_array($teachers)) : ?>
				<?php $teacher_names =  array_values(array_map('api_get_post_title_from_object', $teachers)); ?>
				<strong>Teacher(s):</strong> <?php  echo  implode(', ', $teacher_names);  ?> 
				<br/>
			<?php else: ?>
			
			<?php endif; ?>
			
					<strong>Time:</strong> <?php echo $time['time']; ?>
					<br/>
					<strong>Lieu:</strong> <?php echo $time['location']->post_title; ?>
				</li>

		<?php endforeach; ?>

	</ul>

	<?php endif; ?>




	</div>
	<div class="col-sm-6">
		<?php echo $extra; ?>
	</div>

</div>

<?php echo $description; ?>

</div>


<?php endif; ?>
