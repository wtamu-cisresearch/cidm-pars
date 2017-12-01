<?php

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wt-pars-plugin/v1', '/course/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_coMana',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/course/(?P<course>.+)/(?P<section>\w+)/(?P<term>\w+)/(?P<year>\w+)/(?P<coursename>.+)/(?P<coursedes>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_coMana',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/course/(?P<id>\d+)/(?P<course>.+)/(?P<section>\w+)/(?P<term>\w+)/(?P<year>\w+)/(?P<coursename>.+)/(?P<coursedes>.+)', array(
            'methods' => 'POST',
            'callback' => 'update_coMana',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/peo/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_peo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/peo/(?P<year>\w+)/(?P<term>\w+)/(?P<peonumber>.+)/(?P<peodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_peo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/peo/(?P<id>\d+)/(?P<year>\w+)/(?P<term>\w+)/(?P<peonumber>.+)/(?P<peodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'update_peo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/so/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_so',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/so/(?P<year>\w+)/(?P<term>\w+)/(?P<sonumber>.+)/(?P<sodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_so',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/so/(?P<id>\d+)/(?P<year>\w+)/(?P<term>\w+)/(?P<sonumber>.+)/(?P<sodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'update_so',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/carFor/(?P<year>\d+)', array(
            'methods' => 'POST',
            'callback' => 'post_carFor',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/grades/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_grades',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/assignment/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_assignment',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/parsusers/(?P<uid>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_parsUsers',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/course/(?P<course>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_courseDescription',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clomapping/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_clomapping',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clomeasures/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_clo_measures',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/cloreport/(?P<soid>\d+)/(?P<year>\w+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_cloreport',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/soreport/(?P<peoid>\d+)/(?P<year>\w+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_soreport',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clono/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_clono',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clo/(?P<course>\w+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_clo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clo/(?P<course>.+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)/(?P<clonumber>.+)/(?P<clodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_clo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clo/(?P<id>\d+)/(?P<course>.+)/(?P<year>\w+)/(?P<term>\w+)/(?P<section>\w+)/(?P<clonumber>.+)/(?P<clodes>.+)', array(
            'methods' => 'POST',
            'callback' => 'update_clo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clo/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_clo',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/crossbridge/(?P<clono>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_crossbridge',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/assessmentdata/(?P<course>.+)/(?P<section>\w+)/(?P<term>\w+)/(?P<year>\w+)/(?P<modification>.+)/(?P<feedback>.+)/(?P<reflection>.+)/(?P<improvement>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_assessmentdata',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/grades/(?P<course>.+)/(?P<section>\w+)/(?P<term>\w+)/(?P<year>\w+)/(?P<a>\w+)/(?P<b>\w+)/(?P<c>\w+)/(?P<d>\w+)/(?P<f>\w+)/(?P<x>\w+)/(?P<sum>\w+)', array(
            'methods' => 'POST',
            'callback' => 'post_grades',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/clomeasures/(?P<clonumber>.+)/(?P<course>.+)/(?P<measure>\w+)/(?P<section>\w+)/(?P<term>\w+)/(?P<year>\w+)/(?P<exemplary>\w+)/(?P<good>\w+)/(?P<satisfactory>\w+)/(?P<poor>\w+)/(?P<unsatisfactory>\w+)/(?P<soid>\w+)/(?P<epercentage>.+)/(?P<gpercentage>.+)/(?P<spercentage>.+)/(?P<ppercentage>.+)/(?P<upercentage>.+)/(?P<comments>.+)/(?P<peo>\w+)', array(
            'methods' => 'POST',
            'callback' => 'post_clomeasures',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/wpusers', array(
            'methods' => 'GET',
            'callback' => 'get_wpusers',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/assignment/(?P<id>\d+)/(?P<name>.+)/(?P<course>.+)/(?P<startfcar>.+)/(?P<endfcar>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_assignment',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', 'test/(?P<data>.+)', array(
            'methods' => 'POST',
            'callback' => 'get_test',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/assignment/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_assignment',
        ) );
        register_rest_route( 'wt-pars-plugin/v1', '/ploclomap/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'del_ploclomap',
        ) );
    } );

    function del_coMana( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM course WHERE nid1 =' . $data['id'] . '');  
    
        return true;
    }

    function post_coMana( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
        $courseDes = urldecode($data['coursedes']);
        $courseName = urldecode($data['coursename']);
        $wpdb->insert('course',
                array(
                    'course'=>$course,
                    'section'=>$data['section'],
                    'term'=>$data['term'],
                    'year'=>$data['year'],
                    'course_description'=>$courseDes,
                    'course_name'=>$courseName
                    )
                );    
    
        return true;
    }

    function update_coMana( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
        $courseDes = urldecode($data['coursedes']);
        $courseName = urldecode($data['coursename']);
        $wpdb->update('course',
                        array(
                            'course'=>$course,
                            'section'=>$data['section'],
                            'term'=>$data['term'],
                            'year'=>$data['year'],
                            'course_description'=>$courseDes,
                            'course_name'=>$courseName
                        ),
                        array( 'nid1'=> $data['id'] )
                    ); 
        return true;
    }

    function del_peo( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM program_education_objective WHERE nid =' . $data['id'] . '');  
    
        return true;
    }

    function post_peo( $data ) {
        global $wpdb;
        $peoDes = urldecode($data['peodes']);
        $peoNumber = urldecode($data['peonumber']);
        $wpdb->insert('program_education_objective',
                array(
                    'term'=>$data['term'],
                    'year'=>$data['year'],
                    'peo_description'=>$peoDes,
                    'peo'=>$peoNumber
                    )
                );    
    
        return true;
    }

    function update_peo( $data ) {
        global $wpdb;
        $peoDes = urldecode($data['peodes']);
        $peoNumber = urldecode($data['peonumber']);
        $wpdb->update('program_education_objective',
                        array(
                            'term'=>$data['term'],
                            'year'=>$data['year'],
                            'peo_description'=>$peoDes,
                            'peo'=>$peoNumber
                        ),
                        array( 'nid'=> $data['id'] )
                    ); 
        return true;
    }

    function del_so( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM plo WHERE nid11 =' . $data['id'] . '');  
    
        return true;
    }

    function post_so( $data ) {
        global $wpdb;
        $soDes = urldecode($data['sodes']);
        $soNumber = urldecode($data['sonumber']);
        $wpdb->insert('plo',
                array(
                    'term'=>$data['term'],
                    'year'=>$data['year'],
                    'PloDec'=>$soDes,
                    'PloNo'=>$soNumber
                    )
                );    
    
        return true;
    }

    function update_so( $data ) {
        global $wpdb;
        $soDes = urldecode($data['sodes']);
        $soNumber = urldecode($data['sonumber']);
        $wpdb->update('plo',
                        array(
                            'term'=>$data['term'],
                            'year'=>$data['year'],
                            'PloDec'=>$soDes,
                            'PloNo'=>$soNumber
                        ),
                        array( 'nid11'=> $data['id'] )
                    ); 
        return true;
    }

    function post_carFor( $data ) {
        $newYear = $data['year'] + 1;
        global $wpdb;
        // $wpdb->get_results( 'INSERT INTO clo (CloNo, course, section, term, year, CloDec) SELECT CloNo, course, section, term, ' . $newYear .  ', CloDec FROM clo WHERE year = "' . $data['year'] .  '"');
        $wpdb->get_results( " INSERT INTO ploclomap(
                                term,
                                year,
                                section,
                                PloNo,
                                CloNo,
                                course
                                )
                                SELECT
                                    term,
                                    '" . $newYear .  "',
                                    section,
                                    PloNo,
                                    REPLACE (CloNo, '" . $data['year'] .  "', '" . $newYear .  "'),
                                    course
                                FROM
                                    ploclomap
                                WHERE
                                    year = '" . $data['year'] .  "'
                                " );
        $wpdb->get_results( 'INSERT INTO plo (PloNo, nid, year, term, PloDec) SELECT PloNo, nid, ' . $newYear .  ', term, PloDec FROM plo WHERE year = "' . $data['year'] .  '"');
        $wpdb->get_results( 'INSERT INTO plopeomap (plo, peo, year, term, nid2) SELECT plo, peo, ' . $newYear .  ', term, nid2 FROM plopeomap WHERE year = "' . $data['year'] .  '"');
        $wpdb->get_results( 'INSERT INTO program_education_objective (peo, nid2, peo_description, year, term) SELECT peo, nid2, peo_description, ' . $newYear .  ', term FROM program_education_objective WHERE year = "' . $data['year'] .  '"');
        $wpdb->get_results( 'INSERT INTO course (course, section, term, year, course_description, course_name) SELECT course, section, term, ' . $newYear .  ', course_description, course_name FROM course WHERE year = "' . $data['year'] .  '"');
        $wpdb->get_results( "INSERT INTO clo(
                                    CloNo,
                                    course,
                                    section,
                                    term,
                                    year,
                                    CloDec  
                                    )
                                SELECT
                                    REPLACE (CloNo, '" . $data['year'] .  "', '" . $newYear .  "'),
                                    course,
                                    section,
                                    term,
                                    '" . $newYear .  "',
                                    CloDec
                                FROM
                                    clo
                                WHERE
                                    year = '" . $data['year'] .  "'
                            ");
        $wpdb->get_results( "INSERT INTO assignment(
                                course,
                                uid,
                                username,
                                section,
                                term,
                                year,
                                assigns,
                                year_start,
                                year_end,
                                datestart,
                                dateend,
                                month_start,
                                month_end,
                                enable_assessment,
                                assessment_startdate,
                                assessment_enddate
                            )
                            SELECT
                                course,
                                uid,
                                username,
                                section,
                                term,
                                '" . $newYear .  "',
                                assigns,
                                year_start,
                                year_end,
                                datestart,
                                dateend,
                                month_start,
                                month_end,
                                enable_assessment,
                                assessment_startdate,
                                assessment_enddate
                            FROM
                                assignment
                            WHERE
                                year = '" . $data['year'] .  "'
                        ");
        return true;
    }

    function get_grades( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
        $record = $wpdb->get_results( "SELECT * FROM grades WHERE course = '" . $course . "'  AND year = '" . $data['year'] . "' AND term = '" . $data['term'] . "' AND section = '" . $data['section'] . "' ");
    
        return $record;
    }

    function get_assignment( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
        $record = $wpdb->get_results( "SELECT uid FROM assignment WHERE course = '" . $course . "'  AND year = '" . $data['year'] . "' AND term = '" . $data['term'] . "' AND section = '" . $data['section'] . "' ");
    
        return $record;
    }

    function get_parsUsers( $data ) {
        global $wpdb;
        $record = $wpdb->get_results( "SELECT username FROM pars_users WHERE userid = '" . $data['uid'] . "'");
    
        return $record;
    }

    function get_courseDescription( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
        $record = $wpdb->get_results( "SELECT DISTINCT course_description FROM course WHERE course = '" . $course . "'");
    
        return $record;
    }

    function get_clomapping( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
        //SELECT DISTINCT clo.CloNo, clo.CloDec, so.sonumber, so.sodes FROM clo INNER JOIN (SELECT clo_measures.CloNo as clonumber, plo.PloNo AS sonumber, plo.PloDec as sodes FROM `clo_measures` INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = 2012 AND clo_measures.term = 'Fall' and clo_measures.course = 'CIDM 1315' AND clo_measures.section = 1) as so WHERE clo.CloNo = so.clonumber   
        $record = $wpdb->get_results( "SELECT DISTINCT clo.CloNo, clo.CloDec, so.sonumber, so.sodes FROM clo INNER JOIN (SELECT clo_measures.CloNo as clonumber, plo.PloNo AS sonumber, plo.PloDec as sodes FROM `clo_measures` INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = '" . $data['year'] . "' AND clo_measures.term = '" . $data['term'] . "' and clo_measures.course = '" . $course . "' AND clo_measures.section = '" . $data['section'] . "') as so WHERE clo.CloNo = so.clonumber");
    
        return $record;
    }

    function get_clo_measures( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
        //SELECT clo_measures.*, plo.PloNo AS sonumber FROM `clo_measures` INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = 2012 AND clo_measures.term = 'Fall' and clo_measures.course = 'CIDM 1315' AND clo_measures.section = 1  
        $record = $wpdb->get_results( "SELECT clo_measures.*, plo.PloNo AS sonumber FROM `clo_measures` INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = '" . $data['year'] . "' AND clo_measures.term = '" . $data['term'] . "' and clo_measures.course = '" . $course . "' AND clo_measures.section = '" . $data['section'] . "' ORDER BY sonumber");
    
        return $record;
    }

    function get_cloreport( $data ) {
        global $wpdb;
        $record = $wpdb->get_results("
                                        SELECT
                                        clo.CloNo AS clonumber,
                                        clo.CloDec AS clodes,
                                        clo_measures.PloNo AS soid,
                                        clo_measures.course,
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
                                    INNER JOIN clo WHERE clo_measures.CloNo = clo.CloNo AND clo_measures.year = '" . $data['year'] . "' AND clo_measures.term = '" . $data['term'] . "' AND clo_measures.PloNo = '" . $data['soid'] . "'
                                    GROUP BY
                                        clonumber
                                    ");
    
        return $record;
    }

    function get_soreport( $data ) {
        global $wpdb;

        $record = $wpdb->get_results( 
                                        "SELECT
                                            crazyhouse.sonumber,
                                            crazyhouse.sodes,
                                            crazyhouse.soid,
                                            crazyhouse.exemplary,
                                            crazyhouse.satisfactory,
                                            crazyhouse.unsatisfactory
                                        FROM
                                            (
                                            SELECT
                                                plo.PloNo AS 'sonumber',
                                                plo.PloDec AS 'sodes',
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
                                            INNER JOIN plo ON clo_measures.PloNo = plo.nid11 
                                            GROUP BY
                                                sonumber
                                        ) AS crazyhouse
                                        INNER JOIN (SELECT plo FROM plopeomap WHERE peo = '" . $data['peoid'] . "' AND year = '" . $data['year'] . "' AND term = '" . $data['term'] . "') AS coolhouse ON crazyhouse.soid = coolhouse.plo"
                                    );
    
        return $record;
    }

    function get_clono( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
         
        $record = $wpdb->get_results( "SELECT CloNo FROM clo WHERE year = '" . $data['year'] . "' AND term = '" . $data['term'] . "' AND course = '" . $course . "' AND section = '" . $data['section'] . "' ");
    
        return $record;
    }

    function post_clo( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
        $cloNumber = urldecode($data['clonumber']);
        $cloDes = urldecode($data['clodes']);
        $wpdb->insert('clo',
                array(
                    'course'=>$course,
                    'section'=>$data['section'],
                    'term'=>$data['term'],
                    'year'=>$data['year'],
                    'CloDec'=>$cloDes,
                    'CloNo'=>$cloNumber
                    )
                );    
    
        return true;
    }

    function update_clo( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
        $cloNumber = urldecode($data['clonumber']);
        $cloDes = urldecode($data['clodes']);
        $wpdb->update('clo',
                        array(
                            'course'=>$course,
                            'section'=>$data['section'],
                            'term'=>$data['term'],
                            'year'=>$data['year'],
                            'CloDec'=>$cloDes,
                            'CloNo'=>$cloNumber
                        ),
                        array( 'nid5'=> $data['id'] )
                    );
        return true;
    }

    function del_clo( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM clo WHERE nid5 =' . $data['id'] . '');  
    
        return true;
    }

    function get_clo( $data ) {
        global $wpdb;
        $course = str_replace('Q', ' ', $data['course']);
         
        $record = $wpdb->get_results( "SELECT * FROM clo WHERE year = '" . $data['year'] . "' AND term = '" . $data['term'] . "' AND course = '" . $course . "' AND section = '" . $data['section'] . "' ");
    
        return $record;
    }

    function get_crossbridge( $data ) {
        global $wpdb;    
        $clono = str_replace('Q', ' ', $data['clono']);
        $record = $wpdb->get_results( "
                                        SELECT DISTINCT
                                        Y.PloNo AS 'sonumber',
                                        plo.PloDec AS 'sodes',
                                        Y.CloDec AS 'clodes',
                                        Y.CloNo AS 'clonumber',
                                        Y.nid11 AS 'soid'
                                        FROM
                                            plo,
                                            (
                                            SELECT
                                                child.nid11,
                                                child.PloNo,
                                                clo.CloDec,
                                                clo.CloNo
                                            FROM
                                                clo
                                            INNER JOIN(
                                                SELECT 
                                                    plo.nid11,
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
                                            clo.CloNo = '" . $clono . "'
                                        ) AS Y
                                        WHERE   
                                            plo.PloNo = Y.PloNO
                                  ");
    
        return $record;
    }

    function post_assessmentdata( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
        $modification = urldecode($data['modification']);
        $feedback = urldecode($data['feedback']);
        $reflection = urldecode($data['reflection']);
        $improvement = urldecode($data['improvement']);

        $wpdb->get_results("
                            INSERT INTO assessment_data(
                                course,
                                section,
                                term,
                                year,
                                modification,
                                feedback,
                                reflection,
                                proposed_action)
                            VALUES(
                                '" . $course . "',
                                " . $data['section'] . ",
                                '" . $data['term'] . "',
                                " . $data['year'] . ",
                                '" . $modification . "',
                                '" . $feedback . "',
                                '" . $reflection . "',
                                '" . $improvement . "')
                        ");
        return true;
    }

    function post_grades( $data ) {
        global $wpdb;
        $course = urldecode($data['course']);
         
        $wpdb->get_results("
                            INSERT INTO grades(
                                course,
                                section,
                                term,
                                year,
                                a,
                                b,
                                c,
                                d,
                                f,
                                x,
                                sum)
                            VALUES(
                                '" . $course . "',
                                '" . $data['section'] . "',
                                '" . $data['term'] . "',
                                '" . $data['year'] . "',
                                '" . $data['a'] . "',
                                '" . $data['b'] . "',
                                '" . $data['c'] . "',
                                '" . $data['d'] . "',
                                '" . $data['f'] . "',
                                '" . $data['x'] . "',
                                '". $data['sum'] ."')
                        ");
        return true;
    }

    function post_clomeasures( $data ) {
        global $wpdb;
        $clonumber = urldecode($data['clonumber']);
        $course = urldecode($data['course']);
        $comments = urldecode($data['comments']);

        $wpdb->get_results("
                            INSERT INTO clo_measures(
                                CloNo,
                                course,
                                measures,
                                section,
                                term,
                                YEAR,
                                exemplary,
                                good,
                                satisfactory,
                                poor,
                                unsatisfactory,
                                PloNo,
                                Epercentage,
                                Gpercentage,
                                Spercentage,
                                Ppercentage,
                                Upercentage,
                                comments,
                                peo
                            )
                            VALUES(
                                '" . $clonumber . "',
                                '" . $course . "',
                                '" . $data['measure'] . "',
                                '" . $data['section'] . "',
                                '" . $data['term'] . "',
                                '" . $data['year'] . "',
                                '" . $data['exemplary'] . "',
                                '" . $data['good'] . "',
                                '" . $data['satisfactory'] . "',
                                '" . $data['poor'] . "',
                                '" . $data['unsatisfactroy'] . "',
                                '" . $data['soid'] . "',
                                '". $data['epercentage'] ."',
                                '". $data['gpercentage'] ."',
                                '". $data['spercentage'] ."',
                                '". $data['ppercentage'] ."',
                                '". $data['upercentage'] ."',
                                '". $comments ."',
                                '". $data['peo'] ."')
                        ");
        return true;
    }

    function get_wpusers( $data ){
        global $wpdb;
        $result = $wpdb->get_results( "SELECT firstname.user_id AS id,
                                            CONCAT(
                                                firstname.meta_value,
                                                ' ',
                                                lastname.meta_value
                                            ) AS NAME
                                        FROM
                                            wp_usermeta AS firstname
                                        INNER JOIN(
                                            SELECT
                                                user_id,
                                                meta_key,
                                                meta_value
                                            FROM
                                                wp_usermeta
                                            WHERE
                                                meta_key = 'last_name'
                                        ) AS lastname
                                        ON
                                            firstname.user_id = lastname.user_id
                                        WHERE
                                            firstname.meta_key = 'first_name'" );  
        
        return $result;
    }

    function post_assignment( $data ) {
        global $wpdb;
        $name = urldecode($data['name']);
        $course = urldecode($data['course']);
        $startFCAR = urldecode($data['startfcar']);
        $endFCAR = urldecode($data['endfcar']);
        $wpdb->insert('assignment',   // Turn this into a transaction no poor SQL allowed.
                array(
                    'course'=>$course,
                    'uid'=> 110 + $data['id'],
                    'username'=>'0',
                    'assigns'=>'0',
                    'year_start'=>'0',
                    'year_end'=>'0',
                    'datestart'=>'0',
                    'dateend'=>'0',
                    'month_start'=>'0',
                    'month_end'=>'0',
                    'enable_assessment'=>'0',
                    'assessment_startdate'=>$startFCAR,
                    'assessment_enddate'=>$endFCAR
                    )
                );
    
        $wpdb->insert('pars_users',   
        array(
            'userid'=> 110 + $data['id'],
            'username'=>$name
            )
        );

        return true;
    }

    function del_assignment( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM assignment WHERE nid10 =' . $data['id'] . '');  
    
        return true;
    }


    function del_ploclomap( $data ) {
        global $wpdb;
        $wpdb->get_results( 'DELETE FROM ploclomap WHERE nid3 =' . $data['id'] . '');  
    
        return true;
    }

    function get_test( $data ) {
     
        return 'works!';
    }
?>