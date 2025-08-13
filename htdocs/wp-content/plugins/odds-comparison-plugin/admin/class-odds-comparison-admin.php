<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/admin
 * @author     Your Name <email@example.com>
 */
class Odds_Comparison_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/odds-comparison-admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/odds-comparison-admin.js', array( 'jquery' ), $this->version, false );
    }

    /**
     * Add an options page under the settings menu.
     *
     * @since    1.0.0
     */
    public function add_options_page() {
        add_options_page(
            'Odds Comparison Settings',
            'Odds Comparison',
            'manage_options',
            $this->plugin_name,
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function create_admin_page() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/odds-comparison-admin-display.php';
    }

    /**
     * Register the settings for this plugin.
     *
     * @since    1.0.0
     */
    public function register_settings() {
        register_setting(
            $this->plugin_name, // Option group
            'odds_comparison_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Bookmaker & Market Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            $this->plugin_name // Page
        );

        add_settings_field(
            'bookmakers', // ID
            'Bookmakers', // Title
            array( $this, 'bookmakers_callback' ), // Callback
            $this->plugin_name, // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'markets',
            'Markets',
            array( $this, 'markets_callback' ),
            $this->plugin_name,
            'setting_section_id'
        );
        
        add_settings_field(
            'bookmaker_links',
            'Bookmaker Links',
            array( $this, 'bookmaker_links_callback' ),
            $this->plugin_name,
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @since  1.0.0
     * @param array $input Contains all settings fields as array keys
     * @return array
     */
    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input['bookmakers'] ) )
            $new_input['bookmakers'] = sanitize_textarea_field( $input['bookmakers'] );

        if( isset( $input['markets'] ) )
            $new_input['markets'] = sanitize_textarea_field( $input['markets'] );
            
        if( isset( $input['bookmaker_links'] ) )
            $new_input['bookmaker_links'] = sanitize_textarea_field( $input['bookmaker_links'] );

        return $new_input;
    }

    /**
     * Print the Section text
     *
     * @since 1.0.0
     */
    public function print_section_info() {
        print 'Enter your settings below. For Bookmakers, Markets and Links, enter one item per line.';
    }

    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.0.0
     */
    public function bookmakers_callback() {
        $options = get_option( 'odds_comparison_options' );
        printf(
            '<textarea id="bookmakers" name="odds_comparison_options[bookmakers]" rows="5" cols="50">%s</textarea>',
            isset( $options['bookmakers'] ) ? esc_attr( $options['bookmakers']) : ''
        );
    }
    
    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.0.0
     */
    public function markets_callback() {
        $options = get_option( 'odds_comparison_options' );
        printf(
            '<textarea id="markets" name="odds_comparison_options[markets]" rows="5" cols="50">%s</textarea>',
            isset( $options['markets'] ) ? esc_attr( $options['markets']) : ''
        );
    }
    
    /**
     * Get the settings option array and print one of its values
     *
     * @since 1.0.0
     */
    public function bookmaker_links_callback() {
        $options = get_option( 'odds_comparison_options' );
        printf(
            '<textarea id="bookmaker_links" name="odds_comparison_options[bookmaker_links]" rows="5" cols="50">%s</textarea><p class="description">Enter links in the same order as the bookmakers above. Format: Bookmaker Name|http://yourlink.com</p>',
            isset( $options['bookmaker_links'] ) ? esc_attr( $options['bookmaker_links']) : ''
        );
    }
}
