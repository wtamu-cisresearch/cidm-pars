<?php

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wt-pars-theme/v2', '/viewresults/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_viewresults',
        ) );
    } );

    function get_viewresults( $data ) {
        global $wpdb;
        $record = $wpdb->get_results( "SELECT
                                        pars_course.code AS course_code,
                                        pars_course.description AS course_description,
                                        pars_section.instructor,
                                        pars_section.section,
                                        pars_section.term,
                                        pars_section.year,
                                        pars_section.modification,
                                        pars_section.feedback,
                                        pars_section.reflection,
                                        pars_section.proposed_action,
                                        pars_section.a,
                                        pars_section.b,
                                        pars_section.c,
                                        pars_section.d,
                                        pars_section.f,
                                        pars_section.x,
                                        pars_course_learning_outcome.code AS clo_code,
                                        pars_course_learning_outcome.description AS clo_description,
                                        pars_measure.type,
                                        pars_measure.exemplary,
                                        pars_measure.good,
                                        pars_measure.satisfactory,
                                        pars_measure.poor,
                                        pars_measure.unsatisfactory,
                                        pars_measure.comment,
                                        pars_student_outcome.code AS so_code,
                                        pars_student_outcome.description AS so_description
                                    FROM
                                        pars_section,
                                        pars_course,
                                        pars_alpha,
                                        pars_course_learning_outcome,
                                        pars_measure,
                                        pars_beta,
                                        pars_student_outcome
                                    WHERE
                                        pars_section.course_id = pars_course.course_id AND pars_section.section_id = " . $data['id']. " AND pars_alpha.section_id = pars_section.section_id AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_beta.alpha_id = pars_alpha.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id");  
                                    
        return $record;
    }

?>