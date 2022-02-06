<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?><?php if (wp_title('', false)) {
                                        echo ' :';
                                    } ?> <?php bloginfo('name'); ?></title>
    <?php $tdu = get_template_directory_uri(); ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $tdu; ?>/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $tdu; ?>/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $tdu; ?>/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $tdu; ?>/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $tdu; ?>/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $tdu; ?>/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $tdu; ?>/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $tdu; ?>/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $tdu; ?>/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $tdu; ?>/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $tdu; ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $tdu; ?>/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $tdu; ?>/img/favicon/favicon-16x16.png">

    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <link media="all" href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Lato:300,300i" rel="stylesheet">
    <link media="all" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    <div class="allbutfooter">

        <!-- HEADER -->
        <header id="header">


            <?php if (is_front_page()) : ?>

                <h1><a id="page_title" href="<?php echo site_url(); ?>"> cours complémentaires</a></h1>
                <span style="display:none">ecoles de musique de geneve</span>


                <?php get_template_part('course_form_small'); ?>


            <?php else : ?>
                <h1><?php the_title(); ?></h1>
            <?php endif; ?>


            <?php if (is_page_template('template-search.php') || is_page_template('template-allcourses.php')) : ?>
                <?php get_template_part('course_form'); ?>
            <?php endif; ?>


            <?php $numbers = get_header_year_numbers(); ?>
            <div id="big_numbers">
                <div id="big_first"><?php echo $numbers[0]; ?></div>
                <div id="big_last"><?php echo $numbers[1]; ?></div>
            </div>
        </header>

        <a href="#" id="menu_button"></a>

        <nav id="navigation_menu" role="navigation">
            <ul><?php chilly_nav('primary-navigation'); ?></ul>
        </nav>