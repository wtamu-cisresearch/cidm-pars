<?php

    class PARS_Custom_Route extends WP_REST_Controller{
        
        public function register_routes(){

            $version = '2';
            $namespace = 'wt-pars-theme/v' . $version;

            register_rest_route( $namespace, 'template/viewresults/(?P<id>\d+)', array(
                'methods' =>'GET',
                'callback' => array($this, 'get_viewresults'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );
            register_rest_route( $namespace, '/template/clo/(?P<so_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'get_clo'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );
            register_rest_route( $namespace, '/programeducationalobjective/(?P<peo_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'get_programEducationalObjective'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );
            register_rest_route( $namespace, '/template/measure/(?P<clo_id>\d+)/(?P<year>\d+)/(?P<term>\w+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'get_measure'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );
            register_rest_route( $namespace, '/admin/course/(?P<course_id>\d+)/(?P<code>.+)/(?P<name>.+)/(?P<description>.+)', array(
                'methods' => 'PUT',
                'callback' => array($this, 'put_course'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/course/(?P<code>.+)/(?P<name>.+)/(?P<description>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_course'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/course/(?P<course_id>\d+)', array(
                'methods' => 'DELETE',
                'callback' => array($this, 'delete_course'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/clo/(?P<clo_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'PUT',
                'callback' => array($this, 'put_clo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/clo/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_clo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/clo/(?P<clo_id>\d+)', array(
                'methods' => 'DELETE',
                'callback' => array($this, 'delete_clo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/peo/(?P<peo_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'PUT',
                'callback' => array($this, 'put_peo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/peo/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_peo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/peo/(?P<peo_id>\d+)', array(
                'methods' => 'DELETE',
                'callback' => array($this, 'delete_peo'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/so/(?P<so_id>\d+)/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'PUT',
                'callback' => array($this, 'put_so'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/so/(?P<code>.+)/(?P<description>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_so'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/so/(?P<so_id>\d+)', array(
                'methods' => 'DELETE',
                'callback' => array($this, 'delete_so'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/createsection', array(
                'methods' => 'GET',
                'callback' => array($this, 'get_create_section'),
                'permission_callback' => array($this, 'permit_levelOne'),
            ) );
            register_rest_route( $namespace, '/admin/alphastage/(?P<course_id>\d+)/(?P<instructor_id>\d+)/(?P<instructor>.+)/(?P<section_number>.+)/(?P<year>\w+)/(?P<term>.+)/(?P<clo_id>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_alphaStage'),
                'permission_callback' => array($this, 'permit_levelOne'),
                'args' => array(
                    'section_number' => array(
                        'sanitize_callback' => array($this, 'sanitize_numberArray'),
                    ),
                    'clo_id' => array(
                        'sanitize_callback' => array($this, 'sanitize_numberArray'),
                    ),
                ),
            ) );
            register_rest_route( $namespace, '/template/clolist/(?P<section_id>\d+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'get_clolist'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );
            register_rest_route( $namespace, '/template/fcarform/(?P<section_id>\d+)/(?P<a>\d+)/(?P<b>\d+)/(?P<c>\d+)/(?P<d>\d+)/(?P<f>\d+)/(?P<x>\d+)/(?P<modification>.+)/(?P<reflection>.+)/(?P<feedback>.+)/(?P<improvement>.+)/(?P<measure>.+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'post_fcarform'),
                'permission_callback' => array($this, 'permit_levelTwo'),
            ) );

        }
    


        public function permit_levelOne(){
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

        public function permit_levelTwo(){
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

        public function sanitize_numberArray($param, $request, $key){
            $number_array = json_decode(urldecode($param));
            try{
                if (json_last_error() != 0){
                    throw new Exception(json_last_error_msg());
                }
                else{
                    for ($i = 0; $i < count($number_array); $i++){
                        if (!is_numeric($number_array[$i])){
                            throw new Exception($number_array[$i] . 'is not a proper id number');
                        }
                    }
                }
            }
            catch(Exception $e){
                return new WP_Error('invalid param', $e->getMessage(), array('status' => 400));
            }
            return $true;
        }

        public function get_viewresults( $data ) {
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

        public function get_clo( $data ) {
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

        public function get_programEducationalObjective( $data ) {
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

        public function put_course( $data ){
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

        public function post_course( $data ) {
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

        public function delete_course( $data ) {
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

        public function put_clo( $data ){
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

        public function post_clo( $data ) {
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

        public function delete_clo( $data ) {
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

        public function put_peo( $data ){
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

        public function post_peo( $data ) {
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

        public function delete_peo( $data ) {
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

        public function put_so( $data ){
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

        public function post_so( $data ) {
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

        public function delete_so( $data ) {
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

        public function get_measure( $data ){
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

        public function get_create_section( $data ) {
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
        
        public function post_alphaStage( $data ) {

            global $wpdb;

            $section_number = $data['section_number'];
            $clo_id = $data["clo_id"];
            $instructor = urldecode($data['instructor']);
            $term = urldecode($data['term']);

            try{
                $wpdb->query('START TRANSACTION;');
                        
                for ($i = 0; $i < count($section_number); $i++){
                    $wpdb->insert('pars_section',
                        array(
                            'course_id'=>$data['course_id'],
                            'instructor_id'=>$data['instructor_id'],
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

        public function get_clolist( $data ) {
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

        public function post_fcarform( $data ){
            global $wpdb;

            $measure = json_decode(urldecode($data['measure']));

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
    }

    $controller = new PARS_CUSTOM_ROUTE();
    add_action('rest_api_init', $controller->register_routes());
                                
?>