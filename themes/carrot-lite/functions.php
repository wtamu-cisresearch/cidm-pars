<?php
if ( ! isset( $content_width ) )
$content_width = 780;

/*
 *  Theme setup
 */
add_action('after_setup_theme', 'carrotlite_setup');
function carrotlite_setup() {
    add_editor_style();
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('html5');
    add_theme_support('custom-background');
    add_theme_support('title-tag');

    set_post_thumbnail_size(780, 520, true); // Default size
    add_image_size('grid', 400, 300, true);

    load_theme_textdomain('carrotlite', get_template_directory() . '/languages'); 

    register_nav_menus(
        array(
          'primary' => __('Main menu', 'carrotlite'),
          'secondary' => __('Footer menu', 'carrotlite')
        )
    );
}

/*
 *  Initializing widgeted areas
 */
add_action('widgets_init', 'carrotlite_widgeted_areas');
function carrotlite_widgeted_areas() {
    register_sidebar(array(
        'name' => __( 'Sidebar', 'carrotlite'),
        'id' => 'sidebar-widget-area',
        'description' => __( 'Sidebar widget area', 'carrotlite'),
        'before_widget' => '<article class="widget">',
        'after_widget' => '</article>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));
    register_sidebar(array(
        'name' => __( 'Footer', 'carrotlite'),
        'id' => 'footer-widget-area',
        'description' => __( 'Footer widget area', 'carrotlite'),
        'before_widget' => '<article class="widget col col3">',
        'after_widget' => '</article>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));
}

/*
 *  Placeholder for empty post title
 */
add_filter('the_title', 'carrotlite_title');
function carrotlite_title($title) {
    if ($title == '') {
        return __('Untitled', 'carrotlite');
    } else {
        return $title;
    }
} 

/*
 *  Scripts and styles
 */
add_action('wp_enqueue_scripts', 'carrotlite_scripts');
function carrotlite_scripts() {
    wp_enqueue_style( 'fontUbuntu', '//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700,700italic&subset=latin,latin-ext');
    wp_enqueue_style( 'fontOpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic&subset=latin,latin-ext');
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

    wp_enqueue_script('basic', get_template_directory_uri().'/js/script.js', array('jquery'), 1, true);
    global $is_IE;
    if ( $is_IE ) {
        wp_enqueue_script('html5', get_template_directory_uri() . '/js/html5.js');
    }
}

/*
 *  Nicer <title>
 */
add_filter('wp_title', 'carrotlite_filter_wp_title');
function carrotlite_filter_wp_title( $title ) {
    global $page, $paged;

    $site_name = get_bloginfo( 'name' );
    $filtered_title = $title .' | '. $site_name;

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ){
        $filtered_title = $site_name .' | '.$site_description;
    }

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 ) {
        $filtered_title .= ' | ' . sprintf( __( 'Page %s', 'carrotlite'), max( $paged, $page ) );
    }

    return $filtered_title;
}

/*
 *  Making gallery with links to media files distinguishable from the one with links to attachment pages
 */
add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

add_filter('post_gallery', 'carrotlite_gallery', 10, 2);
function carrotlite_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery";

    $gallery_style = $gallery_div = '';

    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $file_link = "";
        $link = wp_get_attachment_link($id, $size, true, false);
        if (isset($attr['link'])) {
            if ('file' == $attr['link']) {
                $link =  wp_get_attachment_link($id, $size, false, false);
            }
            if('file' == $attr['link']) $file_link = 'file-link';
        }
        
        $output .= "<{$itemtag} class='gallery-item {$file_link}'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                {$link}
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
    }

    $output .= "
        </div>\n";

    return $output;
}

/*
 *  Custom comment HTML
 */
function carrotlite_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);
?>
        <li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
        <div id="div-comment-<?php comment_ID() ?>">
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>  
            <cite class="fn"><?php echo get_comment_author_link() ?></cite>
            <p class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo get_comment_date(); __('at', 'carrotlite') ?> <?php echo get_comment_time() ?></a> | <i class="fa fa-comments"></i> <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
            
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'carrotlite') ?></p>
        <?php endif; ?>
        <div class="comment-body"><?php comment_text() ?></div>
        </div>
<?php
}

/*
 *  Custom comment form HTML code
 */
function carrotlite_comment_form_args() {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<p><label for="author">'.__( 'Name', 'carrotlite' ).( $req ? ' <span class="required">*</span>' : '' ).'</label><input id="author" name="author"'. $aria_req . ' type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"></p>',
        'email' => '<p><label for="email">' . __( 'Email', 'carrotlite' ) .( $req ? ' <span class="required">*</span>' : '' ). '</label><input id="email" name="email"' . $aria_req . ' type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'"></p>',
        'url' => '<p><label for="url">' . __( 'Website', 'carrotlite' ) . '</label><input id="url" name="url"' . $aria_req . ' type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'"></p>'
    );

    $comment_field = '<p><label for="comment">' . __( 'Comment', 'carrotlite' ) . '</label><textarea name="comment" id="comment" rows="8" cols="50"></textarea></p>';
    return array('fields' => $fields, 'comment_field' => $comment_field, 'label_submit' => __('Post this!', 'carrotlite'));
}

/*
 *  Sanitization of slogan text
 */
function carrotlite_sanitize($str) {
    $filtered = wp_check_invalid_utf8( $str );
    if ( strpos($filtered, '<') !== false ) {
        $filtered = wp_pre_kses_less_than( $filtered );
        // This will strip extra whitespace for us.
        $filtered = strip_tags( $filtered, "<a><strong>" );
    } else {
           $filtered = trim( preg_replace('/[\r\n\t ]+/', ' ', $filtered) );
    }

    $found = false;
    while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
           $filtered = str_replace($match[0], '', $filtered);
           $found = true;
    }

    if ( $found ) {
           // Strip out the whitespace that may now exist after removing the octets.
           $filtered = trim( preg_replace('/ +/', ' ', $filtered) );
    }
    return apply_filters( 'sanitize_text_field', $filtered, $str );
}

/*
 *  Fallback function for menus
 */
function carrotlite_page_menu() {
    if (is_page()) { 
        $highlight = "page_item"; 
    } else {
        $highlight = "menu-item current-menu-item"; 
    }
    echo '<ul class="menu">';
    wp_list_pages('container=&sort_column=menu_order&title_li=&link_before=&link_after=&depth=3');
    echo '</ul>';
}

/*
 *  Customizations
 */
add_action( 'customize_register', 'carrotlite_customize_register' );
function carrotlite_customize_register($wp_customize) {
    $wp_customize->add_section('frontpage', array(
        'title' => __('Home page message', 'carrotlite')
    ));

    if( class_exists( 'WP_Customize_Control' ) ):
        class WP_Customize_Textarea_Control extends WP_Customize_Control {
            public $type = 'textarea';
     
            public function render_content() {
                ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
            }
        }
    endif;

    $wp_customize->add_setting('home_msg', array('sanitize_callback' => 'carrotlite_sanitize'));
    $wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'home_msg', array(
        'label' => __('Enter your home page message here:', 'carrotlite'),
        'section' => 'frontpage',
        'settings' => 'home_msg'
    ) ) );
}