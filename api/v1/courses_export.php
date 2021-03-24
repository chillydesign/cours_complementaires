<?php

// NOT USED. USE COURSES DOWNLOAD INSTEAD
// NOT USED. USE COURSES DOWNLOAD INSTEAD
// NOT USED. USE COURSES DOWNLOAD INSTEAD
// NOT USED. USE COURSES DOWNLOAD INSTEAD



$posts_array = get_posts(array('post_type'  => 'cours', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'ASC'));
$prof_posts = get_posts(array('post_type'  => 'professeur', 'posts_per_page' => -1));
$location_posts = get_posts(array('post_type'  => 'lieu', 'posts_per_page' => -1));

$post_ids =  array_map('api_get_id_from_object', $posts_array);
$course_categories = api_get_course_cats($post_ids);
$course_schools = api_get_course_schools($post_ids);
$course_descriptions = api_get_course_descriptions($post_ids);
$course_extras = api_get_course_extras($post_ids);
$course_locations = api_get_course_locations($post_ids);
$location_ids =  array_map('api_get_wid_from_object', $course_locations);
$course_zones = api_get_course_zones($location_ids);
$course_professeurs = api_get_course_professeurs($post_ids);
$course_ecolages = api_get_course_ecolages($post_ids);



$school_letter = chilly_school_letters();
$category_letters = chilly_category_letters();




var_dump($course_ecolages);

// $headers = 'Code;Titre;Ecole;Catégorie;Professeurs;Horaire;Lieux;Ecolage;Description;Informations supplémentaires' .  "\n";
$headers = 'Code,Titre,Ecole,Catégorie,Professeurs,Horaire,Lieux,Ecolage,Description,Informations supplémentaires' .  "\n";


$courses_array = array();

foreach ($posts_array as $post) {


    $course_array = array();



    // get the categories for the specific post
    // categories and school are needed to get the code
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


    if (strlen($post->school) < 3) {
        $post->school = [$post->school];
    } else {
        $uns_sch = unserialize($post->school);
        $post->school = $uns_sch;
    }



    if (sizeof($post->categories) > 0) {
        $post->code = $school_letter[$post->school[0]] . $category_letters[$post->categories[0]->term_id]  .   $post->ID;
    } else {
        $post->code = '-';
    }

    array_push($course_array,  $post->code);


    array_push($course_array,  api_remove_line_breaks($post->post_title));



    if (sizeof($post->school) > 0) {

        if ($post->school[0] == 7) {
            array_push($course_array,  'CMG');
        } else if ($post->school[0] == 4) {
            array_push($course_array,  'CPMDT');
        } else if ($post->school[0] == 38) {
            array_push($course_array,  'IJD');
        } else {
            array_push($course_array,  '--');
        }
    } else {
        array_push($course_array,  '-');
    }




    if (sizeof($post->categories) > 1) {
        array_push($course_array,  $post->categories[0]->name . ' & ' .  $post->categories[1]->name);
    } else if (sizeof($post->categories) > 0) {
        array_push($course_array,  $post->categories[0]->name);
    } else {
        array_push($course_array,  '-');
    }




    // get the prof
    $professuers = array_filter(
        $course_professeurs,
        function ($e)  use ($post) {
            return $e->post_id == $post->ID;
        }
    );
    $prof_array = array();
    foreach ($professuers as $post_meta) {
        if ($post_meta->meta_key[0] != '_' && $post_meta->meta_value != '') {

            if (strlen($post_meta->meta_value) > 1) {
                if ($post_meta->meta_value[1] == ':') {  // it is a serialised array
                    $unserialised = unserialize($post_meta->meta_value);

                    foreach ($unserialised as $teacher_id) {
                        array_push($prof_array,  $teacher_id);
                    }
                } else {
                    //    array_push($prof_array,  $post_meta->meta_value );
                }
            } else {
                array_push($prof_array,  $post_meta->meta_value);
            }
        }
    }
    $post->professuers = array_values(array_unique($prof_array));

    $prof_string_array = array();
    foreach ($post->professuers as $professuer_id) {
        foreach ($prof_posts as $prof_post) {
            if ($prof_post->ID ==  $professuer_id) {
                array_push($prof_string_array,   $prof_post->post_title);
            }
        }
    }
    array_push($course_array,    implode(' & ', $prof_string_array));




    array_push($course_array,   '  HORAIRE HERE ');





    // get the location
    $location = array_filter(
        $course_locations,
        function ($e)  use ($post) {
            return $e->wppid == $post->ID;
        }
    );
    $locations =  array_values(array_map('api_get_wid_from_object', $location));
    $post->location = array_unique($locations);


    $loc_str_array = array();
    foreach ($post->location as $location_id) {
        foreach ($location_posts as $location_post) {
            if ($location_post->ID ==  $location_id) {
                array_push($loc_str_array,   $location_post->post_title);
            }
        }
    }
    array_push($course_array,    api_remove_line_breaks(implode(' & ', $loc_str_array)));







    array_push($course_array,   '  ECOLAGE HERE ');






    // // get the zone
    // $zone = array_filter(
    //     $course_zones,
    //     function ($e)  use ($post) {
    //         return  in_array($e->wppid, $post->location);
    //     }
    // );
    // $zones =  array_values(array_map(create_function('$l', 'return $l->wid;'), $zone));
    // $post->zone = $zones;
    //







    // get the description
    $description = array_filter(
        $course_descriptions,
        function ($e)  use ($post) {
            return $e->post_id == $post->ID;
        }
    );
    $des = array_values($description);
    $des = reset($des);
    $des = $des->meta_value;
    $post->description =    ($des != null) ? api_remove_line_breaks($des) : '';
    #$post->description = ($des != null) ? $des : '';

    array_push($course_array,  $post->description);








    // get the extra
    $extra = array_filter(
        $course_extras,
        function ($e)  use ($post) {
            return $e->post_id == $post->ID;
        }
    );
    $ext = array_values($extra);
    $ext = reset($ext);
    $ext = $ext->meta_value;
    $post->extra = ($ext != null) ? api_remove_line_breaks($ext) : '';

    array_push($course_array,   $post->extra);


    array_push($courses_array, implode(',', $course_array));
}

$data =  $headers .  implode("\n", $courses_array);



$file = 'courses';
$filename = $file . '_' . date('Y-m-d_H-i', time());
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: csv' . date('Y-m-d') . '.csv');
header('Content-disposition: filename=' . $filename . '.csv');
print $data;
