<?php
add_action('init', 'create_categorie_and_prix_cours');
add_action('init', 'create_schoolio_post_types'); // Add our Schoolio Custom Post Types


// GET POSTED DATA FROM FORM
// TO DO REMAME FUNCTION
add_action('admin_post_nopriv_request_form',    'get_email_from_request_form');
add_action('admin_post_request_form',  'get_email_from_request_form');

// ALLOW BOOKING FORM TO BE ADDED AS A SHORTCODE
add_shortcode('request_form',  'request_form_shortcode');

// CUSTOM META BOX TO ADMIN PAGE
add_action("add_meta_boxes",  'add_course_meta_box');
//add_action("add_meta_boxes",  'add_email_meta_box' );
//add_action("add_meta_boxes",  'add_address_meta_box' );
add_action("add_meta_boxes",  'add_request_meta_boxs');


// ADD CUSTOM COLUMN TO REQUESTS PAGE
add_filter('manage_request_posts_columns', 'set_custom_edit_request_columns');
add_action('manage_request_posts_custom_column', 'custom_request_columns', 10, 2);


add_filter('manage_zone_posts_columns', 'set_custom_edit_zone_columns');
add_action('manage_zone_posts_custom_column', 'custom_zone_columns', 10, 2);

add_action('manage_posts_extra_tablenav', 'add_download_link');


add_action('restrict_manage_posts', 'add_course_filter_to_requests');
add_filter('parse_query', 'parse_course_filter_to_requests');


function parse_course_filter_to_requests($query) {
    global $pagenow;
    $type =  isset($_GET['post_type']) ?  $_GET['post_type'] : 'post';

    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ($type == 'request' && is_admin() && $pagenow == 'edit.php' && isset($_GET['course_id']) && $_GET['course_id'] != '') {
        $query->query_vars['meta_key'] = '_course_id';
        $query->query_vars['meta_value'] = $_GET['course_id'];
    }
}

function add_course_filter_to_requests() {

    $type =  isset($_GET['post_type']) ?  $_GET['post_type'] : 'post';
    // $cous =  isset($_GET['course_id']) ?  $_GET['course_id'] : '';

    if ($type == 'request') {

        $courses = new WP_Query(array('post_type'  => 'cours', 'posts_per_page' => -1, 'meta_key' => '', 'meta_value' => ''));

        echo '<select name="course_id">';
        echo '<option value="">All courses</option>';

        while ($courses->have_posts()) : $courses->the_post();
            //   $selected = ( $cous == get_the_ID()  ) ? 'selected' : '';
            //' . $selected .'
            echo '<option  value="' . get_the_ID() . '">' . get_the_title() . '</option>';
        endwhile;

        echo '</select>';



        wp_reset_query();
    }
}


function add_download_link($which) {

    if ($which == 'bottom') {

        $tdu = get_template_directory_uri();  // get_home_url()

        if (is_post_type_archive('request')) {


            $download_link = $tdu . '/api/v1/?requests';
            echo '<div class="alignleft actions"><a class="action button-primary button" href="' . $download_link . '">Télécharger CSV</a></div>';
        } else if (is_post_type_archive('cours')) {

            $download_link = $tdu . '/api/v1/?courses_export';
            echo '<div class="alignleft actions"><a class="action button-primary button" href="' . $download_link . '">Télécharger CSV</a></div>';
        }
    }
}





function create_schoolio_post_types() {
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type(
        'ecole', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Ecole', 'html5blank'), // Rename these to suit
                'singular_name' => __('Ecole', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('Ajouter Ecole', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Ecole', 'html5blank'),
                'new_item' => __('Nouvelle Ecole', 'html5blank'),
                'view' => __('Afficher Ecole', 'html5blank'),
                'view_item' => __('Afficher Ecole', 'html5blank'),
                'search_items' => __('Chercher Ecole', 'html5blank'),
                'not_found' => __('Aucune Ecole trouvée', 'html5blank'),
                'not_found_in_trash' => __('Aucune Ecole trouvée dans la corbeille', 'html5blank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                // 'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        )
    );


    register_post_type(
        'professeur', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Professeur', 'html5blank'), // Rename these to suit
                'singular_name' => __('Professeur', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('NouveauProfesseur', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Professeur', 'html5blank'),
                'new_item' => __('Ajouter Professeur', 'html5blank'),
                'view' => __('Afficher Professeur', 'html5blank'),
                'view_item' => __('Afficher Professeur', 'html5blank'),
                'search_items' => __('Chercher Professeur', 'html5blank'),
                'not_found' => __('Aucun Professeur trouvé', 'html5blank'),
                'not_found_in_trash' => __('Aucun Professeur trouvé dans la Corbeille', 'html5blank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                // 'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        )
    );


    register_post_type(
        'lieu', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Lieu', 'html5blank'), // Rename these to suit
                'singular_name' => __('Lieu', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('Nouveau Lieu', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Lieu', 'html5blank'),
                'new_item' => __('Ajouter Lieu', 'html5blank'),
                'view' => __('Afficher Lieu', 'html5blank'),
                'view_item' => __('Afficher Lieu', 'html5blank'),
                'search_items' => __('Chercher Lieu', 'html5blank'),
                'not_found' => __('Aucun Lieu trouvé', 'html5blank'),
                'not_found_in_trash' => __('Aucun Lieu trouvé dans la Corbeille', 'html5blank')
            ),
            'public' => true,
            'exclude_from_search' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                // 'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        )
    );


    register_post_type(
        'zone', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Zone', 'html5blank'), // Rename these to suit
                'singular_name' => __('Zone', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('Nouvelle Zone', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Zone', 'html5blank'),
                'new_item' => __('Ajouter Zone', 'html5blank'),
                'view' => __('Afficher Zone', 'html5blank'),
                'view_item' => __('Afficher Zone', 'html5blank'),
                'search_items' => __('Chercher Zone', 'html5blank'),
                'not_found' => __('Aucune Zone trouvée', 'html5blank'),
                'not_found_in_trash' => __('Aucune Zone trouvée dans la Corbeille', 'html5blank')
            ),
            'public' => true,
            'exclude_from_search' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'excerpt'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                // 'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        )
    );



    register_post_type(
        'cours', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Cours', 'html5blank'), // Rename these to suit
                'singular_name' => __('Cours', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('Ajouter Cours', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Cours', 'html5blank'),
                'new_item' => __('Nouveau Cours', 'html5blank'),
                'view' => __('Afficher Cours', 'html5blank'),
                'view_item' => __('Afficher Cours', 'html5blank'),
                'search_items' => __('Chercher Cours', 'html5blank'),
                'not_found' => __('Aucun Cours trouvé', 'html5blank'),
                'not_found_in_trash' => __('Aucun Cours trouvé dans la corbeille', 'html5blank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'thumbnail',
                'title',
                'author'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                'ecolage-cours',
                'categorie-cours'
            )


        )
    );




    register_post_type(
        'request', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Inscriptions', 'html5blank'), // Rename these to suit
                'singular_name' => __('Inscription', 'html5blank'),
                'add_new' => __('Ajouter', 'html5blank'),
                'add_new_item' => __('Ajouter inscription', 'html5blank'),
                'edit' => __('Modifier', 'html5blank'),
                'edit_item' => __('Modifier Inscription', 'html5blank'),
                'new_item' => __('Nouvelle inscription', 'html5blank'),
                'view' => __('Afficher insc', 'html5blank'),
                'view_item' => __('Afficher inscription', 'html5blank'),
                'search_items' => __('Chercher inscription', 'html5blank'),
                'not_found' => __('Aucune inscription trouvée', 'html5blank'),
                'not_found_in_trash' => __('Aucune inscription trouvée dans la crobeille', 'html5blank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                // 'editor',
                'title'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                // 'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        )
    );
}



add_action('admin_init', 'add_stuff_to_school_role');

function add_stuff_to_school_role() {
    $school_role = get_role('editor');
    $admin_role = get_role('administrator');

    $school_role->remove_cap('manage_coursecats');
    $admin_role->add_cap('manage_coursecats');
}







function create_categorie_and_prix_cours() {
    // Add new taxonomy, make it hierarchical (like categories)
    $cat_labels = array(
        'name'              => _x('Categorie', 'taxonomy general name', 'schoolio'),
        'singular_name'     => _x('Categorie', 'taxonomy singular name', 'schoolio'),
        'search_items'      => __('Chercher Categorie', 'schoolio'),
        'all_items'         => __('Toutes les Categories', 'schoolio'),
        'edit_item'         => __('Modifier Categorie', 'schoolio'),
        'update_item'       => __('Mettre à jour Categorie', 'schoolio'),
        'add_new_item'      => __('Ajouter Categorie', 'schoolio'),
        'new_item_name'     => __('Nouvelle Categorie', 'schoolio'),
        'menu_name'         => __('Categorie', 'schoolio'),
    );

    $cat_args = array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-cours'),
        'capabilities'      => array(
            'manage_terms' => 'manage_coursecats',
            'edit_terms' => 'manage_coursecats',
            'delete_terms' => 'manage_coursecats'
            // 'assign_terms' => 'manage_coursecats'
        )
    );

    $ecolage_labels = array(
        'name'              => _x('Ecolage', 'taxonomy general name', 'schoolio'),
        'singular_name'     => _x('Ecolage', 'taxonomy singular name', 'schoolio'),
        'search_items'      => __('Chercher Ecolage', 'schoolio'),
        'all_items'         => __('Toutes les Ecolage', 'schoolio'),
        'edit_item'         => __('Modifier Ecolage', 'schoolio'),
        'update_item'       => __('Mettre à jour Ecolage', 'schoolio'),
        'add_new_item'      => __('Ajouter Ecolage', 'schoolio'),
        'new_item_name'     => __('Nouvelle Ecolage', 'schoolio'),
        'menu_name'         => __('Ecolage', 'schoolio'),
    );

    $ecolage_args = array(
        'hierarchical'      => true,
        'labels'            => $ecolage_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'ecolage-cours'),
        'capabilities'      => array(
            'manage_terms' => 'manage_coursecats',
            'edit_terms' => 'manage_coursecats',
            'delete_terms' => 'manage_coursecats'
            // 'assign_terms' => 'manage_coursecats'
        )
    );


    register_taxonomy('categorie-cours', array('cours'), $cat_args);
    register_taxonomy('ecolage-cours', array('cours'), $ecolage_args);
}








function get_teacher_time_meta() {
    global $post;
    global $wpdb;
    $teacher_time_meta = $wpdb->get_results($wpdb->prepare("SELECT  * FROM wp_postmeta WHERE  meta_key LIKE '%s'  AND meta_value LIKE %d ", "%times_%",   $post->ID));
    return $teacher_time_meta;
}


function get_teacher_course_ids($meta) {
    # GET AN ARRAY OF ALL THE COURSE IDS
    $course_ids = array_map(function ($c) {
        return $c->post_id;
    }, $meta);
    $course_ids = array_unique($course_ids);
    return $course_ids;
}

function get_teacher_course_times($meta) {
    global $wpdb;

    # REPLACE THE META KEY TEACHER WITH TIME, AND SEARCH FOR IT TO GET THE TIMES THE TEACHER WORKS
    $course_ids = array_map(function ($c) {
        return $c->post_id;
    }, $meta);
    $metakeys_course = array_map(function ($c) {
        return $c->meta_key;
    }, $meta);
    $metakeys_time = array_map(function ($c) {
        return  str_replace('teacher', 'time', $c);
    }, $metakeys_course);

    # GET THE TIMES THAT THE TEACHER WORKS FOR EACH COURSE
    $course_ids_to_s = implode(', ', $course_ids);
    $metakeys_time_to_s = "'" . implode("', '", $metakeys_time) . "'";
    $times = $wpdb->get_results("SELECT  * FROM wp_postmeta WHERE post_id IN(  {$course_ids_to_s} )    AND meta_key IN ( {$metakeys_time_to_s} )  ");

    return $times;
};




function get_email_from_request_form() {

    // IF DATA HAS BEEN POSTED
    if (isset($_POST['action'])  && $_POST['action'] == 'request_form') :

        // TO DO CHECK IF ALL NECESSARY FIELDS HAVE BEEN FILLED IN

        // $referer = $_SERVER['HTTP_REFERER'];
        // $referer =  explode('?',   $referer)[0];


        // print_r($_SERVER);
        // print_r($referer);
        //print_r($_POST);

        $fullname = $_POST['prenom_student'] . ' ' . $_POST['nom_student'];



        $post = array(
            'post_title'     => $fullname,
            'post_status'    => 'publish',
            'post_type'      => 'request',
            'post_content'   => ''
            //      ,     'post_parent'   =>  $_POST['course_id']

        );
        $new_request = wp_insert_post($post);
        $schoolname = 'CPMDT';
        if ($_POST['student_of_cpmdt'] == 'non') {
            if ($_POST['student_of_other'] == 'CMG') {
                $schoolname = 'CMG';
            } elseif ($_POST['student_of_other'] == 'IJF') {
                $schoolname = 'IJD';
            } else {
                $schoolname = 'Pas encore inscrit';
            }
        }

        if ($new_request == 0) {
            $inscription = get_home_url() . '/inscription';
            wp_redirect($inscription . '?problem');
        } else {


            $fields = all_request_fields();



            foreach ($fields as $field => $value) {
                if (isset($_POST[$field])) {
                    add_post_meta($new_request, '_' . $field,  $_POST[$field], true);
                }
            }
            add_post_meta($new_request, '_school_name',  $schoolname, true);





            $course_id = $_POST['course_id'];
            $course = get_post($course_id);
            $course_name = $course->post_title;


            $year_name = get_field('annee', 'option');

            $headers = 'From: Cours Complémentaires <inscription@conservatoirepopulaire.ch>' . "\r\n";
            $emailheader = file_get_contents(dirname(__FILE__) . '/email/email_header.php');
            $emailfooter = file_get_contents(dirname(__FILE__) . '/email/email_footer.php');
            add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));



            // EMAIL TO STUDENT
            $potential_recipients = array($_POST['email_respondent'], $_POST['email_student']);
            $recipients_student = array_filter(
                $potential_recipients,
                function ($r) {
                    return $r != '';
                }
            );


            $subj_student = 'Confirmation d\'inscription aux Cours Complémentaires';
            $body_student = $emailheader;
            $body_student .= '
            <h1 style="line-height:120%; font-size:20px;">Conservatoire populaire de musique, danse et théâtre</h1>
            Madame, Monsieur,<br><br>

            Nous accusons réception de votre inscription pour le cours ' . $course_name . ' pour l’année scolaire' . $year_name . '.<br><br>

            Dès la constitution des classes, le professeur vous contactera et vous confirmera l’horaire et le lieu du cours.<br><br>

            Avec nos remerciements pour la confiance que vous accordez au Conservatoire Populaire, nous vous prions de recevoir nos meilleures salutations.<br><br>';
            $body_student .= $emailfooter;

            wp_mail($recipients_student, $subj_student, $body_student, $headers);






            // EMAIL TO ADMIN

            $recipient_cpmdt = 'inscription@conservatoirepopulaire.ch';

            $subj_cpmdt = 'Confirmation d\'inscription aux Cours Complémentaires';
            $body_cpmdt = $emailheader;
            $body_cpmdt .= '
            <h1 style="line-height:120%; font-size:20px;">Nouvelle inscription aux cours complémentaires</h1>

            <table class="cpmdt_email_table">
            <tr>
            <td style="padding:5px"  colspan="2"><span style="display:block; font-size:14px; text-transform:uppercase; text-align: center; font-weight:bold;">Informations sur le cours</span></td>
            <tr>
            <td style="padding:5px" >Cours</td>
            <td style="padding:5px" >' . $course_name . '</td>
            </tr>
            <tr>
            <td style="padding:5px" >Informations</td>
            <td style="padding:5px" >' . $_POST['teacher_id'] . '</td>
            </tr>
            ';
            if ($_POST['student_of_cpmdt'] == 'oui') {
                $body_cpmdt .= '<tr>
                <td style="padding:5px"  colspan="2"><span style="display:block; font-size:14px; text-transform:uppercase; text-align: center; font-weight:bold;">Informations Élève</span></td>
                <tr>
                <tr>
                <td style="padding:5px" >Élève du CPMDT</td>
                <td style="padding:5px" >' . $_POST['title_student'] . ' ' . $_POST['prenom_student'] . ' ' . $_POST['nom_student'] . '</td>
                </tr>';
            } elseif ($_POST['student_of_other'] == 'CMG') {
                $body_cpmdt .= '<tr>
                <td style="padding:5px" >Élève du CPMDT</td>
                <td style="padding:5px" >' . $_POST['title_student'] . ' ' . $_POST['prenom_student'] . ' ' . $_POST['nom_student'] . '</td>
                </tr>
                <tr>
                <td style="padding:5px" >Instrument Principal</td>
                <td style="padding:5px" >' . $_POST['instrument'] . '</td>
                </tr>';
            } elseif ($_POST['student_of_other'] == 'IJD') {
                $body_cpmdt .= '<tr>
                <td style="padding:5px" >Élève de l\'IJD</td>
                <td style="padding:5px" >' . $_POST['title_student'] . ' ' . $_POST['prenom_student'] . ' ' . $_POST['nom_student'] . '</td>
                </tr>
                <tr>
                <td style="padding:5px" >Instrument Principal</td>
                <td style="padding:5px" >' . $_POST['instrument'] . '</td>
                </tr>';
            } elseif ($_POST['student_of_other'] == 'pas_inscrit') {
                $body_cpmdt .= '<tr>
                <td style="padding:5px" >Nouvel Élève</td>
                <td style="padding:5px" >' . $_POST['title_student'] . ' ' . $_POST['prenom_student'] . ' ' . $_POST['nom_student'] . '</td>
                </tr>';
            }

            if (isset($_POST['ondine_genevoise'])) {
                $body_cpmdt .= '<tr>
                <td style="padding:5px" >Êtes-vous élève à l’Ondine genevoise ? </td>
                <td style="padding:5px" >' . $_POST['ondine_genevoise'] . '</td>
                </tr>';
            }
            if (isset($_POST['ondine_discipline'])) {
                $body_cpmdt .= '<tr>
                <td style="padding:5px" >Si oui, dans quelle discipline ?  </td>
                <td style="padding:5px" >' . $_POST['ondine_discipline'] . '</td>
                </tr>';
            }

            $body_cpmdt .= '
            <tr>
            <td style="padding:5px" >Date de naissance</td>
            <td style="padding:5px" >' . $_POST['date_naissance_student'] . '</td>
            </tr>
            <tr>
            <td style="padding:5px" >Email</td>
            <td style="padding:5px" >' . $_POST['email_student'] . '</td>
            </tr>
            <tr>
            <td style="padding:5px" >Téléphone</td>
            <td style="padding:5px" >' . $_POST['phone1_student'] . '</td>
            </tr>
            <tr>
            <td style="padding:5px" rowspan="2">Adresse</td>
            <td style="padding:5px" >' . $_POST['address_student_1'] . '</td>
            </tr>
            <tr>
            <td style="padding:5px" >' . $_POST['locality_student'] . '</td>
            </tr>';

            if (isset($_POST['proper_respondant'])) {
                if ($_POST['proper_respondant'] == 'non') {
                    $body_cpmdt .= '
                    <tr>
                    <td style="padding:5px"  colspan="2"><span style="display:block; font-size:14px; text-transform:uppercase; text-align: center; font-weight:bold;">Informations Répondant</span></td>
                    <tr>
                    <tr>
                    <td style="padding:5px" >Répondant</td>
                    <td style="padding:5px" >' . $_POST['title_respondent'] . ' ' . $_POST['prenom_respondent'] . ' ' . $_POST['nom_respondent'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >Date de naissance</td>
                    <td style="padding:5px" >' . $_POST['date_naissance_respondent'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >Email</td>
                    <td style="padding:5px" >' . $_POST['email_respondent'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >Téléphone</td>
                    <td style="padding:5px" >' . $_POST['phone1_respondent'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" rowspan="2">Adresse</td>
                    <td style="padding:5px" >' . $_POST['address_respondent_1'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >' . $_POST['locality_respondent'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >Lieu d\'imposition</td>
                    <td style="padding:5px" >' . $_POST['lieu_imposition'] . '</td>
                    </tr>
                    <tr>
                    <td style="padding:5px" >Paiement de la facture</td>
                    <td style="padding:5px" >Paiement en ' . $_POST['facture'] . '</td>
                    </tr>';
                }
            }

            // if(isset($_POST['authorize'])){
            //     $body_cpmdt .='
            //     <tr>
            //     <td style="padding:5px"  colspan="2"><span style="display:block; font-size:14px; text-transform:uppercase; text-align: center; font-weight:bold;">Photos</span></td>
            //     </tr>
            //     <tr>
            //     <td style="padding:5px"  colspan="2">Les institutions peuvent utiliser des images (photo, vidéos) où apparaît l\'élève / diffusion dans des brochures ou publications uniquement institutionnelles.</td>
            //     <tr>';
            // } else {
            //     $body_cpmdt .='
            //     <tr>
            //     <td style="padding:5px"  colspan="2"><span style="display:block; font-size:14px; text-transform:uppercase; text-align: center; font-weight:bold;">Photos</span></td>
            //     </tr>
            //     <tr>
            //     <td style="padding:5px"  colspan="2">Les institutions ne sont pas autorisées à prendre ou diffuser de photos de l\'élève.</td>
            //     <tr>';
            //
            // }


            ' </table>
            ';
            $body_cpmdt .= $emailfooter;

            wp_mail($recipient_cpmdt, $subj_cpmdt, $body_cpmdt, $headers);







            remove_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type');





            //wp_redirect( $referer . '?success' );
            $redirect = get_home_url() . '/inscription-reussie/';
            wp_redirect($redirect);
        }


        exit;



    endif;
}


function add_zone_from_locations() {
    $locations = get_posts(array('post_type'  => 'lieu', 'posts_per_page' => -1));

    $zones = array();
    foreach ($locations as $location) :
        $zone_text = trim(get_field('localite', $location->ID));
        if ($zone_text != '')  array_push($zones, $zone_text);

    endforeach;

    $zones = array_unique($zones);

    foreach ($zones as $zone) :

    // $post = array(
    //   'post_title'     => $zone,
    //   'post_status'    => 'publish',
    //   'post_type'      => 'zone',
    //   'post_content'   =>  ''

    // );
    // $new_zone = wp_insert_post( $post );
    // print_r($new_zone);


    endforeach;

    return $zones;
}




function get_all_current_courses() {
    $posts_array = get_posts(
        array(
            'post_type'  => 'cours',
            'order' => 'ASC',
            'orderby' => 'title',
            'posts_per_page' => -1,
            'post_status' => 'published'

        )
    );
    return $posts_array;
}


function get_all_current_courses_CPMDT() {
    $posts_array = get_posts(
        array(
            'post_type'  => 'cours',
            'order' => 'ASC',
            'orderby' => 'title',
            'posts_per_page' => -1,
            'post_status' => 'published',
            'meta_query' => array(
                array(
                    'key'     => 'school',
                    'value'   => '4',   // ONLY CPMDT HAS A 4 IN ITS ID !
                    'compare' => 'LIKE'
                )
            )

        )
    );
    return $posts_array;
}


function get_teacher_time_meta_of_course($course_id) {
    // TAKES A COURSE ID AND GIVES THE TEACHERS WHO TEACH IT
    $post = get_post($course_id);
    return $post;
}



//  ADD REQUEST FORM AS A SHORTCODE
function request_form_shortcode($atts, $content = null) {

    $courses = get_all_current_courses();
    $rq_frm = '';



    $get_course_id = isset($_GET['course_id'])  ? $_GET['course_id'] : false;


    //  $rq_frm .= '<p>Si vous êtes déjà inscrits au CMG, IJD ou CPMDT comme élève instrumentiste, merci de donner ces d’informations ci-dessous et de ne remplir que les champs obligatoires de la suite du formulaire.<br/> Si vous n’êtes pas déjà inscrits au CMG, IJD ou CPMDT comme élève instrumentiste, merci de remplir tous les champs (sauf instrument suivis et Ecole).</p><br/><br/>

    $rq_frm .= ' <form id="course_form" action="' .  esc_url(admin_url('admin-post.php')) . '" method="post">';



    $rq_frm .= '<h3>Cours complémentaire</h3>
    <div class="field field_for_select" id="course_id_select_box"><select id="course_id" name="course_id">';
    $rq_frm .= '<option value="0">Choisir un cours</option>';
    foreach ($courses as $course) :
        $selected =  ''; // ($course->ID == $get_course_id  ) ? 'selected' : '';
        $rq_frm .= '<option ' . $selected . ' value="' .  $course->ID  . '">' .  ($course->post_title)   . '</option>';
    endforeach;
    $rq_frm .= '</select></div>';

    $rq_frm .= '<div class="field" id="teacher_id_cont"></div>';




    $rq_frm .= '<div class="group_for_cpmdt_courses field_group"><h3>Informations pratiques</h3>';


    $rq_frm .=  '<div id="student_of_cpmdt_check" class="field group_visible ">
    <p>Êtes-vous déjà inscrit au CPMDT comme élève instrumentiste ?</p>
    <label class="inline_label"><input type="radio" class="radio_input" value="oui" name="student_of_cpmdt" />Oui</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="non" name="student_of_cpmdt" />Non</label>
    </div>';



    $rq_frm .=  '<div id="student_of_other_check" class="field field_group group_not_for_student_of_cpmdt">
    <p>Êtes-vous déjà inscrit au CMG ou à l’IJD comme élève instrumentiste?</p>
    <label class="inline_label"><input type="radio" class="radio_input" value="CMG" name="student_of_other" />CMG</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="IJD" name="student_of_other" />IJD</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="pas_inscrit" name="student_of_other" />Je ne suis pas inscrit</label>
    </div>';


    $rq_frm .=  ' <div class="field field_group group_for_otherschools">
    <div class="row"><div class="col-sm-6">
    <label for="instrument" >Instrument prinicipal</label>
    <input type="text" name="instrument" id="instrument" />
    </div></div>
    </div>';

    $rq_frm .=  '<div  id="ondine_genevoise_check"  class="field field_group group_not_for_student_of_cpmdt">
    <p>Êtes-vous élève à l\'Ondine genevoise ?</p>
    <label class="inline_label"><input type="radio" class="radio_input" value="oui" name="ondine_genevoise" />Oui</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="non" name="ondine_genevoise" />Non</label>
    </div>';

    $rq_frm .=  '<div class="field field_group group_for_ondine">
    <p>Si oui, dans quelle discipline?</p>
    <label class="inline_label"><input type="radio" class="radio_input" value="Percussion" name="ondine_discipline" />Percussion</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="Instrument à vent" name="ondine_discipline" />Instrument à vent</label>
    </div>';




    $rq_frm .=  '<div id="proper_respondent_check" class="field field_group group_not_for_student_of_cpmdt">
    <p>Êtes-vous votre propre répondant?</p>
    <label class="inline_label"><input type="radio" class="radio_input" value="oui" name="proper_respondant" /> Oui</label>
    <label class="inline_label"><input type="radio" class="radio_input" value="non" name="proper_respondant" /> Non</label>
    </div>';





    $rq_frm .= '<div style="margin:0 -40px" class="row">

    <div style="padding:0 40px" class="col-sm-6">
    <h3 class=" field_group student_group">Elève</h3>';


    // <option value="Mademoiselle">Mademoiselle</option> 

    $rq_frm .=
        '<div class=" field_group student_group">
    <div class="field field_for_select">
    <select id="title_student" name="title_student">
    <option value="Madame">Madame</option>
    <option value="Monsieur">Monsieur</option>
    </select>

    </div>';

    $rq_frm .=
        '<div class="field">
    <label for="nom_student">Nom</label>
    <input type="text" name="nom_student" id="nom_student" />
    </div>
    <div class="field">
    <label for="prenom_student">Prénom</label>
    <input type="text" name="prenom_student" id="prenom_student" />
    </div>
    <div class="field">
    <label for="date_naissance_student">Date de naissance</label>
    <input type="text" name="date_naissance_student" id="date_naissance_student" class="datepicker"  />
    </div>';

    $rq_frm .=
        '<div class="field">
    <label for="email_student">Email</label>
    <input type="text" name="email_student" id="email_student" class="copy_input" data-copy="#email_respondent" />
    </div>
    <div class="field">
    <label for="phone1_student">Téléphone</label>
    <input type="text" name="phone1_student" id="phone1_student" class="copy_input" data-copy="#phone1_respondent" />
    </div>
    </div>';

    $rq_frm .= '<div class="field_group student_address_group ">
    <div class="field">
    <label for="address_student_1">Adresse</label>
    <input type="text" name="address_student_1" id="address_student_1" class="copy_input" data-copy="#address_respondent_1" />
    </div>

    <div class="field">
    <label for="locality_student">NP – Localité</label>
    <input type="text" name="locality_student" id="locality_student" class="copy_input" data-copy="#locality_respondent" />
    </div>
    </div>'; // END OF FIELD GROUP GROUP FOR STUENT OF CPMDT






    $rq_frm .= '</div>'; // END OF ONE COLUMN



    $rq_frm .=  ' <div style="padding:0 40px" class="col-sm-6  field_group respondent_group  right_border_col">
    <h3>Répondant</h3>';

    // <option value="Mademoiselle">Mademoiselle</option>
    $rq_frm .=
        '<div class="field field_for_select">
    <select id="title_respondent" name="title_respondent">
    <option value="Madame">Madame</option>
    <option value="Monsieur">Monsieur</option>
    </select>
    </div>';

    $rq_frm .=
        '<div class="field">
    <label for="nom_respondent">Nom</label>
    <input type="text" name="nom_respondent" id="nom_respondent" />
    </div>
    <div class="field">
    <label for="prenom_respondent">Prénom</label>
    <input type="text" name="prenom_respondent" id="prenom_respondent" />
    </div>
    <div class="field">
    <label for="date_naissance_respondent">Date de naissance</label>
    <input type="text" name="date_naissance_respondent" id="date_naissance_respondent"  />
    </div>';

    $rq_frm .=
        '<div class="field">
    <label for="email_respondent">Email </label>
    <input type="name" name="email_respondent" id="email_respondent" />
    </div>
    <div class="field">
    <label for="phone1_respondent">Téléphone</label>
    <input type="text" name="phone1_respondent" id="phone1_respondent" />
    </div>
    ';

    $rq_frm .=  '<div class="field">
    <label for="address_respondent_1">Adresse</label>
    <input type="text" name="address_respondent_1" id="address_respondent_1" />
    </div>

    <div class="field">
    <label for="locality_respondent">NP – Localité</label>
    <input type="text" name="locality_respondent" id="locality_respondent" />
    </div>';



    $rq_frm .=
        '<div class="field">
    <label for="lieu_imposition">Lieu d’imposition </label>
    <input type="text" name="lieu_imposition" id="lieu_imposition"  />
    </div>';



    $rq_frm .=  '
    <p style="margin-bottom:-15px;">Facture payable en :</p>
    <select id="facture" name="facture">
    <option value="1 fois">1 fois</option>
    <option value="3 fois">3 fois</option>
    </select>
    <br/>
    <br/>
    <br/>

    </div>
    </div>'; // END OF ANOTHER COLUMN







    // $dontadd =  ' <div class="field">
    // <label style="margin-bottom: 15px;" for="school_student">Ecole</label>
    // <select id="school_student" name="school_student">
    // <option value="CMG">CMG</option>
    // <option value="CPMDT">CPMDT</option>
    // <option value="IJD">IJD</option>
    // </select>
    // </div>';


    // $rq_frm .= ' <div class="field"><label for="message">Your Message</label><textarea name="message" id="message"></textarea></div>';




    $rq_frm .= '<div class="group_visible">';
    $rq_frm .= '<div class="field" style="margin:40px 0 0"><p>L’institution utilise des images de groupe d’élèves ou portrait d’élève (photos, vidéos), prises lors des cours et manifestations sur lesquelles pourront apparaître votre enfant.<br>Ces images sont utilisées pour les brochures, affiches et/ou site web de l’institution à des fins informatives et promotionnelles.<br>Le parent ou le représentant légal de l’élève concerné autorise donc le CPMDT à réutiliser l’image de ce dernier conformément à cette clause et, si l’élève a la maturité nécessaire, en accord ou concertation avec lui.<br>Pour toute demande d’accès, de rectification ou de suppression d’une photo ou d’une vidéo, merci de nous le signaler par e-mail: <a href="mailto:"administration@conservatoirepopulaire.ch" target="_blank">administration@conservatoirepopulaire.ch</a></p></div>';

    $rq_frm .= '<div class="field" style="margin:0px 0 40px"><label><input id="agree_terms" type="checkbox" class="radio_input" value="agree" name="terms" /> Je certifie avoir pris connaissance des <a href="' . get_home_url() . '/wp-content/uploads/2018/04/Conditions_2018-2019.pdf" target="_blank">Termes et Conditions générales</a>  </label> </div>';
    $rq_frm .= '</div>';



    $rq_frm .= '<input type="hidden" name="action" value="request_form">
    <div class="submit_group_button">
    <input type="submit" id="submit_course_form" value="Envoyer">
    <div id="stopsubmit"></div>
    </div>
    <br><br>
    <p class="fillitall">Veuillez remplir tous les champs pour valider l\'inscription.</p>
    </div> <!-- END OF group_for_cpmdt_courses -->
    </form>';

    $rq_frm .= '<div class=" field_group group_for_non_cpmdt_courses"></div>';


    if (isset($_GET['success'])) :
        $rq_frm .=  '<div class="alert alert-success">Votre inscription a bien été enregistrée!</div>';
    elseif (isset($_GET['problem'])) :
        $rq_frm .=  '<div class="alert alert-danger">Une erreur s’est produite. Veuillez réessayer..</div>';
    endif;

    // HIDDEN ACTION INPUT IS REQUIRED TO POST THE DATA TO THE CORRECT PLACE

    return  $rq_frm;
}




// function all_request_fields(){

//     return array('student_of_cpmdt', 'student_of_other', 'title_student' ,'nom_student' ,'prenom_student' ,'date_naissance_student' ,'email_student' ,'phone1_student' ,'address_student_1' ,'locality_student' , 'proper_respondant', 'title_respondent' ,'nom_respondent' ,'prenom_respondent' ,'date_naissance_respondent' ,'email_respondent' ,'phone1_respondent' ,'address_respondent_1' ,'locality_respondent' ,'lieu_imposition' ,'facture'  ,  'school_student', 'instrument',   'course_id' ,'authorize' ,'teacher_id');
// }


function all_request_fields() {

    return array(
        'school_name' => 'Nom de l\'école',
        'student_of_cpmdt'  =>  'Elève  CPMDT',
        'student_of_other'  =>  'Elève autre école',
        'ondine_genevoise'  =>  'Elève à l\'Ondine genevoise',
        'ondine_discipline'  =>  'Si oui, dans quelle discipline?',
        'instrument'  =>  'Instrument',
        'title_student'   =>  'Titre de l\'élève',
        'nom_student'   =>  'Nom de l\'élève',
        'prenom_student'   =>  'Prénom de l\'élève',
        'date_naissance_student'   =>  'Date de naissance de l\'élève',
        'email_student'   =>  'Email de l\'élève',
        'phone1_student'   =>  'Téléphone de l\'élève',
        'address_student_1'   =>  'Adresse de l\'élève',
        'locality_student'   =>  'Localité de l\'élève',
        'proper_respondant'  =>  'Propre répondant',
        'title_respondent'   =>  'Titre du répondant',
        'nom_respondent'   =>  'Nom du répondant',
        'prenom_respondent'   =>  'Prénom du répondant',
        'date_naissance_respondent'   =>  'Date de naissance du répondant',
        'email_respondent'   =>  'Email du répondant',
        'phone1_respondent'   =>  'Téléphone du répondant',
        'address_respondent_1'   =>  'Adresse du répondant',
        'locality_respondent'   =>  'Localité du répondant',
        'lieu_imposition'   =>  'Lieur d\'imposition',
        'facture'    =>  'Facture',
        'school_student'  =>  'Ecole de l\'élève',
        'course_id'   =>  'Cours',
        'teacher_id'  =>  'Information',
        'authorize'   =>  'Autorisation photo'


    );
}






function add_request_meta_boxs() {


    $fields = all_request_fields();

    add_meta_box(
        'request_fields',
        'Form Fields',
        'request_metabox_markup',
        "request",
        "normal",
        "high",
        null
    );
}

function request_metabox_markup() {
    $fields = all_request_fields();
    global $post;
    $ret = array();
    foreach ($fields as $field => $value) {
        $result = get_post_meta($post->ID, $key = '_' . $field, true);
        if (isset($result) && $result != '') :
            array_push($ret,  '<strong>' .  ucfirst(str_replace('_', ' ',  $value))  . ': </strong> <span>' .   $result . '</span>');
        endif;
    }

    echo '<div>' . implode('<br/>', $ret) . "</div>";
}




// ADD A CUSTOM META BOX TO THE REQUEST#SHOW PAGE
function  add_email_meta_box() {
    add_meta_box(
        "email-meta-box",
        "Email Address",
        'email_meta_box_markup',
        "request",
        "normal",
        "high",
        null
    );
}

function  email_meta_box_markup() {
    global $post;

    $email = get_post_meta($post->ID, $key = '_email_address', true);
    if (isset($email)) :
        echo $email;
    endif;
}

function  add_address_meta_box() {
    add_meta_box(
        "address-meta-box",
        " Address",
        'address_meta_box_markup',
        "request",
        "normal",
        "high",
        null
    );
}

function  address_meta_box_markup() {
    global $post;

    $address = get_post_meta($post->ID, $key = '_address', true);
    if (isset($address)) :
        echo $address;
    endif;
}


function  add_course_meta_box() {
    add_meta_box(
        "course-meta-box",
        "Course Details",
        'course_meta_box_markup',
        "request",
        "normal",
        "high",
        null
    );
}

function  course_meta_box_markup() {
    global $post;

    $course_id = get_post_meta($post->ID, $key = '_course_id', true);
    $time = get_post_meta($post->ID, $key = '_teacher_id', true);

    if (isset($course_id)) :
        $course = get_post($course_id);
        if ($course_id > 0) :
            $adminpostlink = get_edit_post_link($course_id);
            echo '<a href="' . $adminpostlink . '">' . $course->post_title . '</a>';
        else :
            _e('-', 'schoolio');
        endif;
    endif;

    if (isset($time)) :
        echo '<br>' .  $time;
    endif;
}


// ADD CUSTOM COLUMN TO REQUESTS INDEX ADMIN PAGE
function set_custom_edit_request_columns($columns) {
    unset($columns['author']);
    $columns['customer'] = __('Email', 'schoolio');
    $columns['course'] = __('Cours', 'schoolio');
    $columns['horaire'] = __('Horaire', 'schoolio');
    return $columns;
}

function custom_request_columns($column, $post_id) {
    switch ($column) {

        case 'customer':
            $email = get_post_meta($post_id, '_email_respondent', true);
            if (isset($email))
                echo $email;
            else
                _e('-', 'schoolio');
            break;

        case 'course':
            $course_id = get_post_meta($post_id, '_course_id', true);
            $course = get_post($course_id);
            if ($course_id > 0) :
                $adminpostlink = get_edit_post_link($course_id);
                echo '<a href="' . $adminpostlink . '">' . $course->post_title . '</a>';
            else :
                _e('-', 'schoolio');
            endif;

            break;

        case 'horaire':
            $time = get_post_meta($post_id, '_teacher_id', true);
            echo $time;

            break;
    }
}



// ADD CUSTOM COLUMN TO REQUESTS INDEX ADMIN PAGE
function set_custom_edit_zone_columns($columns) {

    $columns['latlng'] = __('Latitude/Longitude', 'schoolio');
    return $columns;
}

function custom_zone_columns($column, $post_id) {
    switch ($column) {

        case 'latlng':
            $latlng = get_post_field('post_excerpt', $post_id);
            if (isset($latlng))
                echo $latlng;
            else
                _e('-', 'schoolio');
            break;
    }
}

add_filter('gettext', 'wpse22764_gettext', 10, 2);
function wpse22764_gettext($translation, $original) {
    if ('Excerpt' == $original) {
        return 'Latitude/Longitude';
    } else {
        $pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
        if ($pos !== false) {
            return  ' ';
        }
    }
    return $translation;
}



function get_school_id_from_course($course_id) {


    $school =  get_field('school', $course_id);
    if (sizeof($school) > 0) {
        return $school[0]->post_title;
    } else {
        return null;
    }
}


function zones_for_map() {
    $zones =  get_posts(array('post_type'  => 'zone',   'posts_per_page' => -1));

    $ret = array();
    foreach ($zones as $zone) {

        $z = new stdClass();
        $latlon = explode(',',  $zone->post_excerpt);

        if (sizeof($latlon) == 2) { // if has latitude and long itude
            $z->title = $zone->post_title;
            $z->lat = trim($latlon[0]);
            $z->lng = trim($latlon[1]);
            $z->id =  $zone->ID;

            if ($z->lat != '')  array_push($ret, $z);
        }
    }


    echo json_encode($ret,  JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}


// LOAD SCHOOLIO JS FILE
add_action('wp_enqueue_scripts', 'my_enqueue');
function my_enqueue($hook) {

    wp_enqueue_script('ajax-script', (get_template_directory_uri() . '/js/schoolio.js'), array('jquery'), '1.0.7', true);
    wp_localize_script(
        'ajax-script',
        'ajax_object',
        array('ajax_url' => admin_url('admin-ajax.php'))
    );
}


// FILL THE HORAIRES FIELD WHEN SELECT COURSE
add_action('wp_ajax_my_action', 'my_action_callback');
add_action('wp_ajax_nopriv_my_action', 'my_action_callback');
function my_action_callback() {
    $course_id =  $_POST['course_id'];
    $horiaires = get_horaires_from_course($course_id);
    $school_id = get_school_id_from_course($course_id);

    $ret = new StdClass();
    $ret->horaires = $horiaires;
    $ret->course_id = $course_id;
    $ret->school = $school_id;

    echo  json_encode($ret);


    wp_die();
}


function get_horaires_from_course($course_id) {

    //  $course = get_post($course_id);

    if (have_rows('times',  $course_id)) :

        $ret = [];

        $count_hours =   count(get_field_object('times', $course_id)['value']);

        // if multiple choices, give a drop down
        if ($count_hours > 1) {

            $ret = '<div class="field_for_select"><select id="teacher_id" name="teacher_id">';
            while (have_rows('times', $course_id)) : the_row();

                $teachers = get_sub_field('teachers');
                $t_array = array();
                foreach ($teachers as $teacher) {
                    array_push($t_array, $teacher->post_title);
                }

                if (get_sub_field('time') != '')  array_push($t_array,  get_sub_field('time'));
                if (get_sub_field('location')->post_title != '')  array_push($t_array,  get_sub_field('location')->post_title);
                $option_str = implode(' | ', $t_array);

                $ret .= '<option value="' . $option_str  . '">' . $option_str .  '</option>';

            endwhile;
            $ret .= ' </select></div>';
        } else { // otherwise just give one options


            while (have_rows('times', $course_id)) : the_row();
                $teach_str = '';
                $time = get_sub_field('time');
                $loc = get_sub_field('location')->post_title;
                $teachers = get_sub_field('teachers');
                $t_array = array();
                foreach ($teachers as $teacher) {
                    array_push($t_array, $teacher->post_title);
                }
                $option_array = $t_array;
                array_push($option_array,  get_sub_field('time'));
                array_push($option_array,  get_sub_field('location')->post_title);
                $teach_str = implode(' | ', $t_array);
                $option_str = implode(' | ', $option_array);
            // $teach_str .=   $time . ' | ';
            // $teach_str .=   $loc;

            endwhile;

            $ret =  '<input type="hidden" name="teacher_id" value="' .  $option_str  . '" />';
            $ret .= '<div class="row">';
            if ($time != '') $ret .= '<div class="col-sm-4"><h5>Horaire</h5><p>' . $time . '</p></div>';
            if ($teach_str != '')   $ret .= '<div class="col-sm-4"><h5>Professeur(s)</h5><p>'  . $teach_str . '</p></div>';
            if ($loc != '')  $ret .= '<div class="col-sm-4"><h5>Lieu</h5><p>' . $loc . '</p></div>';
            $ret .= '</div>';
        }





    else :
        $ret = '';
    endif;

    return $ret;
}


    // TO DO MOVE API/COURSE/SHOW TO HERE.
    // SILLY IT BEING IN THE API
