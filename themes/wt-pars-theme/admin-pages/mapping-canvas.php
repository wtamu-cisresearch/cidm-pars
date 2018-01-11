<?php 
    include get_stylesheet_directory().'\admin-pages\html\mapping-canvas.html';
    
    wp_enqueue_style( 'admin' );

    wp_enqueue_script( 'mapping-canvas' );

    echo "<div class='box'></div> <div class='box'></div>"
?>