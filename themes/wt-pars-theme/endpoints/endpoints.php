<?php

    add_action( 'rest_api_init', function () {
        register_rest_route( 'wt-pars-theme/v2', '/viewresults/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_viewresults',
            'permission_callback' => 'check_levelTwo',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/template/clo/(?P<so_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_clo',
            'permission_callback' => 'check_levelTwo',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/programeducationalobjective/(?P<peo_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_programEducationalObjective',
            'permission_callback' => 'check_levelTwo',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/template/measure/(?P<clo_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
            'methods' => 'GET',
            'callback' => 'get_measure',
            'permission_callback' => 'check_levelTwo',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/course/(?P<course_id>\d+)/(?P<code>.+)/(?P<name>.+)/(?P<description>.+)', array(
            'methods' => 'PUT',
            'callback' => 'put_course',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/course/(?P<code>.+)/(?P<name>.+)/(?P<description>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_course',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/course/(?P<course_id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'delete_course',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/clo/(?P<clo_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'PUT',
            'callback' => 'put_clo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/clo/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_clo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/clo/(?P<clo_id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'delete_clo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/peo/(?P<peo_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'PUT',
            'callback' => 'put_peo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/peo/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_peo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/peo/(?P<peo_id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'delete_peo',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/so/(?P<so_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'PUT',
            'callback' => 'put_so',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/so/(?P<code>.+)/(?P<description>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_so',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/so/(?P<so_id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'delete_so',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/createsection', array(
            'methods' => 'GET',
            'callback' => 'get_create_section',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/admin/alphastage/(?P<course_id>\d+)/(?P<instructor_id>\d+)/(?P<instructor>.+)/(?P<section_number>.+)/(?P<year>\w+)/(?P<term>.+)/(?P<clo_id>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_alphaStage',
            'permission_callback' => 'check_levelOne',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/template/clolist/(?P<section_id>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_clolist',
            'permission_callback' => 'check_levelTwo',
        ) );
        register_rest_route( 'wt-pars-theme/v2', '/template/fcarform/(?P<section_id>\d+)/(?P<a>\d+)/(?P<b>\d+)/(?P<c>\d+)/(?P<d>\d+)/(?P<f>\d+)/(?P<x>\d+)/(?P<modification>.+)/(?P<reflection>.+)/(?P<feedback>.+)/(?P<improvement>.+)/(?P<measure>.+)', array(
            'methods' => 'POST',
            'callback' => 'post_fcarform',
            'permission_callback' => 'check_levelTwo',
        ) );
    } );


    function check_levelOne(){
        // Credit for the following six lines: Thomas Jensen - July 29, 2012 - https://stackoverflow.com/questions/541430/how-do-i-read-any-request-header-in-php
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }

        $nonce = wp_verify_nonce($headers['XWpNonce'], 'wp_rest');

        if ( !current_user_can('administrator') || $nonce == false ) {
            return new WP_Error( 'rest forbidden', 'OMG you can not view private data.', array( 'status' => 401 ) );
        }
        
        return true;
    }

    function check_levelTwo(){
        // Credit for the following six lines: Thomas Jensen - July 29, 2012 - https://stackoverflow.com/questions/541430/how-do-i-read-any-request-header-in-php
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }

        $nonce = wp_verify_nonce($headers['XWpNonce'], 'wp_rest');

        if ( !current_user_can('delete_others_pages') || $nonce == false ) {
            return new WP_Error( 'rest forbidden', 'OMG you can not view private data.' , array( 'status' => 401 ) );
        }
        
        return true;
    }

    function get_viewresults( $data ) {
        global $wpdb;
                                
            try{
                $data = $wpdb->get_results( $wpdb->prepare(
                    "SELECT
                        pars_course.code AS course_code,
                        pars_course.description AS course_description,
                        pars_section.instructor,
                        pars_section.number,
                        pars_section.term,
                        pars_section.year,
                        pars_section.modification,
                        pars_section.feedback,
                        pars_section.reflection,
                        pars_section.proposed_action,
                        pars_section.a,
                        pars_section.b,
                        pars_section.c,
                        pars_section.d,
                        pars_section.f,
                        pars_section.x,
                        pars_course_learning_outcome.code AS clo_code,
                        pars_course_learning_outcome.description AS clo_description,
                        pars_measure.type,
                        pars_measure.exemplary,
                        pars_measure.good,
                        pars_measure.satisfactory,
                        pars_measure.poor,
                        pars_measure.unsatisfactory,
                        pars_measure.comment,
                        pars_student_outcome.code AS so_code,
                        pars_student_outcome.description AS so_description
                    FROM
                        pars_section,
                        pars_course,
                        pars_alpha,
                        pars_course_learning_outcome,
                        pars_measure,
                        pars_beta,
                        pars_student_outcome
                    WHERE
                        pars_section.course_id = pars_course.course_id AND pars_section.section_id = '%d' AND pars_alpha.section_id = pars_section.section_id AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_beta.alpha_id = pars_alpha.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id
                    ORDER BY so_code", $data['id']));           

                if(!empty($wpdb->last_error)){
                    throw new Exception($wpdb->last_error);
                }
            }
            catch (Exception $e){
                return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
            }
            
        return $data;
    }

    function get_clo( $data ) {
        global $wpdb;

            try{
                $data = $wpdb->get_results( $wpdb->prepare(
                    "SELECT
                        CONCAT(pars_course_learning_outcome.code, pars_course_learning_outcome.description, pars_course.code, pars_section.number) AS Groupie,
                        pars_course_learning_outcome.clo_id,
                        pars_course_learning_outcome.code AS clo_code,
                        pars_course.code AS course_code,
                        pars_section.number section_number,
                        pars_course_learning_outcome.description clo_description,
                        pars_course.code course_code,
                        ROUND(
                            (
                                SUM(pars_measure.exemplary) /(
                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                ) * 100
                            ),
                            2
                        ) AS exemplary,
                        ROUND(
                            (
                                SUM(pars_measure.good) /(
                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                ) * 100
                            ),
                            2
                        ) AS good,
                        ROUND(
                            (
                                SUM(pars_measure.satisfactory) /(
                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                ) * 100
                            ),
                            2
                        ) AS satisfactory,
                        ROUND(
                            (
                                SUM(pars_measure.poor) /(
                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                ) * 100
                            ),
                            2
                        ) AS poor,
                        ROUND(
                            (
                                SUM(pars_measure.unsatisfactory) /(
                                    SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                                ) * 100
                            ),
                            2
                        ) AS unsatisfactory
                    FROM
                        pars_section,
                        pars_course,
                        pars_course_learning_outcome,
                        pars_alpha,
                        pars_measure,
                        pars_beta
                    WHERE
                        pars_section.course_id = pars_course.course_id AND pars_alpha.section_id = pars_section.section_id AND pars_course_learning_outcome.clo_id = pars_alpha.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_beta.alpha_id = pars_alpha.alpha_id AND pars_section.term = '%s' AND pars_section.year = '%s' AND pars_beta.so_id = '%d'
                    GROUP BY 
                        Groupie
                    ORDER BY 
                        pars_course.code, pars_section.number", $data['term'], $data['year'], $data['so_id']));        
                        
                if(!empty($wpdb->last_error)){
                    throw new Exception($wpdb->last_error);
                }
            }
            catch (Exception $e){
                return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
            }
                                    
        return $data;
    }

    function get_programEducationalObjective( $data ) {
        global $wpdb;

        try{
            $data = $wpdb->get_results( $wpdb->prepare(
                "SELECT
                    pars_student_outcome.so_id,
                    pars_student_outcome.code AS so_code,
                    pars_student_outcome.description AS so_description,
                    ROUND(
                        (
                            SUM(pars_measure.exemplary) /(
                                SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                            ) * 100
                        ),
                        2
                    ) AS exemplary,
                    ROUND(
                        (
                            SUM(pars_measure.good) /(
                                SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                            ) * 100
                        ),
                        2
                    ) AS good,
                    ROUND(
                        (
                            SUM(pars_measure.satisfactory) /(
                                SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                            ) * 100
                        ),
                        2
                    ) AS satisfactory,
                    ROUND(
                        (
                            SUM(pars_measure.poor) /(
                                SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                            ) * 100
                        ),
                        2
                    ) AS poor,
                    ROUND(
                        (
                            SUM(pars_measure.unsatisfactory) /(
                                SUM(pars_measure.exemplary) + SUM(pars_measure.good) + SUM(pars_measure.satisfactory) + SUM(pars_measure.poor) + SUM(pars_measure.unsatisfactory)
                            ) * 100
                        ),
                        2
                    ) AS unsatisfactory
                FROM
                    pars_section,
                    pars_measure,
                    pars_alpha,
                    pars_beta,
                    pars_student_outcome
                WHERE
                    pars_section.section_id = pars_alpha.section_id AND pars_alpha.alpha_id = pars_beta.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.year = '%s' AND pars_section.term = '%s' AND pars_beta.peo_id = '%d'
                GROUP BY
                    pars_student_outcome.code", $data['year'], $data['term'], $data['peo_id']));    
                    
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return $data;
    }

    function put_course( $data ){
        global $wpdb;
        $course_code = urldecode($data['code']);
        $course_name = urldecode($data['name']);
        $course_description = urldecode($data['description']);
        
        try{
            $wpdb->update('pars_course',
                        array(
                            'code'=>$course_code,
                            'name'=>$course_name,
                            'description'=>$course_description
                        ),
                        array( 'course_id'=>$data['course_id'] ),
                        array(
                            '%s',
                            '%s',
                            '%s'
                        ),
                        array( '%d' )
                    ); 

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
        return true;
    }

    function post_course( $data ) {
        global $wpdb;
        $course_code = urldecode($data['code']);
        $course_name = urldecode($data['name']);
        $course_description = urldecode($data['description']);
        
        try{
            $wpdb->insert('pars_course',
                    array(
                        'code'=>$course_code,
                        'name'=>$course_name,
                        'description'=>$course_description
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s'
                    )
                );    
    
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return true;
    }

    function delete_course( $data ) {
        global $wpdb;
        
        try{
            $wpdb->delete( 'pars_course', 
                    array( 'course_id'=>$data['course_id'] ),
                    array( '%d' )
                 );  
    
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
    
        return true;
    }

    function put_clo( $data ){
        global $wpdb;
        $clo_code = urldecode($data['code']);
        $clo_description = urldecode($data['description']);

        try{
            $wpdb->update('pars_course_learning_outcome',
                array(
                    'code'=>$clo_code,
                    'description'=>$clo_description
                ),
                array( 'clo_id'=>$data['clo_id'] ),
                array(
                    '%s',
                    '%s'
                ),
                array( '%d' )
            ); 

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return true;
    }

    function post_clo( $data ) {
        global $wpdb;
        $clo_code = urldecode($data['code']);
        $clo_description = urldecode($data['description']);
                
        try{
            $wpdb->insert('pars_course_learning_outcome',
                    array(
                        'code'=>$clo_code,
                        'description'=>$clo_description
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );  
    
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
    
        return true;
    }

    function delete_clo( $data ) {
        global $wpdb;
                 
        try{
            $wpdb->delete( 'pars_course_learning_outcome', 
                    array( 'clo_id'=>$data['clo_id']),
                    array( '%d' )
                 );  
        
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return true;
    }

    function put_peo( $data ){
        global $wpdb;
        $peo_code = urldecode($data['code']);
        $peo_description = urldecode($data['description']);
         
        try{
            $wpdb->update('pars_program_educational_objective',
                    array(
                        'code'=>$peo_code,
                        'description'=>$peo_description
                    ),
                    array( 'peo_id'=>$data['peo_id'] ),
                    array(
                        '%s',
                        '%s'
                    ),
                    array( '%d' )
                );

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
        return true;
    }

    function post_peo( $data ) {
        global $wpdb;
        $peo_code = urldecode($data['code']);
        $peo_description = urldecode($data['description']);
            
            try{
                $wpdb->insert('pars_program_educational_objective',
                    array(
                        'code'=>$peo_code,
                        'description'=>$peo_description
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );
        
                if(!empty($wpdb->last_error)){
                    throw new Exception($wpdb->last_error);
                }
            }
            catch (Exception $e){
                return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
            }
    
        return true;
    }

    function delete_peo( $data ) {
        global $wpdb;
                     
        try{
            $wpdb->delete( 'pars_program_educational_objective',
                        array( 'peo_id'=>$data['peo_id']),
                        array( '%d' )
                     );  
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return true;
    }

    function put_so( $data ){
        global $wpdb;
        $so_code = urldecode($data['code']);
        $so_description = urldecode($data['description']); 

        try{
            $wpdb->update('pars_student_outcome',
                        array(
                            'code'=>$so_code,
                            'description'=>$so_description
                        ),
                        array( 'so_id'=>$data['so_id'] ),
                        array(
                            '%s',
                            '%s'
                        ),
                        array( '%d' )
                    );

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
        return true;
    }

    function post_so( $data ) {
        global $wpdb;
        $so_code = urldecode($data['code']);
        $so_description = urldecode($data['description']);
    
        try{
            $wpdb->insert('pars_student_outcome',
                    array(
                        'code'=>$so_code,
                        'description'=>$so_description
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
    
        return true;
    }

    function delete_so( $data ) {
        global $wpdb;

        try{
            $wpdb->delete( 'pars_student_outcome', 
                    array( 'so_id'=>$data['so_id']),
                    array( '%d' )
                 );  
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }
    
        return true;
    }

    function get_measure( $data ){
        global $wpdb;
        try{
            $data = $wpdb->get_results( $wpdb->prepare(
                "SELECT
                    pars_measure.type,
                    pars_measure.comment,
                    ROUND(
                        (
                            pars_measure.exemplary /(
                                pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                            ) * 100
                        ),
                        2
                    ) AS exemplary,
                    ROUND(
                        (
                            pars_measure.good /(
                                pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                            ) * 100
                        ),
                        2
                    ) AS good,
                    ROUND(
                        (
                            pars_measure.satisfactory /(
                                pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                            ) * 100
                        ),
                        2
                    ) AS satisfactory,
                    ROUND(
                        (
                            pars_measure.poor /(
                                pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                            ) * 100
                        ),
                        2
                    ) AS poor,
                    ROUND(
                        (
                            pars_measure.unsatisfactory /(
                                pars_measure.exemplary + pars_measure.good + pars_measure.satisfactory + pars_measure.poor + pars_measure.unsatisfactory
                            ) * 100
                        ),
                        2
                    ) AS unsatisfactory
                FROM
                    pars_section,
                    pars_course,
                    pars_course_learning_outcome,
                    pars_alpha,
                    pars_measure
                WHERE
                    pars_section.course_id = pars_course.course_id AND pars_alpha.section_id = pars_section.section_id AND pars_course_learning_outcome.clo_id = pars_alpha.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id AND pars_section.term = '%s' AND pars_section.year = '%s' AND pars_alpha.clo_id = '%d'", $data['term'], $data['year'], $data['clo_id']));
            
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }
        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return $data;
    }

    function get_create_section( $data ) {
        global $wpdb;

        try{
            $wpdb->query('START TRANSACTION;');

            $course = $wpdb->get_results(
                "SELECT
                    pars_course.course_id,
                    pars_course.code AS course_code,
                    pars_course.name AS course_name,
                    pars_course.description AS course_description
                FROM
                    pars_course");
            
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }

            $instructor = $wpdb->get_results(
                "SELECT
                    lastname.user_id AS instructor_id,
                    CONCAT(
                        firstname.meta_value,
                        ' ',
                        lastname.meta_value
                    ) AS instructor
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
                    firstname.meta_key = 'first_name'");

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }

            $clo = $wpdb->get_results(
                "SELECT
                    pars_course_learning_outcome.clo_id,
                    pars_course_learning_outcome.code AS clo_code,
                    pars_course_learning_outcome.description AS clo_description
                FROM
                    pars_course_learning_outcome");

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }

            $wpdb->query('COMMIT;');

            $result = array(
                "course" => $course,
                "instructor" => $instructor,
                "clo" => $clo                 
            );

        }
        catch (Exception $e){
            $wpdb->query('ROLLBACK;');
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return $result;
    }
    
    function post_alphaStage( $data ) {

        global $wpdb;

        $section_number = explode(',', $data["section_number"]);
        $clo_id = explode(',', $data["clo_id"]);
        $instructor = urldecode($data['instructor']);
        $term = urldecode($data['term']);

        try{
            $wpdb->query('START TRANSACTION;');
                    
            for ($i = 0; $i < count($section_number); $i++){
                $wpdb->insert('pars_section',
                    array(
                        'course_id'=>$data['course_id'],
                        'instructor_id'=>$data['course_id'],
                        'instructor'=>$instructor,
                        'number'=>$section_number[0],
                        'term'=>$term,
                        'year'=>$data['year'],
                        'enable'=>0
                    ),
                    array(
                        '%d',
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d'
                    )
                );

                if(!empty($wpdb->last_error)){
                    throw new Exception($wpdb->last_error);
                }

                $id = $wpdb->insert_id;
                
                for($x = 0; $x < count($clo_id); $x++){
                    $wpdb->insert('pars_alpha',
                            array(
                                'clo_id'=>$clo_id[$x],
                                'section_id'=>$id,
                                'enable'=>0
                            ),
                            array(
                                '%d',
                                '%d',
                                '%d'
                            )
                        );

                    if(!empty($wpdb->last_error)){
                        throw new Exception($wpdb->last_error);
                    }
                }
            }
            $wpdb->query('COMMIT;');
        }
        catch (Exception $e){
            $wpdb->query('ROLLBACK;');
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));
        }

        return true;
    }

    function get_clolist( $data ) {
        global $wpdb;

        try{
            $result = $wpdb->get_results($wpdb->prepare(
                "SELECT
                    pars_alpha.alpha_id,
                    pars_course_learning_outcome.code AS clo_code,
                    pars_course_learning_outcome.description AS clo_description
                FROM
                    pars_course_learning_outcome,
                    pars_alpha
                WHERE
                    pars_course_learning_outcome.clo_id = pars_alpha.clo_id AND pars_alpha.section_id = %d", $data['section_id']));

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }

        }
        catch (Exception $e){
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));     
        }

        return $result;
    }

    function post_fcarform( $data ){
        global $wpdb;

        $measure = array_map(function($x){
            list($alpha_id, $measure, $comments, $exemplary, $good, $satisfactory, $poor, $unsatisfactory) = explode(',', $x);
            return [
                'alpha_id' => substr($alpha_id, strpos($alpha_id, ':') + 1), 
                'measure' => substr($measure, strpos($measure, ':') + 1), 
                'comments' => substr($comments, strpos($comments, ':') + 1), 
                'exemplary' => substr($exemplary, strpos($exemplary, ':') + 1), 
                'good' => substr($good, strpos($good, ':') + 1), 
                'satisfactory' => substr($satisfactory, strpos($satisfactory, ':') + 1),
                'poor' => substr($poor, strpos($poor, ':') + 1), 
                'unsatisfactory' => substr($unsatisfactory, strpos($unsatisfactory, ':') + 1)
            ];
        }, explode('},', str_replace('"', '', urldecode($data['measure']))));

        try{
            $wpdb->query('START TRANSACTION;');

            $wpdb->update('pars_section', 
                        array(
                            'a' => $data['a'],
                            'b' => $data['b'],
                            'c' => $data['c'],
                            'd' => $data['d'],
                            'f' => $data['f'],
                            'x' => $data['x'],
                            'modification' => $data['modification'],
                            'reflection' => $data['reflection'],
                            'feedback' => $data['feedback'],
                            'proposed_action' => $data['improvement'],
                            'enable' => 1,
                        ),
                        array(
                            'section_id' => $data['section_id']
                        ),
                        array(
                            '%d',
                            '%d',
                            '%d',
                            '%d',
                            '%d',
                            '%d',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                        ),
                        array( '%d' )
                    );

            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error);
            }

            for($x = 0; $x < count($clo); $x++){
                $wpdb->insert('pars_measure',
                        array(
                            'alpha_id' => $measure[$x]['alpha_id'],
                            'type' => $measure[$x]['measure'],
                            'exemplary' => $measure[$x]['exemplary'],
                            'good' => $measure[$x]['good'],
                            'satisfactory' => $measure[$x]['satisfactory'],
                            'poor' => $measure[$x]['poor'],
                            'unsatisfactory' => $measure[$x]['unsatisfactory']
                        ),
                        array(
                            '%d',
                            '%s',
                            '%d',
                            '%d',
                            '%d',
                            '%d',
                            '%d'
                        )
                    );

                    if(!empty($wpdb->last_error)){
                        throw new Exception($wpdb->last_error);
                    }
            }
            $wpdb->query('COMMIT;');
        }
        catch (Exception $e){
            $wpdb->query('ROLLBACK;');
            return new WP_Error('query failed', $e->getMessage(), array('status' => 500));
        }

        return true;
    }
                                
?>