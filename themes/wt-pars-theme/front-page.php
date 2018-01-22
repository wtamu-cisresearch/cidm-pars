<?php 
    get_header();

    wp_enqueue_script( 'test' );
    wp_localize_script( 'test', 'settings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

    echo ("Main page");

    get_footer();
?>

