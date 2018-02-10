<?php
    /*
        Template Name: View FCAR
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\view-fcar.html';

    wp_enqueue_style( 'template' );
    wp_enqueue_script( 'view-fcar' );
    wp_localize_script( 'view-fcar', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM pars_section ORDER BY year");

    if($_GET['_period']){
        parse_str($_GET['_period'], $output);
        $default = $output['y'] . ' ' . $output['t'];
        $records = getData($wpdb, $output['y'], $output['t']);
    }
    else{
        $default = '2010 Spring';
        $records = getData($wpdb, '2010', 'Spring');
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
            </tbody>               
        </table>";

    function popList($periods){
        $option = '';
        foreach($periods as $period){
            $option = $option . '<option value="y=' . $period->year. '&t=' . $period->term . '">' . $period->year . ' ' . $period->term . '</option>';
        }
        return $option;
    }

    function popTable($records){
        $tr = "";
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td><a href='#' class='record' data-section_id='" . $record->section_id . "'>" . $record->course . "</a></td>
                            <td>" . $record->number . "</td>
                            <td>" . $record->year . "</td>
                            <td>" . $record->term . "</td> 
                        </tr>";
        }
        return $tr;
    }

    function getData($wpdb, $x, $y){
        $data = $wpdb->get_results( $wpdb->prepare(
            "SELECT
                pars_section.section_id,
                pars_course.code AS course,
                pars_section.number,
                pars_section.year AS year,
                pars_section.term AS term
            FROM
                pars_section,
                pars_course
            WHERE
                pars_section.course_id = pars_course.course_id AND pars_section.year = '%s' AND pars_section.term = '%s'
            ORDER BY
                course,
                number", $x, $y));
        return $data;
    }

    get_footer();
?>