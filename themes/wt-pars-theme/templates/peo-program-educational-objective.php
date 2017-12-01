<?php

    /*
        Template Name: PEO (Program Educational Objective)
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\peo-program-educational-objective.html';

    wp_enqueue_style( 'modal' );
    wp_enqueue_script( 'peo-program-educational-objective' );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM ploclomap");

    if($_GET['_period']){
        parse_str($_GET['_period'], $p);
        $records = $wpdb->get_results( "
                                        SELECT
                                        program_education_objective.nid AS 'peoid',
                                        program_education_objective.peo AS 'peonumber',
                                        program_education_objective.peo_description AS 'peodes',
                                        clo_measures.PloNo AS 'soid',
                                        ROUND(
                                            (
                                                SUM(clo_measures.Epercentage) /(
                                                    SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                ) * 100
                                            ),
                                            2
                                        ) AS 'exemplary',
                                        ROUND(
                                            (
                                                SUM(clo_measures.Spercentage) /(
                                                    SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                ) * 100
                                            ),
                                            2
                                        ) AS 'satisfactory',
                                        ROUND(
                                            (
                                                SUM(clo_measures.Upercentage) /(
                                                    SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                ) * 100
                                            ),
                                            2
                                        ) AS 'unsatisfactory'
                                        FROM
                                        clo_measures
                                        INNER JOIN program_education_objective WHERE clo_measures.peo = program_education_objective.nid AND clo_measures.year = '" . $p['y'] . "' AND clo_measures.term = '" . $p['t'] . "'
                                        GROUP BY
                                        peonumber
                                    ");
    }
    else{
         $records = $wpdb->get_results( "
                                            SELECT
                                            program_education_objective.nid AS 'peoid',
                                            program_education_objective.peo AS 'peonumber',
                                            program_education_objective.peo_description AS 'peodes',
                                            clo_measures.PloNo AS 'soid',
                                            ROUND(
                                                (
                                                    SUM(clo_measures.Epercentage) /(
                                                        SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                    ) * 100
                                                ),
                                                2
                                            ) AS 'exemplary',
                                            ROUND(
                                                (
                                                    SUM(clo_measures.Spercentage) /(
                                                        SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                    ) * 100
                                                ),
                                                2
                                            ) AS 'satisfactory',
                                            ROUND(
                                                (
                                                    SUM(clo_measures.Upercentage) /(
                                                        SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage)
                                                    ) * 100
                                                ),
                                                2
                                            ) AS 'unsatisfactory'
                                            FROM
                                            clo_measures
                                            INNER JOIN program_education_objective WHERE clo_measures.peo = program_education_objective.nid AND clo_measures.year = '2010' AND clo_measures.term = 'Spring'
                                            GROUP BY
                                            peonumber
                                        ");
    }

    echo '<form action="" method="get">
            <select name="_period">
                ' . popuList($periods) . '
            </select>
            <button>Submit</button>
        </form>';

    echo '<table class="table table-striped">
            <thead>
                <tr>
                    <td>Program Educational Learning Objective</td>
                    <td>Exemplary</td>
                    <td>Satisfactory</td>
                    <td>Unsatisfactory</td>
                </tr>
            </thead>
            <tbody>
                ' . popTable($records, $p) . '
            <tbody>               
        </table>';

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
                            <td><a href='#' id='myBtn' onclick='cloReport(" . $record->peoid . ", `" . $year . "`, `" . $term . "`)'>" . $record->peonumber . " - " . $record->peodes . "</td>
                            <td>" . $record->exemplary . "%</td>
                            <td>" . $record->satisfactory . "%</td>
                            <td>" . $record->unsatisfactory . "%</td>
                        </tr>";
        }
        return $tr;
    }

    get_footer();
?>