<?php
/**
 * @package WPZOOM Style Switcher
 * @version 1.0
 */
/*
Plugin Name: WPZOOM Style Switcher
Plugin URI: https://www.wpzoom.com/plugins/
Author: WPZOOM
Version: 1.0
Author URI: https://www.wpzoom.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'WPZOOM_STYLE_SWITCHER_VERSION', '1.0.0' );

define( 'WPZOOM_STYLE_SWITCHER__FILE__', __FILE__ );
define( 'WPZOOM_STYLE_SWITCHER_PLUGIN_BASE', plugin_basename( WPZOOM_STYLE_SWITCHER__FILE__ ) );
define( 'WPZOOM_STYLE_SWITCHER_PLUGIN_DIR', dirname( WPZOOM_STYLE_SWITCHER_PLUGIN_BASE ) );

define( 'WPZOOM_STYLE_SWITCHER_PATH', plugin_dir_path( WPZOOM_STYLE_SWITCHER__FILE__ ) );
define( 'WPZOOM_STYLE_SWITCHER_URL', plugin_dir_url( WPZOOM_STYLE_SWITCHER__FILE__ ) );


// Instance the plugin 
WPZOOM_Style_Switcher::instance();

class WPZOOM_Style_Switcher {

	/**
	 * Instance
	 *
	 * @var WPZOOM_Style_Switcher The single instance of the class.
	 * @since 1.0.0
	 * @access private
	 * @static
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return WPZOOM_Style_Switcher An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_action( 'wp_head', array( $this, 'output_css' ) );

		add_action( 'wp_footer', array( $this, 'output_switcher' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_js' ) );
	
	}

	public function output_switcher() {

		$styles = WP_Theme_JSON_Resolver::get_style_variations();

		if( empty( $styles ) ) {
			return;
		}
		
		$html = '<div class="wpzoom-style-picker no_display closed" style="display: block;">
        			<div class="content">
            			<h2 class="picker-title">Predefined Color Schemes</h2>
						<ul id="navigation">
                			<li>
                 				<div id="panel">
                    				<div style="padding:10px 0; min-height: 50px;">
                         				<a title="Default" class="default active" href="#"><span></span></a>';
										 foreach( $styles as $style ) {
											$background = isset( $style['settings']['color']['palette']['theme'][0]['color'] ) ? ' style="background-color:' . $style['settings']['color']['palette']['theme'][0]['color'] . '"' : '';
											$html .= '<a href="#" title="' . $style['title'] . '" class="' . sanitize_title( $style['title'] )  . '" data-style-variation="' . sanitize_title( $style['title'] ) . '"><span ' . $background . '></span></a>';
										 }
		$html .=						'<div class="clear"></div>
                     				</div>
                  				</div>
							</li>
						</ul>
					</div>
				<div class="close-button">
					<a href="#"></a>
				</div>
			</div>';

		echo $html;
	}

	public function output_css() {

		$css = get_block_editor_theme_styles();

		//print_r( $wp_styles );

		$data = wp_get_global_settings();

		//print_r( $data );

	}

	/**
	 * Enqueue plugin styles.
	 */
	public function enqueue_css() {
	
		wp_enqueue_style( 
			'wpzoom-style-switcher', 
			WPZOOM_STYLE_SWITCHER_URL . 'assets/css/wpzoom-style-switcher.css', 
			WPZOOM_STYLE_SWITCHER_VERSION
		);
	
	}

	/**
	 * Enqueue plugin scripts.
	 */
	public function enqueue_js() {

		wp_enqueue_script( 
			'wpzoom-style-switcher-js', 
			WPZOOM_STYLE_SWITCHER_URL . 'assets/js/wpzoom-style-switcher.js', 
			array( 'jquery' ), 
			WPZOOM_STYLE_SWITCHER_VERSION,
			true 
		);
		wp_enqueue_script( 
			'wpzoom-style-switcher-values-js', 
			WPZOOM_STYLE_SWITCHER_URL . 'assets/js/wpzoom-style-switcher-values.js',
			array( 'jquery' ), 
			WPZOOM_STYLE_SWITCHER_VERSION,
			true 
		);
	
	}

	

}