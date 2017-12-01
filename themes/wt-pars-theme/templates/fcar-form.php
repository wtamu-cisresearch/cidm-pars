<?php
    /*
        Template Name: FCAR Form
    */

    get_header();

    global $wpdb;
    
    include plugin_dir_path(__FILE__).'html\fcar-form.html';

    wp_enqueue_style( 'modal' );
    wp_enqueue_script( 'fcar-form' );

    $records = $wpdb->get_results( "SELECT course, section, year, term, assessment_startdate, assessment_enddate FROM assignment WHERE uid = " .  (get_current_user_id() + 110) . " "); /*'" . date('Y') . "'");*/

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

    function popTable($records){
        $tr = '';
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td><a href='#' class id='myBtn' onclick='form( `$record->year`, `$record->term`, `$record->course`, `$record->section`)'>" . $record->course . "</a></td>
                            <td>" . $record->section . "</td>
                            <td>" . $record->term . "</td>
                            <td>" . $record->year . "</td> 
                        </tr>";
        }
        return $tr;
    }

    get_footer();
?>