<div class='jacket'>
    <h3 class='headline'>Student Outcome Management</h3>
    <hr class='underline'>
    <button class='btn btn-outline-primary clickable' id='add_record'>Add SO</button>
    <?php

        global $wpdb;

        include get_stylesheet_directory().'\admin-pages\html\so-management.html';
        
        wp_enqueue_style( 'admin' );

        wp_enqueue_script( 'so-management' );
        wp_localize_script( 'so-management', 'settings', array(
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ) );

        if($_GET['_page']){
            $records = getData($wpdb, $_GET['_page'] * 10);
        }
        else{
            $records = getData($wpdb, 0);
        }

        $pages = $wpdb->get_row( "SELECT COUNT(so_id) AS number FROM pars_student_outcome");

        echo (
            "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>SO Code</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        " . popTable($records) . " 
                    <tbody>
                </table>

                <ul class='pagination' name='_page'>
                    " . paginize($pages, 'so-management') . "
                </ul>");

        function popTable($records){
            $tr = "";
            foreach ( $records as $record ) {
                $tr = $tr . "<tr>
                                <td>" . $record->code . "</td>
                                <td>" . $record->description . "</td>
                                <td><a href='#' class='record' data-so_id='" . $record->so_id . "' data-code='" . $record->code . "' data-description='" . $record->description . "'> Edit || Delete </a></td> 
                            </tr>";
            }
            return $tr;
        }

        function getData($wpdb, $x){
            $data = $wpdb->get_results( $wpdb->prepare("SELECT * FROM pars_student_outcome LIMIT %d, 10", $x));
            return $data;
        }
    ?>
</div>