<?php
    
    global $wpdb;
    
    include get_stylesheet_directory().'\admin-pages\html\assignment-management.html';
    
    wp_enqueue_style( 'admin-modal' );

    wp_enqueue_script( 'assignment-management' );

    if($_GET['_page']){
        $records = $wpdb->get_results( "SELECT
                                            assignment.nid10 AS 'id',
                                            username,
                                            assignment.course,
                                            assignment.assessment_startdate,
                                            assignment.assessment_enddate
                                        FROM
                                            pars_users,
                                            (
                                            SELECT
                                                nid10,
                                                course,
                                                uid,
                                                assessment_startdate,
                                                assessment_enddate
                                            FROM
                                                `assignment`
                                        ) AS assignment
                                        WHERE
                                            userid = assignment.uid
                                        LIMIT " . $_GET['_page'] * 10 . ", 10");
    }
    else{
        $records = $wpdb->get_results( "SELECT
                                            assignment.nid10 AS 'id',
                                            username,
                                            assignment.course,
                                            assignment.assessment_startdate,
                                            assignment.assessment_enddate
                                        FROM
                                            pars_users,
                                            (
                                            SELECT
                                                nid10,
                                                course,
                                                uid,
                                                assessment_startdate,
                                                assessment_enddate
                                            FROM
                                                `assignment`
                                        ) AS assignment
                                        WHERE
                                            userid = assignment.uid
                                        LIMIT 0, 10");
    }

    $pages = $wpdb->get_results( "SELECT COUNT(nid10) AS number FROM assignment");

    echo "
        <div style='padding:20px;'>
            <button class='btn btn-primary' onclick='pop()'>Add Assignment</button>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Course</th>
                        <th>Start FCAR</th>
                        <th>End FCAR</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    " . popTable($records) . "
                <tbody>
            </table> 

            <ul class='pagination' name='_page'>
                " . popIndex($pages) . "
            </ul>
        </div>
    ";

    function popIndex($pages){
        $li = "";

        if(!$_GET['_page'] || $_GET['_page'] < 10){
            $celling = floor($pages[0]->number / 10) < 10? floor($pages[0]->number / 10) : 10;

            for ($i = 0; $i < $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=assignment-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=assignment-management&_page=10') . "'>&#x2192;</a></li>";
            }
        }
        else if(floor($pages[0]->number / 10) >= $_GET['_page']){
            $floor = floor($_GET['_page'] / 10) * 10;
            $celling = ($floor + 9) < floor($pages[0]->number / 10)? ($floor + 9) : floor($pages[0]->number / 10);
            $li = "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=assignment-management&_page=' . ($floor - 1) . '') . "'>&#x2190;</a></li>";
            for ($i = $floor; $i <= $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=assignment-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=assignment-management&_page=' . ($celling + 1) . '') . "'>&#x2192;</a></li>";
            }
        }
        return $li;
    }

    function activate($i){
        if(!$_GET['_page'] && $i == 0){
            return 'active';
        }
        else if($_GET['_page'] == $i){
            return 'active';
        }
    }

    function popTable($records){
        $tr = "";
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td>" . $record->username . "</td>
                            <td>" . $record->course . "</td>
                            <td>" . $record->assessment_startdate . "</td>
                            <td>" . $record->assessment_enddate . "</td>
                            <td><a href='#' id='myBtn' onclick='discard(" . $record->id . ")'> Delete </a></td> 
                        </tr>";
        }
        return $tr;
    }
?>