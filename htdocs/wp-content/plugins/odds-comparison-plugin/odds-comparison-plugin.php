 <?php
/**
 * Plugin Name:       Advanced Odds Comparison
 * Plugin URI:        https://Sigma.world/
 * Description:       Fetches and displays live odds from various bookmakers. A solution for the Senior WordPress Developer Assignment.
 * Version:           1.0.0
 * Author:            Shubham Sharma
 * Author URI:        https://sigma.world/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       odds-comparison
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Define constants for the plugin.
 */
define( 'ODDS_COMPARISON_VERSION', '1.0.0' );
define( 'ODDS_COMPARISON_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ODDS_COMPARISON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require ODDS_COMPARISON_PLUGIN_DIR . 'includes/class-odds-comparison.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_odds_comparison() {

    $plugin = new Odds_Comparison();
    $plugin->run();

}
run_odds_comparison();
