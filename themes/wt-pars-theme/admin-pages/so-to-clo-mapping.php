<?php

    global $wpdb;

    include get_stylesheet_directory().'\admin-pages\html\so-to-clo-mapping.html';

    wp_enqueue_style( 'admin-modal' );

    wp_enqueue_script( 'so-to-clo-mapping' );

    if($_GET['_period'] && $_GET['_page']){
        parse_str($_GET['_period'], $p);
        $records = $wpdb->get_results( 
                                        "SELECT
                                            child.nid3,
                                            child.PloNo,
                                            child.course,
                                            clo.section,
                                            child.term,
                                            child.year,
                                            child.CloNo
                                        FROM
                                            clo
                                        INNER JOIN(
                                            SELECT
                                                ploclomap.nid3, 
                                                plo.PloNo,
                                                ploclomap.term,
                                                ploclomap.year,
                                                ploclomap.CloNo,
                                                ploclomap.course
                                            FROM
                                                ploclomap
                                            INNER JOIN plo ON ploclomap.PloNo = plo.nid11
                                        ) AS child
                                        ON
                                            child.CloNo = clo.CloNo
                                        WHERE
                                            child.year = '" . $p['y'] . "' AND child.term = '" . $p['t'] .  "' 
                                        LIMIT " . $_GET['_page'] * 10 . ", 10
                                    ");
        
        $pages = $wpdb->get_results( "SELECT COUNT(nid3) AS number FROM ploclomap WHERE year = '" . $p['y'] . "' AND term = '" . $p['t'] .  "'");
    }
    elseif($_GET['_period']){
        parse_str($_GET['_period'], $p);
        $records = $wpdb->get_results(
                                        "SELECT
                                            child.nid3,
                                            ploclomap.nid3,
                                            child.PloNo,
                                            child.course,
                                            clo.section,
                                            child.term,
                                            child.year,
                                            child.CloNo 
                                        FROM
                                            clo
                                        INNER JOIN(
                                            SELECT
                                                ploclomap.nid3, 
                                                plo.PloNo,
                                                ploclomap.term,
                                                ploclomap.year,
                                                ploclomap.CloNo,
                                                ploclomap.course
                                            FROM
                                                ploclomap
                                            INNER JOIN plo ON ploclomap.PloNo = plo.nid11
                                        ) AS child
                                        ON
                                            child.CloNo = clo.CloNo
                                        WHERE
                                            child.year = '" . $p['y'] . "' AND child.term = '" . $p['t'] .  "'
                                        LIMIT 0, 10
                                    ");

        $pages = $wpdb->get_results( "SELECT COUNT(nid3) AS number FROM ploclomap WHERE year = '" . $p['y'] . "' AND term = '" . $p['t'] .  "'");
    }
    elseif($_GET['_page']){
        $records = $wpdb->get_results( 'SELECT child.nid3, child.PloNo, child.course, clo.section, child.term, child.year, child.CloNo FROM clo INNER JOIN ( SELECT ploclomap.nid3, plo.PloNo, ploclomap.term, ploclomap.year, ploclomap.CloNo, ploclomap.course FROM ploclomap INNER JOIN plo ON ploclomap.PloNo = plo.nid11 ) AS child ON child.CloNo = clo.CloNo LIMIT ' . $_GET['_page'] * 10 . ', 10');
        $pages = $wpdb->get_results( "SELECT COUNT(nid3) AS number FROM ploclomap");
    }
    else{
        $records = $wpdb->get_results( 'SELECT child.nid3, child.PloNo, child.course, clo.section, child.term, child.year, child.CloNo FROM clo INNER JOIN ( SELECT ploclomap.nid3, plo.PloNo, ploclomap.term, ploclomap.year, ploclomap.CloNo, ploclomap.course FROM ploclomap INNER JOIN plo ON ploclomap.PloNo = plo.nid11 ) AS child ON child.CloNo = clo.CloNo LIMIT 0, 10');
        $pages = $wpdb->get_results( "SELECT COUNT(nid3) AS number FROM ploclomap");
    }

    $periods = $wpdb->get_results( "SELECT DISTINCT year, term FROM ploclomap");

    echo "
        <div style='padding:20px;'>
            <button class='btn btn-primary' onclick='pop()'>Add Course</button>
            <form action='' method='get'>
                <input hidden name='page' value='so-to-clo-mapping'>
                <button class='btn btn-default' style='width:100px;'>Submit</button>
                <select class='form-control' name='_period'>
                    <option default> - Select Period - </option>
                    " . popuList($periods) . "
                </select>
            </form>

            <table class='table table-striped'>
                <tbody>
                    " . popTable($records) . "
                <tbody>               
            </table>

            <ul class='pagination' name='_page'>
                " . popIndex($pages, $p) . "
            </ul>
        </div>
        ";

    function popuList($periods){        
        $option = '';
        foreach($periods as $period){
            $option = $option . '<option value="y=' . $period->year. '&t=' . $period->term . '">' . $period->year . ' ' . $period->term . '</option>';
        }
        return $option;
    }

    function popIndex($pages){
        $li = "";

        if(!$_GET['_page'] || $_GET['_page'] < 10){
            $celling = floor($pages[0]->number / 10) < 10? floor($pages[0]->number / 10) : 10;

            for ($i = 0; $i < $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=so-to-clo-mapping&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=so-to-clo-mapping&_page=10') . "'>&#x2192;</a></li>";
            }
        }
        else if(floor($pages[0]->number / 10) >= $_GET['_page']){
            $floor = floor($_GET['_page'] / 10) * 10;
            $celling = ($floor + 9) < floor($pages[0]->number / 10)? ($floor + 9) : floor($pages[0]->number / 10);
            $li = "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=so-to-clo-mapping&_page=' . ($floor - 1) . '') . "'>&#x2190;</a></li>";
            for ($i = $floor; $i <= $celling; $i++){
                $li = $li . "<li class='page-item " . activate($i) . " '><a class='page-link' href='" . admin_url('/admin.php?page=so-to-clo-mapping&_page=' . $i . '') . "'>" . $i . "</a></li>";
            }
            if($celling != floor($pages[0]->number / 10)){
                $li = $li . "<li class='page-item'><a class='page-link' href='" . admin_url('/admin.php?page=so-to-clo-mapping&_page=' . ($celling + 1) . '') . "'>&#x2192;</a></li>";
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
            $tr = $tr . '<tr>
                            <td>' . $record->PloNo . '</td>
                            <td>' . $record->course . '</td>
                            <td>' . $record->section . '</td>
                            <td>' . $record->term . '</td>
                            <td>' . $record->year . '</td>
                            <td>' . $record->CloNo . '</td>
                            <td><a href="#" id="myBtn" onclick="discard(' . $record->nid3 . ')"> Delete </a></td> 
                        </tr>';
        }
        return $tr;
    }
?>