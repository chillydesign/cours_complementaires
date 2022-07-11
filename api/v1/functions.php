<?php


if (!function_exists('api_course_price_list')) {
	function api_course_price_list() {

		return array(
			'none'    =>  'Pas d\'écolage',
			'option1' =>  '330.-',
			'option2' =>  '620.-',
			'option3' =>  '930.-',
			'option4' =>  '500.-',
			'option5' =>  '1350.-',
		);
	}
}



if (!function_exists('api_all_request_fields')) {
	function api_all_request_fields() {

		return array('teacher_id', 'title_student', 'nom_student', 'prenom_student', 'school_name', 'ondine_genevoise',   'instrument', 'date_naissance_student', 'email_student', 'phone1_student', 'address_student_1', 'locality_student', 'title_respondent', 'nom_respondent', 'prenom_respondent', 'date_naissance_respondent', 'email_respondent', 'phone1_respondent', 'address_respondent_1', 'locality_respondent', 'lieu_imposition', 'facture', 'course_id', 'authorize');
	}
}

if (!function_exists('api_all_request_fields_headers')) {
	function api_all_request_fields_headers() {

		return array('Professeur lieu et horaires', 'Titre élève', 'Nom élève', 'Prénom élève', 'École de l\'élève',  'Elève à l\'Ondine genevoise',   'Instrument', 'Date de naissance élève', 'Email élève', 'Téléphone élève', 'Adresse élève', 'Ville élève', 'Titre répondant', 'Nom répondant', 'Prénom répondant', 'Date de naissance répondant', 'Email répondant', 'Téléphone répondant', 'Adresse répondant', 'Ville répondant', 'Lieu imposition', 'Facture', 'Nom du cours', 'Photos');
	}
}




if (!function_exists('chilly_school_letters')) {
	function chilly_school_letters() {

		return array(4 => 'A', 7 => 'B', 38 => 'C');
	}
}



if (!function_exists('chilly_category_letters')) {
	function chilly_category_letters() {

		return array(3 => 'R', 4 => 'S', 5 => 'T', 6 => 'U', 7 => 'V', 8 => 'W', 9 => 'X', 10 => 'Y', 11 => 'Z');
	}
}


// setlocale(LC_CTYPE, 'en_AU.utf8');

if (!function_exists('api_normal_chars')) {
	function api_normal_chars($string) {

		$str = remove_accents($string);
		//	$str =  iconv('UTF-8','ASCII//TRANSLIT',$string);
		return $str;
	}
}

if (!function_exists('api_get_request_courses')) {
	function api_get_request_courses($request_ids) {
		global $conn;
		if (sizeof($request_ids) > 0) :
			// GET CATEGORIES
			$c_sql = ' post_id = ';
			$c_sql .= implode(' OR post_id =   ', $request_ids);
			$c_query = $conn->prepare("SELECT  meta_value, post_id, post_title
									FROM  `wp_postmeta`
								 LEFT JOIN wp_posts ON wp_posts.ID = wp_postmeta.meta_value
									WHERE ( $c_sql ) AND meta_key = '_course_id' ");
			$c_query->execute();
			# setting the fetch mode
			$c_query->setFetchMode(PDO::FETCH_OBJ);
			$request_courses =  $c_query->fetchAll();
			unset($conn);
			return $request_courses;
		endif;
	}
}


if (!function_exists('api_get_request_times')) {
	function api_get_request_times($request_ids) {
		global $conn;
		if (sizeof($request_ids) > 0) :
			// GET CATEGORIES
			$c_sql = ' post_id = ';
			$c_sql .= implode(' OR post_id =   ', $request_ids);
			$c_query = $conn->prepare("SELECT  meta_value, post_id
									FROM  `wp_postmeta`
									WHERE ( $c_sql ) AND meta_key = '_teacher_id' ");
			$c_query->execute();
			# setting the fetch mode
			$c_query->setFetchMode(PDO::FETCH_OBJ);
			$request_times =  $c_query->fetchAll();
			unset($conn);
			return $request_times;
		endif;
	}
}

if (!function_exists('api_get_request_emails')) {
	function api_get_request_emails($request_ids) {
		global $conn;
		if (sizeof($request_ids) > 0) :

			$c_sql = ' post_id = ';
			$c_sql .= implode(' OR post_id =   ', $request_ids);
			$c_query = $conn->prepare("SELECT  meta_value, post_id
									FROM  `wp_postmeta`
									WHERE ( $c_sql ) AND meta_key = '_email_address' ");
			$c_query->execute();
			# setting the fetch mode
			$c_query->setFetchMode(PDO::FETCH_OBJ);
			$request_emails =  $c_query->fetchAll();
			unset($conn);
			return $request_emails;
		endif;
	}
}

if (!function_exists('api_get_request_metafield')) {
	function api_get_request_metafield($request_ids, $field) {
		global $conn;
		if (sizeof($request_ids) > 0) :

			$c_sql = ' post_id = ';
			$c_sql .= implode(' OR post_id =   ', $request_ids);
			$c_query = $conn->prepare("SELECT  meta_value, post_id
									FROM  `wp_postmeta`
									WHERE ( $c_sql ) AND meta_key = '$field' ");
			$c_query->execute();
			# setting the fetch mode
			$c_query->setFetchMode(PDO::FETCH_OBJ);
			$request_metas =  $c_query->fetchAll();
			unset($conn);
			return $request_metas;
		endif;
	}
}







if (!function_exists('api_get_course_cats')) {
	function api_get_course_cats($course_ids) {
		global $conn;

		if (sizeof($course_ids) > 0) :
			// GET CATEGORIES
			$course_cat_sql = ' object_id = ';
			$course_cat_sql .= implode(' OR object_id =   ', $course_ids);
			$course_query = $conn->prepare("SELECT object_id, wp_terms.term_id, name, slug , parent
									FROM  `wp_term_relationships`
									LEFT JOIN wp_terms ON wp_term_relationships.term_taxonomy_id = wp_terms.term_id
									LEFT JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_id
									WHERE ( $course_cat_sql ) AND taxonomy = 'categorie-cours' ");
			$course_query->execute();
			# setting the fetch mode
			$course_query->setFetchMode(PDO::FETCH_OBJ);
			$course_categories =  $course_query->fetchAll();
			unset($conn);
			return $course_categories;
		endif;
	}
}





if (!function_exists('api_get_course_descriptions')) {
	function api_get_course_descriptions($course_ids) {
		global $conn;
		if (sizeof($course_ids) > 0) :
			// GET CATEGORIES
			$description_sql = ' post_id = ';
			$description_sql .= implode(' OR post_id =   ', $course_ids);
			$description_query = $conn->prepare("SELECT  meta_value, post_id
									FROM  `wp_postmeta`
									WHERE ( $description_sql ) AND meta_key = 'description' ");
			$description_query->execute();
			# setting the fetch mode
			$description_query->setFetchMode(PDO::FETCH_OBJ);
			$course_descriptions =  $description_query->fetchAll();
			unset($conn);
			return $course_descriptions;
		endif;
	}
}

if (!function_exists('api_remove_line_breaks')) {
	function api_remove_line_breaks($string) {

		$new_string = str_replace(array("\r", "\n"), '', $string);
		$new_string = str_replace(';', ' ', $new_string);
		$new_string = strip_tags($new_string);
		return $new_string;
	}
}


// if(!function_exists('api_get_course_ecolages')) {
// function api_get_course_ecolages($course_ids){
// 	global $conn;
// 	if (sizeof($course_ids) > 0):
// 		// GET CATEGORIES
// 		$ecolage_sql = ' post_id = ';
// 		$ecolage_sql .= implode(' OR post_id =   ', $course_ids);
// 		$ecolage_query = $conn->prepare("SELECT  meta_value, post_id
// 									FROM  `wp_postmeta`
// 									WHERE ( $ecolage_sql ) AND meta_key = 'ecolage' ");
// 		$ecolage_query->execute();
// 		# setting the fetch mode
// 		$ecolage_query->setFetchMode(PDO::FETCH_OBJ);
// 		$course_ecolages =  $ecolage_query->fetchAll();
// 		unset($conn);
// 		return $course_ecolages;
// 	endif;
//
// }
// }


if (!function_exists('api_get_course_ecolages')) {
	function api_get_course_ecolages($course_ids) {
		global $conn;

		if (sizeof($course_ids) > 0) :
			// GET ECOLAGE TAXONOMY
			$course_eco_sql = ' object_id = ';
			$course_eco_sql .= implode(' OR object_id =   ', $course_ids);
			$course_query = $conn->prepare("SELECT object_id, wp_terms.term_id, name, slug , parent
									FROM  `wp_term_relationships`
									LEFT JOIN wp_terms ON wp_term_relationships.term_taxonomy_id = wp_terms.term_id
									LEFT JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_id
									WHERE ( $course_eco_sql ) AND taxonomy = 'ecolage-cours' ");
			$course_query->execute();
			# setting the fetch mode
			$course_query->setFetchMode(PDO::FETCH_OBJ);
			$course_ecolages =  $course_query->fetchAll();
			unset($conn);
			return $course_ecolages;
		endif;
	}
}










if (!function_exists('api_get_course_extras')) {
	function api_get_course_extras($course_ids) {
		global $conn;
		if (sizeof($course_ids) > 0) :
			// GET CATEGORIES
			$extra_sql = ' post_id = ';
			$extra_sql .= implode(' OR post_id =   ', $course_ids);
			$extra_query = $conn->prepare("SELECT meta_value, post_id
									FROM  `wp_postmeta`
									WHERE ( $extra_sql ) AND meta_key = 'extra' ");


			$extra_query->execute();
			# setting the fetch mode
			$extra_query->setFetchMode(PDO::FETCH_OBJ);
			$course_extras =  $extra_query->fetchAll();
			unset($conn);

			return $course_extras;
		endif;
	}
}



if (!function_exists('api_get_course_schools')) {
	function api_get_course_schools($course_ids) {
		global $conn;
		if (sizeof($course_ids) > 0) :
			// GET CATEGORIES
			$school_sql = ' post_id = ';
			$school_sql .= implode(' OR post_id =   ', $course_ids);
			$school_query = $conn->prepare("SELECT post_id, wp_postmeta.post_id as wppid  , post_title, meta_value
									FROM  `wp_postmeta`
									LEFT JOIN wp_posts ON wp_postmeta.meta_value = wp_posts.ID
									WHERE ( $school_sql ) AND meta_key = 'school' ");


			$school_query->execute();
			# setting the fetch mode
			$school_query->setFetchMode(PDO::FETCH_OBJ);
			$course_schools =  $school_query->fetchAll();
			unset($conn);

			return $course_schools;
		endif;
	}
}







if (!function_exists('api_get_course_professeurs')) {
	function api_get_course_professeurs($course_ids) {
		global $conn;
		if (sizeof($course_ids) > 0) :
			// GET professeurs
			$professeur_sql = ' post_id = ';
			$professeur_sql .= implode(' OR post_id =   ', $course_ids);
			$professeur_query = $conn->prepare("SELECT  * FROM  `wp_postmeta`
							WHERE ( $professeur_sql ) AND  `meta_key` LIKE '%teachers%'   ");


			$professeur_query->execute();
			# setting the fetch mode
			$professeur_query->setFetchMode(PDO::FETCH_OBJ);
			$course_professeurs =  $professeur_query->fetchAll();
			unset($conn);

			return $course_professeurs;
		endif;
	}
}



if (!function_exists('api_get_course_locations')) {
	function api_get_course_locations($course_ids) {
		global $conn;
		if (sizeof($course_ids) > 0) :
			// GET CATEGORIES
			$location_sql = ' post_id = ';
			$location_sql .= implode(' OR post_id =   ', $course_ids);
			$location_query = $conn->prepare("SELECT wp_postmeta.post_id as wppid  , post_title, wp_posts.ID as wid
							FROM  `wp_postmeta`
							LEFT JOIN wp_posts ON wp_postmeta.meta_value = wp_posts.ID
							WHERE ( $location_sql ) AND  `meta_key` LIKE '%location%' AND  post_title != '' ");

			$location_query->execute();
			# setting the fetch mode
			$location_query->setFetchMode(PDO::FETCH_OBJ);
			$course_locations =  $location_query->fetchAll();
			unset($conn);

			return $course_locations;
		endif;
	}
}


if (!function_exists('api_get_course_zones')) {
	function api_get_course_zones($location_ids) {
		global $conn;
		$location_ids =   array_unique(array_filter($location_ids));
		if (sizeof($location_ids) > 0) :
			// GET CATEGORIES
			$zone_sql = ' post_id = ';
			$zone_sql .= implode(' OR post_id =   ', $location_ids);
			$zone_query = $conn->prepare("SELECT  wp_postmeta.post_id as wppid  , post_title, wp_posts.ID as wid
							FROM  `wp_postmeta`
							LEFT JOIN wp_posts ON wp_postmeta.meta_value = wp_posts.ID
							WHERE ( $zone_sql ) AND  `meta_key` LIKE '%zone%' AND  post_title != '' ");

			$zone_query->execute();
			# setting the fetch mode
			$zone_query->setFetchMode(PDO::FETCH_OBJ);
			$location_zones =  $zone_query->fetchAll();
			unset($conn);

			return $location_zones;
		endif;
	}
}



if (!function_exists('api_remove_unnecessary_things')) {
	function api_remove_unnecessary_things($object) {

		unset($object->to_ping);
		unset($object->pinged);
		unset($object->menu_order);
		unset($object->ping_status);
		unset($object->comment_status);
		unset($object->comment_count);
		unset($object->post_mime_type);
		unset($object->post_date_gmt);
		unset($object->post_password);
		unset($object->post_modified_gmt);
		unset($object->filter);
		unset($object->post_content_filtered);
		unset($object->post_author);

		return $object;
	}
}



function api_categories_to_cat_names($categories) {
	if (sizeof($categories) > 0) {
		return implode(
			', ',
			array_map(function ($c) {
				return $c->name;
			}, $categories)
		);
	}
	return  false;
}



if (!function_exists('api_get_detailed_course')) {
	function api_get_detailed_course($course_id) {


		$course = get_post($course_id);

		$times = get_field('times', $course_id);


		if ($times) :

			$school = get_field('school', $course_id);
			$extra = get_field('extra', $course_id);
			$alternate_url = get_field('alternate_url', $course_id);
			$description = get_field('description', $course_id);
			$cat = get_the_terms($course_id, 'categorie-cours');

			if ($cat && sizeof($cat) > 0) {
				$cat_name = $cat[0]->name;
				$course->categories = array($cat[0]->term_id);
				$course->cat = $cat_name;
				$course->cat_names = api_categories_to_cat_names($cat);
			} else {
				$cat_name = '';
				$course->categories = array();
				$course->cat = $cat_name;
				$course->cat_names = false;
			}


			$school_letter = chilly_school_letters();
			$category_letters = chilly_category_letters();


			$location_ids =  array_map(function ($t) {
				return $t["location"]->ID;
			}, $times);
			$course_zones = api_get_course_zones($location_ids);

			$zones =  array_values(array_map(function ($l) {
				return $l->wid;
			}, $course_zones));
			$course->zone = $zones;


			// $course_price_list = api_course_price_list();
			// $ecolage_field = get_field('ecolage', $course_id);
			// if ( isset($ecolage_field) && $ecolage_field != '' ){
			// 	$ecolage = $course_price_list[$ecolage_field];
			// } else {
			// 	$ecolage = null;
			// }


			$ecolage = get_the_terms($course_id, 'ecolage-cours');
			$ecolage_name = ($ecolage &&  sizeof($ecolage) > 0) ? $ecolage[0]->name : null;


			if ($alternate_url) :
				$course->inscription = '<p><a target="_blank" href="' . $alternate_url  . '" class="inscription_button">Inscription</a></p>';
			elseif ($school[0]->post_title == 'CPMDT') :
				$course->inscription = '<p><a href="inscription?course_id=' . $course->ID . '" class="inscription_button">Inscription</a></p>';
			elseif ($school[0]->post_title == 'IJD') :
				$course->inscription = '<p><a target="_blank" href="http://www.dalcroze.ch/inscription/" class="inscription_button">Inscription sur le site de l’IJD</a></p>';
			elseif ($school[0]->post_title == 'CMG') :
				$course->inscription = '<p><a target="_blank" href="http://www.cmusge.ch/sites/default/files/cmusge/public/formulaire_inscription_musique_2017_2018.pdf" class="inscription_button">Inscription sur le site du CMG</a></p>';
			endif;

			if ($cat && $school) {
				$course->code = $school_letter[$school[0]->ID] . $category_letters[$cat[0]->term_id]  .   $course_id;
			} else {
				$course->code = '';
			}

			if ($school) {
				$course->school = array($school[0]->ID);
			} else {
				$course->school = array();
			}

			$professeurs = array();


			$course->schools =  array_map('api_remove_unnecessary_things', $school);


			$course->times = $times;
			$course->description = $description;
			$course->extra = $extra;
			$course->ecolage = $ecolage_name;



			if (is_array($course_zones)) {
				foreach ($course->times as $time) {
					$loc = $time['location'];
					// get the zone
					$zone = array_filter(
						$course_zones,
						function ($e)  use ($loc) {
							return $e->wppid == $loc->ID;
						}
					);

					if ($zone) {
						$loc->zone = $zone;
						$zone = array_values($zone);
					} else {
						$zone = false;
					}


					$teachs = $time['teachers'];
					if ($teachs) {
						foreach ($teachs as $teacher) {
							array_push($professeurs,  $teacher->ID);
						}
					}
				}
			} // end if is_array $course_zones

			$course->professuers = $professeurs;


			$searchable_fields = array($course->post_title, $course->description, $course->extra, $course->code);
			$searchable_fields = implode('  ', $searchable_fields);
			$searchable_fields = wp_strip_all_tags($searchable_fields);


			$searchable_fields = str_replace(array("\n", "\r"), ' ', $searchable_fields);
			$searchable_fields = str_replace(array("!", "’", ',', '/', ':', "?", '.', '–'), ' ', $searchable_fields);
			//$searchable_fields = preg_replace( '/[^A-Za-z0-9_-]/', '', $searchable_fields );
			$searchable_fields = remove_accents($searchable_fields);
			$searchable_fields = strtolower($searchable_fields);
			$course->searchfield = $searchable_fields;


			$course->url = get_permalink($course_id);



			$course = api_remove_unnecessary_things($course);

			return $course;


		else : # else if no times
			return false;
		endif; # end if no times


	}
}



if (!function_exists('api_get_post_title_from_object')) {
	function api_get_post_title_from_object($obj) {
		return $obj->post_title;
	}
}

if (!function_exists('api_get_location_id_from_object')) {
	function api_get_location_id_from_object($obj) {
		return $obj["location"]->ID;
	}
}
if (!function_exists('api_get_id_from_object')) {
	function api_get_id_from_object($obj) {
		return $obj->ID;
	}
}
if (!function_exists('api_get_wid_from_object')) {
	function api_get_wid_from_object($obj) {
		return $obj->wid;
	}
}
if (!function_exists('api_get_meta_value_from_object')) {
	function api_get_meta_value_from_object($obj) {
		return $obj->meta_value;
	}
}
