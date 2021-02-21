<?php
namespace ElementsKit_Lite\Widgets\Init;
use ElementsKit_Lite\Libs\Framework\Attr;

defined( 'ABSPATH' ) || exit;

class Enqueue_Scripts{

    public function __construct() {

        add_action( 'wp_enqueue_scripts', [$this, 'frontend_js']);
        add_action( 'wp_enqueue_scripts', [$this, 'frontend_css'], 99 );

        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );
        add_action( 'elementor/editor/after_enqueue_styles', [$this, 'elementor_css'] );

        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_3rd_party_style' ] );
    }

    public function elementor_js() {
        // Register Scripts
        wp_register_script( 'ekit-slick', \ElementsKit_Lite::widget_url() . 'init/assets/js/slick.min.js', [], \ElementsKit_Lite::version(), true );

        // Enqueue Scripts
        wp_enqueue_script( 'elementskit-elementor', \ElementsKit_Lite::widget_url() . 'init/assets/js/elementor.js', ['jquery', 'elementor-frontend', 'ekit-slick'], \ElementsKit_Lite::version(), true );

        // added fluent form styles on the editor
        if (in_array('fluentform/fluentform.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            wp_enqueue_style( 'fluent-form-styles' );
            wp_enqueue_style( 'fluentform-public-default' );
        }
       
    }

    public function elementor_css() {
        wp_enqueue_style( 'elementskit-panel', \ElementsKit_Lite::widget_url() . 'init/assets/css/editor.css', null, \ElementsKit_Lite::version() );
    }

    public function frontend_js() {
        if(is_admin()){
            return;
        }
            
        /*
        * Register scripts.
        * This scripts are only loaded when the associated widget is being used on a page.
        */
        wp_enqueue_script( 'ekit-widget-scripts', \ElementsKit_Lite::widget_url() . 'init/assets/js/widget-scripts.js', array( 'jquery' ), \ElementsKit_Lite::version(), true ); // Core most of the widgets init are bundled //
        wp_register_script( 'goodshare', \ElementsKit_Lite::widget_url() . 'init/assets/js/goodshare.min.js', array( 'jquery' ), false, true ); // sosial share //       
        wp_register_script( 'datatables', \ElementsKit_Lite::widget_url() . 'init/assets/js/datatables.min.js', array( 'jquery' ), false, true ); // table //

        $user_data = Attr::instance()->utils->get_option('user_data', []);
        $gmap_api_key = !empty($user_data['google_map']) ? $user_data['google_map']['api_key'] : '';
        wp_register_script( 'ekit-google-map-api', 'https://maps.googleapis.com/maps/api/js?key=' . $gmap_api_key . '', array('jquery'), false, true );
        wp_register_script( 'ekit-google-gmaps', \ElementsKit_Lite::widget_url() . 'init/assets/js/gmaps.min.js', array('jquery'), false, true );
        
    }
    public function frontend_css() {
        if(!is_admin()){
            wp_enqueue_style( 'ekit-widget-styles', \ElementsKit_Lite::widget_url() . 'init/assets/css/widget-styles.css', false, \ElementsKit_Lite::version() );

            wp_enqueue_style( 'ekit-responsive', \ElementsKit_Lite::widget_url() . 'init/assets/css/responsive.css', false, \ElementsKit_Lite::version() );
        };




        if ( is_rtl() ) wp_enqueue_style( 'elementskit-rtl', \ElementsKit_Lite::widget_url() . 'init/assets/css/rtl.css', false, \ElementsKit_Lite::version() );
    }

    public function enqueue_3rd_party_style() {
        if (function_exists( 'weforms' )) {
            wp_enqueue_style( 'weforms', plugins_url('/weforms/assets/wpuf/css/frontend-forms.css', 'weforms' ), false, \ElementsKit_Lite::version() );
        }

        if(defined('WPFORMS_PLUGIN_SLUG')){
            wp_enqueue_style( 'wpforms', plugins_url( '/'. WPFORMS_PLUGIN_SLUG . '/assets/css/wpforms-full.css', WPFORMS_PLUGIN_SLUG ), false, \ElementsKit_Lite::version() );
        }
    }
}