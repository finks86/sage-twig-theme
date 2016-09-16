<?php
use Roots\Sage\Setup;

/**
 * Check if Timber is activated
 */

if ( ! class_exists( 'Timber' ) ) {

    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
    return;

}

/**
 * Timber
 */

class TwigSageTheme extends TimberSite {
    function __construct() {
        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        parent::__construct();
    }
    function add_to_context( $context ) {

        /* Add extra data */
        $context['foo'] = 'I am some other typical value set in your functions.php file, unrelated to the menu';

        $context['contact'] = do_shortcode('[contact-form-7 id="4" title="Kontaktformular 1"]');

        $args = array(
            // Get all posts
            'posts_per_page' => -1,
            'post_type' => 'page',
            'post__not_in' => array(74,76),
            // Order by meta value first, then order by post date
            'orderby' => array(
                'menu_order' => 'DESC',
            ),
        );

        $context['pages'] =  Timber::get_posts( $args );

        $args = array(
            // Get all posts
            'post_type' => 'page',
            'post__in' => array(74,76),
            // Order by meta value first, then order by post date
            'orderby' => array(
                'menu_order' => 'DESC',
            ),
        );
        $context['other_pages'] =  Timber::get_posts( $args );
        /* Menu */
        $context['menu'] = new TimberMenu('primary_navigation');

        /* Site info */
        $context['site'] = $this;

        /* Site info */
        $context['display_sidebar'] = Setup\display_sidebar();

        $context['sidebar_primary'] = Timber::get_widgets('sidebar-primary');

        return $context;

    }
}
new TwigSageTheme();
