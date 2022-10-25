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

		//add_action( 'wp_head', array( $this, 'output_css' ) );

		add_action( 'wp_footer', array( $this, 'output_switcher' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_js' ) );
	
	}

	public function output_switcher() {

		//$styles = WP_Theme_JSON_Resolver::get_style_variations();

		$style_directory = WPZOOM_STYLE_SWITCHER_URL . 'assets/variations/';

		$styles = array(
			array(
				'title' => 'Default',
				'css'   => $style_directory . 'default.css',
				'color' => '#fff'
			),
			array(
				'title' => 'Bitter',
				'css'   => $style_directory . 'bitter.css',
				'color' => '#D80032'
			),
			array(
				'title' => 'Epilogue',
				'css'   => $style_directory . 'epilogue.css',
				'color' => '#FFD100'
			),
			array(
				'title' => 'Montserrat',
				'css'   => $style_directory . 'montserrat.css',
				'color' => '#5A13F1'
			),
			array(
				'title' => 'Poppins',
				'css'   => $style_directory . 'poppins.css',
				'color' => '#FF9505'
			),
			array(
				'title' => 'Yeseva One',
				'css'   => $style_directory . 'yeseva-one.css',
				'color' => '#40916C'
			)
		);

		if( empty( $styles ) ) {
			return;
		}
		
		$html = '<div class="wpzoom-style-picker no_display closed" style="display: block;">
        			<div class="content">
            			<h2 class="picker-title">Predefined Color Schemes</h2>
						<ul id="navigation">
                			<li>
                 				<div id="panel">
                    				<div style="padding:10px 0; min-height: 50px;">';
										 foreach( $styles as $style ) {
											$background = isset( $style['color'] ) ? ' style="background-color:' . $style['color'] . '"' : '';
											$html .= '<a href="' . $style['css'] . '" title="' . $style['title'] . '" class="' . sanitize_title( $style['title'] )  . '" data-style-variation="' . sanitize_title( $style['title'] ) . '"><span ' . $background . '></span></a>';
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
	}

	

}