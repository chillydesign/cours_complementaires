
    <form  class="hide_on_print" method="" action="">
	<input placeholder="chercher un cours"  type="text" name="k" id="cours_search">

	<a href="#" data-box="#category_box"  class="search_button" id="category_button">Catégorie</a>
	<a href="#" data-box="#location_box" class="search_button"  id="location_button">Lieu</a>
	<a href="#" data-box="#school_box"  class="search_button" id="school_button">École</a>
	<a href="#" data-box="#professeur_box"  class="search_button" id="professeur_button">Professeurs</a>

	<a href="#" id="reset_course_form">réinitialiser</a>

	<div id="category_box" class="search_box">
	<?php $terms = get_terms( 'categorie-cours'); ?>
<?php foreach ($terms as $term)  : ?>
			<label><input type="checkbox" class="search_check" value="<?php echo $term->term_id; ?>" data-field="category" /> <?php echo $term->name; ?>   </label>
<?php endforeach; ?>

<!-- 	<select  multiple="multiple"  name="categorie" id="categorie_select">
		<option value="">Toutes les catégories</option>
	</select> -->
	<!-- <a href="#" class="close_box">X</a> -->
	</div>

<div id="location_box" class="search_box">


<?php $zones = get_posts(array('post_type'  => 'zone',  'orderby'=> 'post_title' , 'order' =>'ASC' , 'posts_per_page' => -1  ) );  ?>
		<?php foreach ($zones as $zone)  : ?>
		<label><input type="checkbox" class="search_check" value="<?php echo $zone->ID; ?>" data-field="location" /> <?php echo $zone->post_title; ?>   </label>
	<?php endforeach; ?>
<!-- 	<select  multiple="multiple"  name="location" id="location_select">
			<option value="">Tous les lieux</option>
	</select> -->
<!-- 	<a href="#" class="close_box">X</a> -->
</div>

<div id="school_box" class="search_box">
	<?php $schools = get_posts(array('post_type'  => 'ecole', 'posts_per_page' => -1  ) );  ?>
	<?php foreach ($schools as $school)  : ?>
		<label><input type="checkbox" class="search_check" value="<?php echo $school->ID; ?>" data-field="school" /> <?php echo $school->post_title; ?>   </label>
	<?php endforeach; ?>

<!-- 	<select  multiple="multiple" name="location" id="school_select"  >
		<option value="">Toutes les écoles</option>
	</select> -->

<!-- 	<a href="#" class="close_box">X</a> -->
</div>


<div id="professeur_box" class="search_box">
    <?php $professeurs = get_posts(array('post_type'  => 'professeur',  'order' =>'ASC' , 'orderby'=> 'post_title' , 'posts_per_page' => -1  ) );  ?>
	<?php foreach ($professeurs as $professeur)  : ?>
		<label><input type="checkbox" class="search_check" value="<?php echo $professeur->ID; ?>" data-field="professeur" /> <?php echo $professeur->post_title; ?>   </label>
	<?php endforeach; ?>
</div>



    </form>
