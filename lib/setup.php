<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup()
{
    // Enable features from Soil when plugin is activated
    // https://roots.io/plugins/soil/
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-relative-urls');

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('sage', get_template_directory() . '/lang');

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage')

    ]);

    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');
    // Enable post formats
    // http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
    add_editor_style(Assets\asset_path('styles/main.css'));
}

add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init()
{
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ]);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ]);
}

add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar()
{
    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_404(),
        is_front_page(),
        is_page_template('template-custom.php'),
    ]);

    return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets()
{
    wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


/*
* Creating a function to create our CPT
*/

function persons()
{

// Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Personen', 'Post Type General Name', 'twentythirteen'),
        'singular_name' => _x('Person', 'Post Type Singular Name', 'twentythirteen'),
        'menu_name' => __('Personen', 'twentythirteen'),
//		'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
//		'all_items'           => __( 'All Movies', 'twentythirteen' ),
//		'view_item'           => __( 'View Movie', 'twentythirteen' ),
//		'add_new_item'        => __( 'Add New Movie', 'twentythirteen' ),
//		'add_new'             => __( 'Add New', 'twentythirteen' ),
//		'edit_item'           => __( 'Edit Movie', 'twentythirteen' ),
//		'update_item'         => __( 'Update Movie', 'twentythirteen' ),
//		'search_items'        => __( 'Search Movie', 'twentythirteen' ),
//		'not_found'           => __( 'Not Found', 'twentythirteen' ),
//		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );

// Set other options for Custom Post Type

    $args = array(
        'label' => __('persons', 'twentythirteen'),
        'description' => __('Personen', 'twentythirteen'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes'),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'taxonomies' => array('genres'),

        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 3,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    // Registering your Custom Post Type
    register_post_type('persons', $args);

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action('init', __NAMESPACE__ . '\\persons', 0);


//hook into the init action and call create_book_taxonomies when it fires
add_action('init', __NAMESPACE__ . '\\create_topics_hierarchical_taxonomy', 0);

//create a custom taxonomy name it topics for your posts

function create_topics_hierarchical_taxonomy()
{

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x('Gruppen', 'taxonomy general name'),
        'singular_name' => _x('Gruppe', 'taxonomy singular name'),

    );

// Now register the taxonomy

    register_taxonomy('groups', array('persons'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_in_menu' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'group'),
    ));

}

