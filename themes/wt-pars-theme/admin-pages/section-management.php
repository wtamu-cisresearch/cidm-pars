<?php
    
    global $wpdb;
    
    include get_stylesheet_directory().'\admin-pages\html\section-management.html';

    wp_enqueue_style( 'admin' );
    
    wp_enqueue_script( 'section-management' );
    wp_localize_script( 'section-management', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    if($_GET['_page']){
        $records = getData($wpdb, $_GET['_page'] * 10);
    }
    else{
        $records = getData($wpdb, 0);
    }

    $pages = $wpdb->get_results( "SELECT COUNT(section_id) AS number FROM pars_section");

    echo ("
        <div id='main-view' class='jacket'>
            <h3 class='headline'>Section Management</h3>
            <hr class='underline'>
            <button class='btn btn-outline-primary clickable' id='create-record'>Create Section</button>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Pending</th>
                    </tr>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Section Number</th>
                        <th>Instructor</th>
                        <th>Year</th>
                        <th>Term</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    " . popTable($records) . "
                <tbody>
            </table> 

            <ul class='pagination' name='_page'>
                " . paginize($pages) . "
            </ul>
        </div>
    ");

    function popTable($records){
        $tr = '';
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td>" . $record->course_code . "</td>
                            <td>" . $record->course_name . "</td>
                            <td>" . $record->section_number . "</td>
                            <td>" . $record->instructor . "</td>
                            <td>" . $record->year . "</td>
                            <td>" . $record->term . "</td>
                            <td><a href='#' class='record' data-course_id='" . $record->course_id . "' data-code='" . $record->code . "' data-name='" . $record->name . "' data-description='" . $record->description . "' > Edit || Delete </a></td> 
                        </tr>";
        }
        return $tr;
    }

    function getData($wpdb, $x){
        $data = $wpdb->get_results( $wpdb->prepare(
            "SELECT
                pars_course.code AS course_code,
                pars_course.name AS course_name,
                pars_section.number AS section_number,
                pars_section.instructor,
                pars_section.year,
                pars_section.term
            FROM
                pars_section,
                pars_course
            WHERE
                pars_section.course_id = pars_course.course_id
            LIMIT %d, 10", $x));
        return $data;
    }
?>