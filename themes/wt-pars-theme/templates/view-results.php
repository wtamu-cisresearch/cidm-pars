<?php
    /*
        Template Name: View Result
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\view-results.html';

    wp_enqueue_style( 'modal' );
    wp_enqueue_script( 'view-results' );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM pars_section ORDER BY year");

    if($_GET['_period']){
        parse_str($_GET['_period'], $output);
        $default = $output['y'] . ' ' . $output['t'];
        $records = $wpdb->get_results( "SELECT
                                            pars_section.section_id,
                                            pars_course.code AS course,
                                            pars_section.section AS section,
                                            pars_section.year AS year,
                                            pars_section.term AS term
                                        FROM
                                            pars_section,
                                            pars_course
                                        WHERE
                                            pars_section.course_id = pars_course.course_id AND pars_section.year = '" . $output['y'] . "' AND pars_section.term = '" . $output['t'] .  "'
                                        ORDER BY
                                            course,
                                            section" );
    }
    else{
        $default = '2010 Spring';
        $records = $wpdb->get_results( "SELECT
                                            pars_section.section_id,
                                            pars_course.code AS course,
                                            pars_section.section AS section,
                                            pars_section.year AS year,
                                            pars_section.term AS term
                                        FROM
                                            pars_section,
                                            pars_course
                                        WHERE
                                            pars_section.course_id = pars_course.course_id AND pars_section.year = 2010 AND pars_section.term = 'Spring'
                                        ORDER BY
                                            course,
                                            section" );
    }

    echo "<form action='' method='get'>
            <select name='_period'>
                <option hidden default>" . $default . "</option>
                " . popList($periods) . "
            </select>
            <button>Submit</button>
        </form>";

    echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Year</th>
                    <th>Term</th>                        
                </tr>
            </thead>
            <tbody>
                " . popTable($records) . "
            <tbody>               
        </table>";

    function popList($periods){
        $option = '';
        foreach($periods as $period){
            $option = $option . '<option value="y=' . $period->year. '&t=' . $period->term . '">' . $period->year . ' ' . $period->term . '</option>';
        }
        return $option;
    }

    function popTable($records){
        $tr = '';
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td><a href='#' id='myBtn' onclick='view(" .  $record->section_id . ")'>" . $record->course . "</a></td>
                            <td>" . $record->section . "</td>
                            <td>" . $record->year . "</td>
                            <td>" . $record->term . "</td> 
                        </tr>";
        }
        return $tr;
    }

    get_footer();
?>