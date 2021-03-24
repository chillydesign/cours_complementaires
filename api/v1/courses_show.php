<?php

$course_id =  intval( $_GET['course_id'] );


if ($course_id > 0) :

    $course = api_get_detailed_course($course_id);
    if ($course) {
        echo json_encode( $course,  JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK );
    } else {
        echo json_encode('error');
    }



else: # else if no course_id
    echo json_encode('error');
endif;



?>
