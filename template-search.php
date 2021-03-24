<?php /*Template Name: Search Template */ get_header(); ?>



<p class="container" id="course_size"></p>
<div class="container" id="courses_container"></div>
<div id="cours_container"></div>

<script type="text/javascript">
	var search_url = '<?php echo get_template_directory_uri(); ?>/api/v1/';
</script>
<script id="courses_template" type="x-underscore">
	<?php echo file_get_contents(dirname(__FILE__) . '/templates/courses.underscore'); ?>
</script>
<script id="cours_template" type="x-underscore">
	<?php echo file_get_contents(dirname(__FILE__) . '/templates/cours.underscore'); ?>
</script>
<?php get_footer(); ?>