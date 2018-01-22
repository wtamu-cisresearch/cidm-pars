<?php 

    global $wpdb;

    include get_stylesheet_directory().'\admin-pages\html\mapping-canvas.html';
    
    wp_enqueue_style( 'admin' );

    wp_enqueue_script( 'mapping-canvas' );
    wp_localize_script( 'mapping-canvas', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    echo ("
        <div class='jacket'>
            <h3 class='headline'>Mapping Canvas</h3>
            <hr class='underline'><div>" .  popClo($wpdb) . "</div>
        </div>");

    function popClo($wpdb){
        $div = "";
        $records = $wpdb->get_results( 
            "SELECT
                pars_course_learning_outcome.code,
                pars_course_learning_outcome.description
            FROM
                pars_alpha,
                pars_course_learning_outcome
            WHERE
                pars_course_learning_outcome.clo_id = pars_alpha.clo_id AND pars_alpha.enable = 0
            GROUP BY pars_course_learning_outcome.clo_id");

        foreach ( $records as $record ) {
            $div = $div . "<div class='box box-clo'>" . $record->code . "</div>";
        }
        return $div;
    }
?>