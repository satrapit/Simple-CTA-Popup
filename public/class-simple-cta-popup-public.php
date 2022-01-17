<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://arsamnet.com
 * @since      1.0.0
 *
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/public
 * @author     Your Name <email@example.com>
 */
class Simple_CTA_Popup_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $simple_cta_popup    The ID of this plugin.
	 */
	private $simple_cta_popup;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $simple_cta_popup       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $simple_cta_popup, $version ) {

		$this->simple_cta_popup = $simple_cta_popup;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_CTA_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_CTA_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->simple_cta_popup, plugin_dir_url( __FILE__ ) . 'css/simple-cta-popup-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_CTA_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_CTA_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->simple_cta_popup, plugin_dir_url( __FILE__ ) . 'js/simple-cta-popup-public.js', array( 'jquery' ), $this->version, false );

	}

}
