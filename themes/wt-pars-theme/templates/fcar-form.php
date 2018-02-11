<?php 
    /*
        Template Name: FCAR Form
    */

    get_header();

    include plugin_dir_path(__FILE__).'html\fcar-form.html'; 
?>
<div id="main-view">
    <?php
        
        global $wpdb;

        wp_enqueue_style( 'template' );
        wp_enqueue_script( 'fcar-form' );
        wp_localize_script( 'fcar-form', 'settings', array(
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ) );

        echo ("<table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Course Description</th>
                        <th>Section</th>
                        <th>Year</th>
                        <th>Term</th>                        
                    </tr>
                </thead>
                <tbody>
                    " . popTable($wpdb) . "
                </tbody>               
            </table>");

            echo "<script>console.log(".get_current_user_id().");</script>";

        function popTable($wpdb){

            $records = $wpdb->get_results( $wpdb->prepare(
                "SELECT
                    pars_course.code AS course_code,
                    pars_course.name AS course_name,
                    pars_course.description AS course_description,
                    pars_section.section_id,
                    pars_section.number AS section_number,
                    pars_section.year AS section_year,
                    pars_section.term AS section_term
                FROM
                    pars_course,
                    pars_section
                WHERE
                    pars_course.course_id = pars_section.course_id AND pars_section.enable = 0 AND pars_section.instructor_id = %d;", get_current_user_id()));

            $tr = "";

            foreach ( $records as $record ) {    
                $tr = $tr . "<tr>
                                <td><a href='#' class='record' data-course_code='" . $record->course_code . "' data-course_name='" . $record->course_name . "' data-course_description='" . $record->course_description . "' data-section_id='" . $record->section_id . "' data-section_number='" . $record->section_number . "' data-section_year='" . $record->section_year . "' data-section_term='" . $record->section_term . "'>" . $record->course_code . "</a></td>
                                <td>" . $record->course_name . "</td>
                                <td>" . $record->course_description . "</td>
                                <td>" . $record->section_number . "</td>
                                <td>" . $record->section_year . "</td>
                                <td>" . $record->section_term . "</td> 
                            </tr>";
            }
            return $tr;
        }

        get_footer();
    ?>
</div>