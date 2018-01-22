<?php

    /*
        Template Name: SO (Student Outcomes)
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\so-student-outcomes.html';

    wp_enqueue_style( 'template' );
    wp_enqueue_script( 'so-student-outcomes' );
    wp_localize_script( 'so-student-outcomes', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM pars_section ORDER BY year");

    if($_GET['_period']){
        parse_str($_GET['_period'], $p);
        $default = $p['y'] . ' ' . $p['t'];
        $records = getData($wpdb, $p['y'], $p['t']);
    }
    else{
         $default = '2010 Spring';
         $records = getData($wpdb, '2010', 'Spring');
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
                            <td><a href='#' class='so-record' data-so_id='" . $record->so_id . "' data-year='" . $year . "' data-term='" . $term . "'>" . $record->code . " - " . $record->description . "</td>
                            <td>" . $record->exemplary . "%</td>
                            <td>" . $record->satisfactory . "%</td>
                            <td>" . $record->unsatisfactory . "%</td>
                        </tr>";
        }
        return $tr;
    }

    function getData($wpdb, $x, $y){
        $data = $wpdb->get_results( $wpdb->prepare(
            "SELECT
                pars_student_outcome.so_id,
                pars_student_outcome.code,
                pars_student_outcome.description,
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
                pars_section.section_id = pars_alpha.section_id AND pars_alpha.alpha_id = pars_beta.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.year = '%s' AND pars_section.term = '%s'
            GROUP BY
                pars_student_outcome.code", $x, $y));
        return $data;
    }

    get_footer();
?>
