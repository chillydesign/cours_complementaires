<?php


$posts_array = get_posts(
    array(
        'post_type'  => 'cours',
        'posts_per_page' => -1,
        'post_status' => 'publish' ,
        'orderby' => 'post_title',
        'order'=> 'ASC'
     )
 );

$courses = array();

 foreach ($posts_array as $post) {

     $str  = '';
     $course = api_get_detailed_course($post->ID);
     if ($course) {

         array_push($courses, $course);

     }
 } // end of foreach $posts_array


    echo json_encode( $courses,  JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK );


?>
