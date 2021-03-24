<?php /*Template Name: All Courses Template */ get_header(); ?>

<div class="container" id="courses_container"></div>

<script type="text/javascript">
	var search_url = '<?php echo get_template_directory_uri(); ?>/api/v1/?courses_detailed';
	var sort_by_cat_first = true;
</script>

<script id="courses_template" type="x-underscore">
	<?php echo file_get_contents(dirname(__FILE__) . '/templates/all_courses.underscore'); ?>
</script>


<?php get_footer(); ?>