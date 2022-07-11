<?php


$posts_array = get_posts(array('post_type'  => 'cours', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'ASC'));
$post_ids =  array_map(function ($p) {
    return $p->ID;
}, $posts_array);
$course_categories = api_get_course_cats($post_ids);
$course_schools = api_get_course_schools($post_ids);
$course_descriptions = api_get_course_descriptions($post_ids);
$course_extras = api_get_course_extras($post_ids);
$course_locations = api_get_course_locations($post_ids);
$location_ids =  array_map(function ($p) {
    return $p->wid;
}, $course_locations);
$course_zones = api_get_course_zones($location_ids);
$course_professeurs = api_get_course_professeurs($post_ids);
// $course_ecolages = api_get_course_ecolages($post_ids);




$school_letter = chilly_school_letters();
$category_letters = chilly_category_letters();


foreach ($posts_array as $post) {


    // get the categories for the specific post
    $cats = array_filter(
        $course_categories,
        function ($e)  use ($post) {
            return $e->object_id == $post->ID;
        }
    );
    $post->categories = array_values($cats);
    $post->cat_names = api_categories_to_cat_names($post->categories);




    // get the school
    $school = array_filter(
        $course_schools,
        function ($e)  use ($post) {
            return $e->wppid == $post->ID;
        }
    );
    $sc =  array_values($school);
    $sc = reset($sc);

    if ($sc) {
        $sc = $sc->meta_value;
        $post->school = ($sc != null) ? $sc : '';
    } else {
        $post->school = '';
    }




    if (strlen($post->school) < 3) {
        $post->school = [$post->school];
    } else {
        $uns_sch = unserialize($post->school);
        $post->school = $uns_sch;
    }

    // get the location
    $location = array_filter(
        $course_locations,
        function ($e)  use ($post) {
            return $e->wppid == $post->ID;
        }
    );
    $locations =  array_values(array_map(function ($p) {
        return $p->wid;
    }, $location));
    $post->location = $locations;


    // get the zone
    if ($post->location) {
        $zone = array_filter(
            $course_zones,
            function ($e)  use ($post) {
                return  in_array($e->wppid, $post->location);
            }
        );
        $zones =  array_values(array_map(function ($l) {
            return $l->wid;
        }, $zone));
        $post->zone = $zones;
    } else {
        $post->zone =  [];
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







    if (sizeof($post->categories) > 0) {
        $post->code = $school_letter[$post->school[0]] . $category_letters[$post->categories[0]->term_id]  .   $post->ID;
    } else {
        $post->code = '-';
    }





    // get the description
    $description = array_filter(
        $course_descriptions,
        function ($e)  use ($post) {
            return $e->post_id == $post->ID;
        }
    );
    $des = array_values($description);
    $des = reset($des);

    if ($des) {
        $des = $des->meta_value;
        $post->description = ($des != null) ? implode(' ', array_slice(explode(' ', strip_tags($des)), 0, 20)) . '...'  : '';
        #$post->description = ($des != null) ? $des : ''; 
    } else {
        $post->description = '';
    }




    // get the ecolage
    // $ecolage = array_filter(
    // 	$course_ecolages,
    // 	function ($e)  use ($post) {
    // 		return $e->post_id == $post->ID;
    // 	}
    // );
    // $ecol = array_values($ecolage);
    // $ecol = reset($ecol);
    // $ecol = $ecol->meta_value;
    // $post->ecolage = $ecol;




    $searchable_fields = array($post->post_title, $post->description, $post->extra, $post->code);
    $searchable_fields = implode('  ', $searchable_fields);
    $searchable_fields = wp_strip_all_tags($searchable_fields);


    $searchable_fields = str_replace(array("\n", "\r"), ' ', $searchable_fields);
    $searchable_fields = str_replace(array("!", "’", ',', '/', ':', "?", '.', '–'), ' ', $searchable_fields);
    //$searchable_fields = preg_replace( '/[^A-Za-z0-9_-]/', '', $searchable_fields );
    $searchable_fields = remove_accents($searchable_fields);
    $searchable_fields = strtolower($searchable_fields);
    $post->searchfield = $searchable_fields;






    // get the extra
    $extra = array_filter(
        $course_extras,
        function ($e)  use ($post) {
            return $e->post_id == $post->ID;
        }
    );
    $ext = array_values($extra);
    $ext = reset($ext);
    if ($ext) {
        $ext = $ext->meta_value;
        $post->extra = ($ext != null) ? strip_tags($ext) : '';
    } else {
        $post->extra = '';
    }



    $post->url = get_permalink($post->ID);




    // remove unncessary params
    $unncessary_params = ['comment_count', 'post_status', 'post_mime_type',  'ping_status', 'comment_status', 'menu_order', 'post_parent', 'post_date_gmt',  'post_modified_gmt', 'post_password',  'post_excerpt', 'pinged', 'to_ping', 'filter', 'post_content_filtered'];
    foreach ($unncessary_params as $up) {
        unset($post->$up);
    }
}




echo json_encode($posts_array,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);



// get the location
// $location = array_filter(
// 	$course_locations,
// 	function ($e)  use ($post) {
// 		return $e->wppid == $post->ID;
// 	}
// );
// $loc =  reset(array_values($location))->wid ;
// $post->location = ($loc != null) ? $loc : '';
