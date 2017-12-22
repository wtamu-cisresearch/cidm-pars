<?php

    /*
        Template Name: SO (Student Outcomes)
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\so-student-outcomes.html';

    wp_enqueue_style( 'modal' );
    wp_enqueue_script( 'so-student-outcomes' );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM pars_section ORDER BY year");

    if($_GET['_period']){
        parse_str($_GET['_period'], $p);
        $default = $p['y'] . ' ' . $p['t'];
        $records = $wpdb->get_results( " SELECT
                                            pars_student_outcome.code AS sonumber,
                                            pars_student_outcome.description sodes,
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
                                            pars_section.section_id = pars_alpha.section_id AND pars_alpha.alpha_id = pars_beta.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.year = '" . $p['y'] . "' AND pars_section.term = '" . $p['t'] . "'
                                        GROUP BY
                                            pars_student_outcome.code
                                    ");
    }
    else{
         $default = '2010 Spring';
         $records = $wpdb->get_results( "SELECT
                                            pars_student_outcome.code AS sonumber,
                                            pars_student_outcome.description sodes,
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
                                            pars_section.section_id = pars_alpha.section_id AND pars_alpha.alpha_id = pars_beta.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.year = 2010 AND pars_section.term = 'Spring'
                                        GROUP BY
                                            pars_student_outcome.code
                                        ");
    }

    echo "
        <form action='' method='get'>
            <select name='_period'>
                <option hidden default>" . $default . "</option>
                " . popuList($periods) . "
            </select>
            <button>Submit</button>
        </form>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <td>Student Outcome</td>
                    <td>Exemplary</td>
                    <td>Satisfactory</td>
                    <td>Unsatisfactory</td>
                </tr>
            </thead>
            <tbody>
                " . popTable($records, $p) . "
            <tbody>               
        </table>";

    function popuList($periods){        
        $option = '';
        foreach($periods as $period){
            $option = $option . '<option value="y=' . $period->year. '&t=' . $period->term . '">' . $period->year . ' ' . $period->term . '</option>';
        }
        return $option;
    }

    function popTable($records, $p){
        $tr = '';
        if($p){
            $year = $p['y'];
            $term = $p['t'];
        }
        else{
            $year = '2010';
            $term = 'Spring';
        }
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td><a href='#' id='myBtn' onclick='cloReport(" . $record->soid . ", `" . $year . "`, `" . $term . "`)'>" . $record->sonumber . " - " . $record->sodes . "</td>
                            <td>" . $record->exemplary . "%</td>
                            <td>" . $record->satisfactory . "%</td>
                            <td>" . $record->unsatisfactory . "%</td>
                        </tr>";
        }
        return $tr;
    }

    get_footer();

?>