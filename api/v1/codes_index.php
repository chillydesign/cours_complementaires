<?php


$posts_array = get_posts(array('post_type'  => 'cours', 'posts_per_page' => -1, 'post_status' => 'publish' , 'orderby' => 'post_title', 'order'=> 'ASC' ) );
$post_ids =  array_map('api_get_id_from_object', $posts_array);

$course_categories = api_get_course_cats($post_ids);
$course_schools = api_get_course_schools($post_ids);
$school_letter = chilly_school_letters();
$category_letters = chilly_category_letters();

$courses = '';

foreach ($posts_array as $post) {

	// get the categories for the specific post
	$cats = array_filter(
		$course_categories,
		function ($e)  use ($post) {
			return $e->object_id == $post->ID;
		}
	);
	$post->categories = array_values($cats);




	// get the school
	$school = array_filter(
		$course_schools,
		function ($e)  use ($post) {
			return $e->wppid == $post->ID;
		}
	);
	$sc =  array_values($school);
	$sc = reset($sc);
	$sc = $sc->meta_value;

	$post->school = ($sc != null) ? $sc : '';
	if ( strlen($post->school) < 3   ) {
		$post->school = [$post->school];
	} else {
		$uns_sch = unserialize($post->school);
		$post->school = $uns_sch;
	}



	$code = $school_letter[$post->school[0] ] . $category_letters[ $post->categories[0]->term_id  ]  .   $post->ID;

	$title = str_replace(',', ' ',  $post->post_title);

	$courses .=  $title . ',' . $code   . "\n" ;




}





header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header( 'Content-disposition: filename=codes.csv');
print $courses;
