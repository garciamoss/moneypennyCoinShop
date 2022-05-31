/**
  * Verify dependencies 
  * 
  * In this example, we check for plugins in this order:
  * - Widgets Logic
  * - Dynamic Widgets
  */
define(
    'WPSE_168484_ERROR'
    , __( 'Please install and activate <strong>Widgets Logic</strong> or <strong>Dynamic Widgets</strong> and use one of them to show only one widget per page, you can still use many iframes in the non-WordPress website.' )
);

function_exists( 'widget_logic_options_control' )
|| defined( 'DW_VERSION')
|| die( WPSE_168484_ERROR );

// Declare sidebar
register_sidebar( array(
    'name' => __( 'My Iframe', 'my_textdomain' ),
    'id' => 'my_iframe',
) );

// Show sidebar as HTML
add_action( 'init', 'my_iframe_widget' );
function my_iframe_widget() {
    if( is_active_sidebar( 'my_iframe' ) ) {

        // Get widget HTML
        ob_start();
        dynamic_sidebar( 'my_iframe' );
        $widget_html = ob_get_clean();

        // Remove wrapping <li>
        $widget_html = preg_replace( '/^<li.+>/', '', $widget_html );
        $widget_html = preg_replace( '/<\/li>$/m', '', $widget_html );

        // Make Valid HTML5 
        $widget_html = "<!doctype html><meta charset=utf-8>$widget_html";

        // Output and exit
        die( $widget_html );
    }
}