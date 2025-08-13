<?php
/**
 * The Gutenberg block functionality of the plugin.
 *
 * @link       https://example.com/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/gutenberg
 */

class Odds_Comparison_Gutenberg {

    /**
     * The ID of this plugin.
     * @var string
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     * @var string
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Registers the Gutenberg block.
     */
    public function register_block() {
        // Check if the function exists.
        if (!function_exists('register_block_type')) {
            return;
        }

        // Register the block editor script.
        wp_register_script(
            $this->plugin_name . '-block-editor',
            plugin_dir_url(__FILE__) . 'build/index.js',
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components'),
            $this->version,
            true
        );

        // Register the block editor styles.
        wp_register_style(
            $this->plugin_name . '-block-editor-style',
            plugin_dir_url(__FILE__) . 'build/index.css',
            array('wp-edit-blocks'),
            $this->version
        );
        
        // Register the front-end styles.
        wp_register_style(
            $this->plugin_name . '-block-style',
            plugin_dir_url(__FILE__) . 'build/style-index.css',
            array(),
            $this->version
        );

        // Register the block.
        register_block_type('odds-comparison/odds-block', array(
            'editor_script' => $this->plugin_name . '-block-editor',
            'editor_style'  => $this->plugin_name . '-block-editor-style',
            'style'         => $this->plugin_name . '-block-style',
            'attributes'    => array(
                'selectedBookmakers' => array(
                    'type' => 'array',
                    'default' => array(),
                ),
                'selectedMarket' => array(
                    'type' => 'string',
                    'default' => '',
                ),
            ),
            'render_callback' => array($this, 'render_block_frontend'),
        ));
        
        // Localize script to pass data from PHP to our block's JavaScript
        $options = get_option('odds_comparison_options');
        $bookmakers_raw = isset($options['bookmakers']) ? $options['bookmakers'] : '';
        $bookmakers_list = !empty($bookmakers_raw) ? array_map('trim', explode("\n", $bookmakers_raw)) : [];
        
        wp_localize_script(
            $this->plugin_name . '-block-editor',
            'oddsComparisonBlockData',
            array(
                'bookmakers' => $bookmakers_list,
            )
        );
    }

    /**
     * Renders the block on the front end.
     *
     * @param array $attributes The block attributes.
     * @return string The HTML to render.
     */
    public function render_block_frontend($attributes) {
        // Use the Demo Scraper for reliable data during development
        $scraper = new Odds_Comparison_Scraper_Demo();
        $all_odds_data = $scraper->get_odds();

        if (empty($all_odds_data)) {
            return '<p>Odds are currently unavailable.</p>';
        }

        $selected_bookmakers = isset($attributes['selectedBookmakers']) ? $attributes['selectedBookmakers'] : array();
        
        // Start output buffering to capture the HTML
        ob_start();
        ?>
        <div class="odds-comparison-table-wrapper">
            <h3><?php echo esc_html(isset($attributes['selectedMarket']) ? $attributes['selectedMarket'] : 'Match Odds'); ?></h3>
            <table class="odds-comparison-table">
                <thead>
                    <tr>
                        <th>Match</th>
                        <?php foreach ($selected_bookmakers as $bookie) : ?>
                            <th><?php echo esc_html($bookie); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_odds_data as $match => $odds) : ?>
                        <tr>
                            <td><?php echo esc_html($match); ?></td>
                            <?php foreach ($selected_bookmakers as $bookie) : ?>
                                <td>
                                    <?php echo isset($odds[$bookie]) ? esc_html($odds[$bookie]) : 'N/A'; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        // Return the captured HTML content
        return ob_get_clean();
    }
}
