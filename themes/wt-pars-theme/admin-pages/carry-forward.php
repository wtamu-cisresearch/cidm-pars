<?php

    include get_stylesheet_directory().'\admin-pages\html\carry-forward.html';

    wp_enqueue_script( 'carry-forward' );

    global $wpdb;
    $years = $wpdb->get_results( "SELECT max(year) as year FROM ploclomap");

    echo '<script type="text/javascript"> document.getElementById("_yearInput").value = "' . $years[0]->year . '" </script>';

?>