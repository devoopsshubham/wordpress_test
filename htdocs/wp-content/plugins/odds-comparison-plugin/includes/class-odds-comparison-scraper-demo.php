<?php
/**
 * A demo scraper that provides hardcoded data for testing purposes.
 *
 * @link       https://example.com/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/includes
 */

class Odds_Comparison_Scraper_Demo {

    /**
     * Returns a hardcoded array of odds data for development and testing.
     * This method mimics the output of the live scraper.
     *
     * @since    1.0.0
     * @return   array    The structured demo odds data.
     */
    public function get_odds() {
        
        // This is our demo data. You can change these values to test different scenarios.
        $demo_data = array(
            'Manchester United vs. Liverpool' => array(
                'Bet365' => '2.50',
                'SkyBet' => '2.45',
                'William Hill' => '2.55',
                'Paddy Power' => '2.50',
            ),
            'Arsenal vs. Chelsea' => array(
                'Bet365' => '1.90',
                'SkyBet' => '1.95',
                'William Hill' => '1.85',
                'Paddy Power' => '1.92',
            ),
            'Manchester City vs. Tottenham' => array(
                'Bet365' => '1.50',
                'SkyBet' => '1.55',
                'William Hill' => '1.48',
                'Paddy Power' => 'N/A', // Example of a missing odd
            ),
            'Everton vs. Aston Villa' => array(
                'Bet365' => '3.10',
                'SkyBet' => '3.00',
                'William Hill' => '3.15',
                'Paddy Power' => '3.05',
            ),
        );

        return $demo_data;
    }
}
