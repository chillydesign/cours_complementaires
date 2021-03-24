<?php


$file = 'request';

$requests_array = get_posts(array('post_type'  => 'request', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
$request_ids =  array_map('api_get_id_from_object', $requests_array);

$request_courses = api_get_request_courses($request_ids);
//$request_times = api_get_request_times($request_ids);
//$request_emails = api_get_request_emails($request_ids);


foreach (api_all_request_fields() as $field) {
	$fn = 'request_' . $field;
	$$fn = api_get_request_metafield($request_ids, '_' . $field);
}


//$data =  'nom,cours,date,' . implode(',' , api_all_request_fields_headers()     ) .   "\n";
$data =  'nom;cours;date;' . implode(';' , api_all_request_fields_headers()     ) .   "\n";

foreach ($requests_array as $request) {


	// get the course title
	$course = array_filter(
		$request_courses,
		function ($e)  use ($request) {
			return $e->post_id == $request->ID;
		}
	);
	$course =  array_values(array_map('api_get_post_title_from_object', $course));
	$course_title =  $course[0];


	// get the course time
	// $time = array_filter(
	// 	$request_times,
	// 	function ($e)  use ($request) {
	// 		return $e->post_id == $request->ID;
	// 	}
	// );
	// $time =  array_values(array_map(create_function('$p', 'return $p->meta_value;'), $time));
	// $course_time = (sizeof($time) == 1)  ?  $time[0] : '';


	// get the email
	// $email = array_filter(
	// 	$request_emails,
	// 	function ($e)  use ($request) {
	// 		return $e->post_id == $request->ID;
	// 	}
	// );
	// $email =  array_values(array_map(create_function('$p', 'return $p->meta_value;'), $email));
	// $email_address = (sizeof($email) == 1)  ?  $email[0] : '';

	$meta_strings = array();
	foreach (api_all_request_fields() as $field) {
		$fn = 'request_' . $field;
		$metafield = array_filter(
			$$fn,
			function ($e)  use ($request) {
				return $e->post_id == $request->ID;
			}
		);
		$metafield =  array_values(array_map('api_get_meta_value_from_object', $metafield));
		$metafield_string = (sizeof($metafield) == 1)  ?  $metafield[0] : '';
		//$metafield_string = str_replace(',', ' ', $metafield_string);
		$metafield_string = str_replace(';', ' ', $metafield_string);
		array_push($meta_strings , $metafield_string);
	}




	$ar = array(
		$request->post_title,
		$course_title,
		// $course_time,
		$request->post_date,

	);

	$ar =  array_merge($ar, $meta_strings);





	//$data .=  implode(',', $ar);
	$data .=  implode(';', $ar);
	$data .=  "\n";
}




$filename = $file.'_'.date('Y-m-d_H-i',time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header( 'Content-disposition: filename='.$filename.'.csv');
print $data;

//print_r ($data);

exit;
