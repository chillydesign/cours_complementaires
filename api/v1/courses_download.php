<?php
$data = 'Code;Titre;Ecole;Catégorie;Professeurs;Horaire;Lieux;Ecolage;Description;Informations supplémentaires' .   "\n";
// $data = 'Code,Titre,Ecole,Catégorie,Professeurs,Horaire,Lieux,Ecolage,Description,Informations supplémentaires' .   "\n";



$posts_array = get_posts(array('post_type'  => 'cours', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'ASC'));


foreach ($posts_array as $course) :


    $course_id = $course->ID;


    $times = get_field('times', $course_id);



    $school = get_field('school', $course_id);
    $extra = get_field('extra', $course_id);
    $description = get_field('description', $course_id);
    $cat = get_the_terms($course_id, 'categorie-cours');
    $cat_name = $cat[0]->name;

    $school_letter = chilly_school_letters();
    $category_letters = chilly_category_letters();




    $location_ids =  array_map('api_get_location_id_from_object', $times);
    $course_zones = api_get_course_zones($location_ids);

    // $course_price_list = api_course_price_list();
    // $ecolage_field = get_field('ecolage', $course_id);
    // if ( isset($ecolage_field) && $ecolage_field != '' ){
    // 	$ecolage = $course_price_list[$ecolage_field];
    // } else {
    // 	$ecolage = null;
    // }


    $ecolage = get_the_terms($course_id, 'ecolage-cours');
    if ($ecolage) {
        $ecolage_name = (sizeof($ecolage) > 0) ? $ecolage[0]->name : null;
        $ecolage_name = str_replace(';', ' | ', $ecolage_name);
    } else {
        $ecolage_name = null;
    }



    $course->code = $school_letter[$school[0]->ID] . $category_letters[$cat[0]->term_id]  .   $course_id;



    $course->school =  array_map('api_remove_unnecessary_things', $school);


    $course->times = $times;
    $course->description = $description;
    $course->extra = $extra;
    $course->cat = $cat_name;
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

            $zone = array_values($zone);

            $loc->zone = $zone;
        }
    }


    $course = api_remove_unnecessary_things($course);



    $schools = array_map('api_get_post_title_from_object', $course->school);
    $teachers = array();
    $times = array();
    $locations = array();


    foreach ($course->times as $time) {




        array_push($times, $time['time']);


        if (is_array($time['teachers']) &&  ($time['teachers']) !== NULL) {
            $the_teachers =  array_map('api_get_post_title_from_object', $time['teachers']);
            foreach ($the_teachers as $t) {
                array_push($teachers, $t);
            }
        };
        if (($time['location'])  !== NULL) {
            //    $location =  array_map(create_function('$loc', 'return $loc->post_title;'), $time->$location);
            array_push($locations,  $time['location']->post_title);
        };
    }

    // $course_link = get_post_permalink($course_id);




    $course_array = array(
        $course->code,
        api_remove_line_breaks($course->post_title),
        // $course_link,
        implode(', ', $schools),
        api_remove_line_breaks($course->cat),
        api_remove_line_breaks(implode(', ', $teachers)),
        api_remove_line_breaks(implode(', ', $times)),
        api_remove_line_breaks(implode(', ', $locations)),
        api_remove_line_breaks($course->ecolage),
        api_remove_line_breaks($course->description),
        api_remove_line_breaks($course->extra)


    );



    // foreach($course_array as $string) {
    //     $string = str_replace(';', ' ', $string);
    //     $string = str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', $string);
    //     //    $string = preg_replace( "/(\r|\n)/", " ", $string );
    // }
    $data .=  implode(';', $course_array) . "\n";



endforeach;





$data .=  "\n";


//echo $data;




$encoded_csv = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
$filename = 'courses_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
header('Content-Length: ' . strlen($encoded_csv));
$encoded_csv =   chr(255) . chr(254) . $encoded_csv;
print $encoded_csv;
