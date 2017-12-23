<?php

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wt-pars-theme/v2', '/viewresults/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_viewresults',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/studentoutcomes/(?P<so_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_studentOutcomes',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/programeducationalobjective/(?P<peo_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_programEducationalObjective',
        ) );
    } );

    function get_viewresults( $data ) {
        global $wpdb;
        $data = $wpdb->get_results( "SELECT
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
                                    
        return $data;
    }

    function get_studentOutcomes( $data ) {
        global $wpdb;
        $data = $wpdb->get_results("SELECT
                                        pars_course_learning_outcome.code AS clo_code,
                                        pars_course_learning_outcome.description clo_description,
                                        pars_course.code course_code,
                                        ROUND(
                                            (
                                                pars_measure.exemplary /(
                                                    pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                                                ) * 100
                                            ),
                                            2
                                        ) AS exemplary,
                                        ROUND(
                                            (
                                                pars_measure.good /(
                                                    pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                                                ) * 100
                                            ),
                                            2
                                        ) AS good,
                                        ROUND(
                                            (
                                                pars_measure.satisfactory /(
                                                    pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                                                ) * 100
                                            ),
                                            2
                                        ) AS satisfactory,
                                        ROUND(
                                            (
                                                pars_measure.poor /(
                                                    pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                                                ) * 100
                                            ),
                                            2
                                        ) AS poor,
                                        ROUND(
                                            (
                                                pars_measure.unsatisfactory /(
                                                    pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                                                ) * 100
                                            ),
                                            2
                                        ) AS unsatisfactory
                                    FROM
                                        pars_section,
                                        pars_course,
                                        pars_course_learning_outcome,
                                        pars_alpha,
                                        pars_measure,
                                        pars_beta
                                    WHERE
                                        pars_section.course_id = pars_course.course_id AND pars_alpha.section_id = pars_section.section_id AND pars_course_learning_outcome.clo_id = pars_alpha.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_beta.alpha_id = pars_alpha.alpha_id AND pars_section.term = '" . $data['term']. "' AND pars_section.year = " . $data['year']. " AND pars_beta.so_id = " . $data['so_id']. "");
                                    
        return $data;
    }

    function get_programEducationalObjective( $data ) {
        global $wpdb;
        $data = $wpdb->get_results("SELECT
                                        pars_student_outcome.so_id,
                                        pars_student_outcome.code AS sonumber,
                                        pars_student_outcome.description AS sodes,
                                        ROUND(
                                            (
                                                SUM(pars_measure.exemplary) /(
                                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                                ) * 100
                                            ),
                                            2
                                        ) AS exemplary,
                                        ROUND(
                                            (
                                                SUM(pars_measure.good) /(
                                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                                ) * 100
                                            ),
                                            2
                                        ) AS good,
                                        ROUND(
                                            (
                                                SUM(pars_measure.satisfactory) /(
                                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                                ) * 100
                                            ),
                                            2
                                        ) AS satisfactory,
                                        ROUND(
                                            (
                                                SUM(pars_measure.poor) /(
                                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                                ) * 100
                                            ),
                                            2
                                        ) AS poor,
                                        ROUND(
                                            (
                                                SUM(pars_measure.unsatisfactory) /(
                                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                                ) * 100
                                            ),
                                            2
                                        ) AS unsatisfactory
                                    FROM
                                        pars_section,
                                        pars_measure,
                                        pars_alpha,
                                        pars_beta,
                                        pars_student_outcome
                                    WHERE
                                        pars_section.section_id = pars_alpha.section_id AND pars_alpha.alpha_id = pars_beta.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.year = " . $data['year']. " AND pars_section.term = '" . $data['term']. "' AND pars_beta.peo_id = " . $data['peo_id']. "
                                    GROUP BY
                                        pars_student_outcome.code ");
        return $data;
    }

?>