<?php

    global $wpdb;

    include get_stylesheet_directory().'\admin-pages\html\peo-management.html';

    wp_enqueue_style( 'admin-modal' );

    wp_enqueue_script( 'peo-management' );
    wp_localize_script( 'peo-management', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    if($_GET['_page']){
        $records = $wpdb->get_results( "SELECT * FROM pars_program_educational_objective LIMIT " . $_GET['_page'] * 10 . ", 10");
    }
    else{
        $records = $wpdb->get_results( "SELECT * FROM pars_program_educational_objective LIMIT 0, 10");
    }
    
    $pages = $wpdb->get_results( "SELECT COUNT(peo_id) AS number FROM pars_program_educational_objective");

    echo "
        <div style='padding:20px;'>
            <button class='btn btn-primary' id='add_record'>Add PEO</button>
            <table class='table table-striped'> 
                <thead>
                    <tr>
                        <th>PEO Code</th>
                        <th>Description</th>
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
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=peo-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=peo-management&_page=10') . "'>&#x2192;</a></li>";
            }
        }
        else if(floor($pages[0]->number / 10) >= $_GET['_page']){
            $floor = floor($_GET['_page'] / 10) * 10;
            $celling = ($floor + 9) < floor($pages[0]->number / 10)? ($floor + 9) : floor($pages[0]->number / 10);
            $li = "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=peo-management&_page=' . ($floor - 1) . '') . "'>&#x2190;</a></li>";
            for ($i = $floor; $i <= $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=peo-management&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=peo-management&_page=' . ($celling + 1) . '') . "'>&#x2192;</a></li>";
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
        $tr = '';
        foreach ( $records as $record ) {
            $tr = $tr . "<tr>
                            <td>" . $record->code . "</td>
                            <td>" . $record->description . "</td>
                            <td><a href='#' class='record' data-peo_id='" . $record->peo_id . "' data-code='" . $record->code . "' data-description='" . $record->description . "'> Edit || Delete </a></td> 
                        </tr>";
        }
        return $tr;
    }
?>