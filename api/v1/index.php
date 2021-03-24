<?php

ini_set('default_charset', 'UTF-8');
header('Content-Type: application/json;charset=UTF-8');


require_once('../../../../wp-config.php');


include('connect.php');
include('functions.php');

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


if ( isset($_GET['requests'])  ) {
	include('requests_index.php');

} else if ( isset($_GET['course_id']) ) {
	include('courses_show.php');


} else if ( isset($_GET['codes']) ) {
	include('codes_index.php');

} else if (isset($_GET['courses_export'])) {

    include('courses_download.php');
    
} else if (isset($_GET['courses_detailed'])) {
    include('courses_detailed.php');
} else {

	include('courses_index.php');
}
