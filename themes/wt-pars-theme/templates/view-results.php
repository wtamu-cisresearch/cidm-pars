<?php
    /*
        Template Name: View Result
    */

    get_header();

    global $wpdb;

    include plugin_dir_path(__FILE__).'html\view-results.html';

    wp_enqueue_style( 'modal' );
    wp_enqueue_script( 'view-results' );

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM assessment_data");

    if($_GET['_period']){
        parse_str($_GET['_period'], $output);
        $records = $wpdb->get_results( 'SELECT * FROM assessment_data WHERE year ="' . $output["y"] . '" AND term ="' . $output["t"] .  '" ORDER BY course, section');
    }
    else{
        $records = $wpdb->get_results( 'SELECT * FROM assessment_data WHERE year = (SELECT MAX(year) as year FROM assessment_data) AND term = "Fall" ORDER BY course, section');
    }

    echo '<form action="" method="get">
            <select name="_period">
            ' . popList($periods) . '
            </select>
            <button>Submit</button>
        </form>';

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
            // $record->modification = urlencode($record->modification);
            // $record->feedback = urlencode($record->feedback);
            // $record->reflection = urlencode($record->reflection);
            // $record->proposed_action = urlencode($record->reflection);
            $tr = $tr . "<tr>
                            <td><a href='#' id='myBtn' onclick='view(" .  json_encode($record) . ")'>" . $record->course . "</a></td>
                            <td>" . $record->section . "</td>
                            <td>" . $record->year . "</td>
                            <td>" . $record->term . "</td> 
                        </tr>";
        }
        return $tr;
    }

    get_footer();
?>