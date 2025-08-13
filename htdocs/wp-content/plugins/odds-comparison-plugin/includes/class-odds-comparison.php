<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sigma.world/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/includes
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
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/includes
 * @author     Your Name <support@sigma.world>
 */
class Odds_Comparison {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Odds_Comparison_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'ODDS_COMPARISON_VERSION' ) ) {
            $this->version = ODDS_COMPARISON_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'odds-comparison';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_gutenberg_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Odds_Comparison_Loader. Orchestrates the hooks of the plugin.
     * - Odds_Comparison_i18n. Defines internationalization functionality.
     * - Odds_Comparison_Admin. Defines all hooks for the admin area.
     * - Odds_Comparison_Public. Defines all hooks for the public side of the site.
     * - Odds_Comparison_Scraper. Handles scraping of odds data.
     * - Odds_Comparison_Converter. Handles odds format conversions.
     * - Odds_Comparison_Gutenberg. Handles the Gutenberg block.
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
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison-i18n.php';
        
        /**
         * The class responsible for handling odds conversions.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison-converter.php';

        /**
         * The class responsible for scraping odds data.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison-scraper.php';
require_once ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison-scraper-demo.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'admin/class-odds-comparison-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'public/class-odds-comparison-public.php';
        
        /**
         * The class responsible for the Gutenberg block.
         */
        require_once ODDS_COMPARISON_PLUGIN_DIR . 'gutenberg/class-odds-comparison-gutenberg.php';


        $this->loader = new Odds_Comparison_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Odds_Comparison_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Odds_Comparison_i18n();

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

        $plugin_admin = new Odds_Comparison_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Odds_Comparison_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    }
    
    /**
     * Register all of the hooks related to the Gutenberg block functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_gutenberg_hooks() {
        $gutenberg_block = new Odds_Comparison_Gutenberg( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'init', $gutenberg_block, 'register_block' );
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
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Odds_Comparison_Loader    Orchestrates the hooks of the plugin.
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

}
