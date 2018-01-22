<?php

    include get_stylesheet_directory().'\endpoints\endpoints.php';

    wp_register_style( 'template', get_stylesheet_directory_uri().'/css/template.css' );
    wp_register_style( 'admin', get_stylesheet_directory_uri().'/css/admin.css' );

    // Bootstrap
    wp_register_script( 'bootstrap', get_stylesheet_directory_uri().'/bootstrap-4.0.0-beta.2-dist/js/bootstrap.js' );
    wp_register_style( 'bootstrap', get_stylesheet_directory_uri().'/bootstrap-4.0.0-beta.2-dist/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_script( 'bootstrap' );

    // For admin-pages
    wp_register_script( 'course-management', get_stylesheet_directory_uri().'/admin-pages/js/course-management.js' );
    wp_register_script( 'clo-management', get_stylesheet_directory_uri().'/admin-pages/js/clo-management.js' );
    wp_register_script( 'peo-management', get_stylesheet_directory_uri().'/admin-pages/js/peo-management.js' );
    wp_register_script( 'so-management', get_stylesheet_directory_uri().'/admin-pages/js/so-management.js' );
    wp_register_script( 'mapping-canvas', get_stylesheet_directory_uri().'/admin-pages/js/mapping-canvas.js' );
    wp_register_script( 'section-management', get_stylesheet_directory_uri().'/admin-pages/js/section-management.js' );

    // For templates
    wp_register_script( 'view-fcar', get_stylesheet_directory_uri().'/templates/js/view-fcar.js' );
    wp_register_script( 'so-student-outcomes', get_stylesheet_directory_uri().'/templates/js/so-student-outcomes.js' );
    wp_register_script( 'peo-program-educational-objective', get_stylesheet_directory_uri().'/templates/js/peo-program-educational-objective.js' );
    wp_register_script( 'fcar-form', get_stylesheet_directory_uri().'/templates/js/fcar-form.js' );

    wp_register_script( 'test', get_stylesheet_directory_uri().'/test.js' );

    add_action('after_switch_theme', 'initTheme', 10, 2);
    add_action('admin_menu', 'adminPages');

    function initTheme($oldtheme_title, $oldtheme){
        global $wpdb;

        try{
            $pars_section = (checkEngine('pars_section')) ? $wpdb->query("ALTER TABLE pars_section ENGINE=InnoDB;") : true;
            $pars_attachment = (checkEngine('pars_attachment')) ? $wpdb->query("ALTER TABLE pars_attachment ENGINE=InnoDB;") : true;
            $pars_course = (checkEngine('pars_course')) ? $wpdb->query("ALTER TABLE pars_course ENGINE=InnoDB;") : true;
            $pars_alpha = (checkEngine('pars_alpha')) ? $wpdb->query("ALTER TABLE pars_alpha ENGINE=InnoDB;") : true;
            $pars_course_learning_outcome = (checkEngine('pars_course_learning_outcome')) ? $wpdb->query("ALTER TABLE pars_course_learning_outcome ENGINE=InnoDB;") : true;
            $pars_beta = (checkEngine('pars_beta')) ? $wpdb->query("ALTER TABLE pars_beta ENGINE=InnoDB;") : true;
            $pars_program_educational_objective = (checkEngine('pars_program_educational_objective')) ? $wpdb->query("ALTER TABLE pars_program_educational_objective ENGINE=InnoDB;") : true;
            $pars_student_outcome = (checkEngine('pars_student_outcome')) ? $wpdb->query("ALTER TABLE pars_student_outcome ENGINE=InnoDB;") : true;
            $pars_measure = (checkEngine('pars_measure')) ? $wpdb->query("ALTER TABLE pars_measure ENGINE=InnoDB;") : true;

            if ($pars_section === false){
                throw new Exception('Issue setting pars_section db table to InnoDB. Table may not exist');
            }
            if ($pars_attachment === false){
                throw new Exception('Issue setting pars_attachment db table to InnoDB. Table may not exist');
            }
            if ($pars_course === false){
                throw new Exception('Issue setting pars_course db table to InnoDB. Table may not exist');
            }
            if ($pars_alpha === false){
                throw new Exception('Issue setting pars_alpha db table to InnoDB. Table may not exist');
            }
            if ($pars_course_learning_outcome === false){
                throw new Exception('Issue setting pars_course_learning_outcome db table to InnoDB. Table may not exist');
            }
            if ($pars_beta === false){
                throw new Exception('Issue setting pars_beta to InnoDB. Table may not exist');
            }
            if ($pars_program_educational_objective === false){
                throw new Exception('Issue setting pars_program_educational_objective db table to InnoDB. Table may not exist');
            }
            if ($pars_student_outcome === false){
                throw new Exception('Issue setting pars_student_outcome db table to InnoDB. Table may not exist');
            }
            if ($pars_measure === false){
                throw new Exception('Issue setting pars_measure db table to InnoDB. Table may not exist');
            }
        }
        catch (Exception $e){
            echo ("<script type='text/javascript'>console.log('" . $e->getMessage() . ". You have been switched back to the theme " . $oldtheme_title . "');</script>");
            add_action('admin_notices', 'activationFailure');
            switch_theme($oldtheme->stylesheet);
        }
    }

    function activationFailure(){
        echo ("<div class='update-nag'>Exception cought. Refer to the console logs for more information.</div>");
    }

    function checkEngine($table){
        global $wpdb;

        $result = $wpdb->query($wpdb->prepare(
            "SELECT ENGINE
            FROM
                information_schema.TABLES
            WHERE 
                TABLE_NAME = '%s' AND TABLE_SCHEMA = '%s'", $table, $wpdb->dbname));

        $result = ($result != 'InnoDB') ? true : false;

        return $result;
    }
    
    function adminPages() {
        add_menu_page('PARS', 'PARS', 'manage_options', 'pars', 'parsMain', 'dashicons-welcome-learn-more', 26);
        add_submenu_page('pars', 'Section Management', 'Section Management', 'manage_options', 'section-management', 'sectionManagement');
        add_submenu_page('pars', 'Mapping Canvas', 'Mapping Canvas', 'manage_options', 'mapping-canvas', 'mappingCanvas');
        add_submenu_page('pars', 'Course Management', 'Course Management', 'manage_options', 'course-management', 'courseManagement');
        add_submenu_page('pars', 'CLO Management', 'CLO Management', 'manage_options', 'clo-management', 'cloManagement');
        add_submenu_page('pars', 'SO Management', 'SO Management', 'manage_options', 'so-management', 'soManagement');
        add_submenu_page('pars', 'PEO Management', 'PEO Management', 'manage_options', 'peo-management', 'peoManagement');        
    }

    function parsMain(){
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

    function soManagement(){
        include get_stylesheet_directory().'\admin-pages\so-management.php';
    }

    function mappingCanvas(){
        include get_stylesheet_directory().'\admin-pages\mapping-canvas.php';
    }

    function sectionManagement(){
        include get_stylesheet_directory().'\admin-pages\section-management.php';
    }

    // remember to solve the issue with pagination.
    function paginize($pages){
        $li = "";

        if(!$_GET['_page'] || $_GET['_page'] < 10){
            $celling = floor($pages[0]->number / 10) < 10? floor($pages[0]->number / 10) : 10;

            for ($i = 0; $i < $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=section-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=section-management&_page=10') . "'>&#x2192;</a></li>";
            }
        }
        else if(floor($pages[0]->number / 10) >= $_GET['_page']){
            $floor = floor($_GET['_page'] / 10) * 10;
            $celling = ($floor + 9) < floor($pages[0]->number / 10)? ($floor + 9) : floor($pages[0]->number / 10);
            $li = "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=section-management&_page=' . ($floor - 1) . '') . "'>&#x2190;</a></li>";
            for ($i = $floor; $i <= $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=section-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=section-management&_page=' . ($celling + 1) . '') . "'>&#x2192;</a></li>";
            }
        }
        return $li;
    }

    function activate($i){
        if(!$_GET['_page'] && $i == 0){
            return 'active';
        }
        else if($_GET['_page'] == $i){
            return 'active';
        }
    }
?>