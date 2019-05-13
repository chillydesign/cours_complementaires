<?php /*Template Name: All Courses Template */ get_header(); ?>




<div class="container" id="all_courses_container"></div>


<script type="text/javascript">
	var all_courses_url = '<?php echo home_url(); ?>/api/v1/?courses_detailed';
</script>
<script id="all_courses_template" type="x-underscore">
	<?php echo file_get_contents(dirname(__FILE__) . '/templates/all_courses.underscore'); ?>
</script>

<?php get_footer(); ?>
