<?php

    include get_stylesheet_directory().'\endpoints\endpoints.php';

    wp_register_style( 'modal', get_stylesheet_directory_uri().'/css/modal.css' );
    wp_register_style( 'admin-modal', get_stylesheet_directory_uri().'/css/admin-modal.css' );   

    // bootstrap
    wp_register_script( 'bootstrap', get_stylesheet_directory_uri().'/bootstrap-4.0.0-beta.2-dist/js/bootstrap.js' );
    wp_register_style( 'bootstrap', get_stylesheet_directory_uri().'/bootstrap-4.0.0-beta.2-dist/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_script( 'bootstrap' );

    // For admin-pages
    wp_register_script( 'course-management', get_stylesheet_directory_uri().'/admin-pages/js/course-management.js' );
    wp_register_script( 'clo-management', get_stylesheet_directory_uri().'/admin-pages/js/clo-management.js' );
    wp_register_script( 'peo-management', get_stylesheet_directory_uri().'/admin-pages/js/peo-management.js' );
    wp_register_script( 'so-management', get_stylesheet_directory_uri().'/admin-pages/js/so-management.js' );
    wp_register_script( 'carry-forward', get_stylesheet_directory_uri().'/admin-pages/js/carry-forward.js' );
    wp_register_script( 'assignment-management', get_stylesheet_directory_uri().'/admin-pages/js/assignment-management.js' );
    wp_register_script( 'so-to-clo-mapping', get_stylesheet_directory_uri().'/admin-pages/js/so-to-clo-mapping.js' );
    wp_register_script( 'so-to-peo-mapping', get_stylesheet_directory_uri().'/admin-pages/js/so-to-peo-mapping.js' );

    // For templates
    wp_register_script( 'view-results', get_stylesheet_directory_uri().'/templates/js/view-results.js' );
    wp_register_script( 'so-student-outcomes', get_stylesheet_directory_uri().'/templates/js/so-student-outcomes.js' );
    wp_register_script( 'peo-program-educational-objective', get_stylesheet_directory_uri().'/templates/js/peo-program-educational-objective.js' );
    wp_register_script( 'fcar-form', get_stylesheet_directory_uri().'/templates/js/fcar-form.js' );

    add_action('admin_menu', 'adminPages');
    
    function adminPages() {

        add_menu_page('PARS Management', 'PARS Management', 'manage_options', 'pars-management', 'parsManagement', '', 26);
        add_submenu_page('pars-management', 'Course Management', 'Course Management', 'manage_options', 'course-management', 'courseManagement');
        add_submenu_page('pars-management', 'CLO Management', 'CLO Management', 'manage_options', 'clo-management', 'cloManagement');
        add_submenu_page('pars-management', 'PEO Management', 'PEO Management', 'manage_options', 'peo-management', 'peoManagement');
        add_submenu_page('pars-management', 'SO to CLO Mapping', 'SO to CLO Mapping', 'manage_options', 'so-to-clo-mapping', 'soToCloMapping');
        add_submenu_page('pars-management', 'SO to PEO Mapping', 'SO to PEO Mapping', 'manage_options', 'so-to-peo-mapping', 'soToPeoMapping');
        add_submenu_page('pars-management', 'SO Management', 'SO Management', 'manage_options', 'so-management', 'soManagement');
        add_submenu_page('pars-management', 'Carry Forward', 'Carry Forward', 'manage_options', 'carry-forward', 'carryForward');
        add_submenu_page('pars-management', 'Assignment Management', 'Assignment Management', 'manage_options', 'assignment-management', 'assignmentManagement');

    }

    function parsManagement(){
        include get_stylesheet_directory().'\admin-pages\pars-management.php';
    }

    function courseManagement(){
        include get_stylesheet_directory().'\admin-pages\course-management.php';
    }

    function cloManagement(){
        include get_stylesheet_directory().'\admin-pages\clo-management.php';
    }

    function peoManagement(){
        include get_stylesheet_directory().'\admin-pages\peo-management.php';
    }

    function soToCloMapping(){
        include get_stylesheet_directory().'\admin-pages\so-to-clo-mapping.php';
    }

    function soToPeoMapping(){
        include get_stylesheet_directory().'\admin-pages\so-to-peo-mapping.php';
    }

    function soManagement(){
        include get_stylesheet_directory().'\admin-pages\so-management.php';
    }

    function carryForward(){
        include get_stylesheet_directory().'\admin-pages\carry-forward.php';
    }

    function assignmentManagement(){
        include get_stylesheet_directory().'\admin-pages\assignment-management.php';
    }
?>