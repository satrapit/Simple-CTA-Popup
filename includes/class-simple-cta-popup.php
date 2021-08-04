<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://arsamnet.com
 * @since      1.0.0
 *
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Simple_CTA_Popup
 * @subpackage Simple_CTA_Popup/includes
 * @author     Majid Barkhordari <info@arsamnet.com>
 */
class Simple_CTA_Popup {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Simple_CTA_Popup_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $simple_cta_popup    The string used to uniquely identify this plugin.
	 */
	protected $simple_cta_popup;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_post_type    The custom post type of the plugin.
	 */
	protected $plugin_post_type;

	/**
	 * Define the custom post type of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SIMPLE_CTA_POPUP_VERSION' ) ) {
			$this->version = SIMPLE_CTA_POPUP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->simple_cta_popup = 'simple-cta-popup';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->regiseter_custom_post_types();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Simple_CTA_Popup_Loader. Orchestrates the hooks of the plugin.
	 * - Simple_CTA_Popup_i18n. Defines internationalization functionality.
	 * - Simple_CTA_Popup_Admin. Defines all hooks for the admin area.
	 * - Simple_CTA_Popup_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-cta-popup-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-cta-popup-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-cta-popup-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-simple-cta-popup-public.php';

		$this->loader = new Simple_CTA_Popup_Loader();

		/**
		 * The class responsible for defining all custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-cta-popup-post-type.php';

		$this->plugin_post_type = new Simple_CTA_Popup_Post_Types();

		/**
		 * The class responsible for defining all custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-cta-popup-shortcode.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Simple_CTA_Popup_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Simple_CTA_Popup_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Simple_CTA_Popup_Admin( $this->get_simple_cta_popup(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Simple_CTA_Popup_Public( $this->get_simple_cta_popup(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_simple_cta_popup() {
		return $this->simple_cta_popup;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Simple_CTA_Popup_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all custom post type
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function regiseter_custom_post_types() {
        $this->loader->add_action( 'init', $this->plugin_post_type, 'register_simple_cta_popups_post_type', 999 );
        $this->loader->add_action( 'add_meta_boxes', $this->plugin_post_type, 'setting_meta_box' );
        $this->loader->add_action( 'save_post', $this->plugin_post_type, 'setting_meta_box_save' );
    }

}