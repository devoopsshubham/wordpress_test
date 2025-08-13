<?php
/**
 * The scraper functionality of the plugin.
 *
 * @link       https://example.com/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/includes
 */

class Odds_Comparison_Scraper {

    /**
     * The URL to scrape.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $scrape_url    The URL of the odds comparison site.
     */
    private $scrape_url = 'https://www.oddschecker.com/football/english/premier-league'; // Example URL

    /**
     * The cache key for the transient.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $cache_key    The key for the transient.
     */
    private $cache_key = 'odds_comparison_data';

    /**
     * The cache expiration time in seconds.
     *
     * @since    1.0.0
     * @access   private
     * @var      int    $cache_expiration    Cache duration (e.g., 1 hour).
     */
    private $cache_expiration = 3600;

    /**
     * Fetches the odds data, either from cache or by scraping.
     *
     * @since    1.0.0
     * @return   array|false    The structured odds data, or false on failure.
     */
    public function get_odds() {
        // Try to get data from cache first
        $cached_data = get_transient( $this->cache_key );
        if ( false !== $cached_data ) {
            return $cached_data;
        }

        // If cache is empty, scrape the data
        $scraped_data = $this->scrape_site();

        // If scraping was successful, store it in the cache
        if ( $scraped_data ) {
            set_transient( $this->cache_key, $scraped_data, $this->cache_expiration );
            return $scraped_data;
        }

        return false;
    }

    /**
     * Scrapes the odds comparison website.
     *
     * @since    1.0.0
     * @access   private
     * @return   array|false    The structured odds data, or false on failure.
     */
    private function scrape_site() {
        $response = wp_remote_get( $this->scrape_url, array( 'timeout' => 20 ) );

        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
            // Failed to fetch the page
            error_log('Odds Comparison Plugin: Failed to fetch URL: ' . $this->scrape_url);
            return false;
        }

        $html = wp_remote_retrieve_body( $response );
        if ( empty( $html ) ) {
            return false;
        }

        // Use DOMDocument to parse the HTML, suppressing errors from malformed HTML
        $dom = new DOMDocument();
        @$dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );

        $data = array();

        // ========================================================================
        // IMPORTANT: The XPath queries below are placeholders.
        // You MUST inspect the target website's HTML structure and replace these
        // queries with the correct ones to extract the data you need.
        // ========================================================================

        // Example: Scraping a table of matches
        // This query assumes matches are in rows (<tr>) within a table body.
        $match_rows = $xpath->query('//tbody/tr[@class="match-row"]'); // <-- REPLACE THIS QUERY

        foreach ( $match_rows as $row ) {
            $match_name_node = $xpath->query('.//td[@class="match-name"]', $row)->item(0); // <-- REPLACE THIS QUERY
            $match_name = $match_name_node ? trim($match_name_node->nodeValue) : 'Unknown Match';
            
            $odds_data = [];
            
            // This query assumes bookmakers and their odds are in cells (<td>) within the row
            $bookmaker_odds_nodes = $xpath->query('.//td[contains(@class, "bookmaker-odds")]', $row); // <-- REPLACE THIS QUERY
            
            foreach ($bookmaker_odds_nodes as $node) {
                $bookmaker_name = $node->getAttribute('data-bookmaker'); // <-- REPLACE THIS ATTRIBUTE
                $odd_value = trim($node->nodeValue);
                
                if (!empty($bookmaker_name) && !empty($odd_value)) {
                    $odds_data[$bookmaker_name] = $odd_value;
                }
            }

            if (!empty($odds_data)) {
                $data[$match_name] = $odds_data;
            }
        }

        if ( empty( $data ) ) {
            // Log an error if no data was scraped, which might indicate a change in the site's HTML structure.
            error_log('Odds Comparison Plugin: Scraping completed but no data was extracted. The website structure may have changed.');
            return false;
        }

        return $data;
    }
}
