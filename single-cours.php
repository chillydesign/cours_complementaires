<?php get_header(); ?>

<div class="container">
<?php
	$school = get_field('school');
	$description = get_field('description');
	$course_id = get_the_ID();
	$cat = get_the_terms( $course_id, 'categorie-cours' );
	$cat_name = $cat[0]->name;

	$school_letter = chilly_school_letters();
	$category_letters = chilly_category_letters();
	$course_code = $school_letter[$school[0]->ID ] . $category_letters[ $cat[0]->term_id  ]  .   $course_id;

	$ecolage = get_the_terms( $course_id, 'ecolage-cours' );
	$ecolage_name = (  sizeof($ecolage) > 0 ) ? $ecolage[0]->name : null;

	$extra = get_field('extra');
?>
	<!-- <h1><?php the_title(); ?></h1> -->
	<?php if($school){echo '<h3>' . $school[0]->post_excerpt . '</h3>';} ?>

	<div class="row">


		<div class="col-sm-6 ">



			<?php echo $description; ?>

			<?php if( $school[0]->post_title == 'CPMDT' ) :
					echo '<p><a href="' . get_home_url() . '/inscription?course_id=' . $course_id . '" class="inscription_button">Inscription</a></p>';
				elseif( $school[0]->post_title == 'IJD' ) :
					echo '<p><a target="_blank" href="http://www.dalcroze.ch/inscription/" class="inscription_button">Inscription sur le site de l’IJD</a></p>';
				elseif( $school[0]->post_title == 'CMG' ) :
					echo '<p><a  target="_blank"href="http://www.cmusge.ch/sites/default/files/cmusge/public/formulaire_inscription_musique_2017_2018.pdf" class="inscription_button">Inscription sur le site du CMG</a></p>';
				endif;
			?>

		</div>

		<div class="col-sm-4 col-sm-push-1">
			

			<p><strong>Catégorie:</strong> <?php echo $cat_name ?></p>
			<p><strong>Code:</strong> <?php echo $course_code ?></p>


			<?php echo $extra; ?>


			<?php if ($ecolage_name) {  ?>
			<p><strong>Ecolage:</strong> <?php echo $ecolage_name; ?></p>
				<?php } ?>

			<div class="school_image school_image_ <%= cours.school[0].post_name %>"></div>


		</div>


	</div>




	<table class="table">
		<thead>
			<tr>
				<th>Professeur(s)</th>
				<th>Horaire</th>
				<th>Lieu</th>
			</tr>
		</thead>
		<tbody>

		<?php
		if( have_rows('times') ):

		 	// loop through the rows of data
		    while ( have_rows('times') ) : the_row(); ?>

			<tr>
				<td>
			        <?php $teachers = get_sub_field('teachers'); ?>
			        <?php if($teachers): ?>
			        	<?php $count =1; ?>
			        	<?php foreach ($teachers as $teacher) {
			        		if($count > 1) {echo ', '; }
			        		echo $teacher->post_title;
			        		$count++;
			        	} ?>
			        <?php endif; ?>
		        </td>

			<td>
				<?php echo get_sub_field('time'); ?>
			</td>

			<td>
		        <?php  $lieu = get_sub_field('location'); ?>
		        <?php if($lieu): ?> 
		        	<?php $lieu_title = $lieu->post_title; ?>
			        <?php if($lieu_title != ''){
			        	 $lieu_id = $lieu->ID; 
			        	 $zone = get_field('zone', $lieu_id);
			        	 $zone_title = $zone->post_title;

			        	 if($zone_title){echo $zone_title . ' - ';}
			        	 echo $lieu_title; 
			     	} ?>
		        <?php endif; ?>

			</td>
				

		    <?php endwhile;
		endif; ?>
	</tbody>
</table>



</div>
<br><br>

<?php get_footer(); ?>
