<?php
/**
 * The odds conversion functionality of the plugin.
 *
 * @link       https://example.com/
 * @since      1.0.0
 *
 * @package    Odds_Comparison
 * @subpackage Odds_Comparison/includes
 */

class Odds_Comparison_Converter {

    /**
     * Converts decimal odds to fractional odds.
     *
     * @since    1.0.0
     * @param    float    $decimal    The decimal odds (e.g., 2.50).
     * @return   string   The fractional odds (e.g., "3/2").
     */
    public static function decimal_to_fractional($decimal) {
        if ($decimal <= 1) {
            return '1/1'; // Or handle as an error
        }
        $value = $decimal - 1;
        $tolerance = 1.e-6;
        $h1 = 1; $h2 = 0;
        $k1 = 0; $k2 = 1;
        $b = $value;
        do {
            $a = floor($b);
            $aux = $h1; $h1 = $a * $h1 + $h2; $h2 = $aux;
            $aux = $k1; $k1 = $a * $k1 + $k2; $k2 = $aux;
            $b = 1 / ($b - $a);
        } while (abs($value - $h1 / $k1) > $value * $tolerance);

        return $h1 . '/' . $k1;
    }

    /**
     * Converts decimal odds to American odds.
     *
     * @since    1.0.0
     * @param    float    $decimal    The decimal odds (e.g., 2.50).
     * @return   int      The American odds (e.g., 150 or -200).
     */
    public static function decimal_to_american($decimal) {
        if ($decimal >= 2.00) {
            return round(($decimal - 1) * 100);
        } else {
            return round(-100 / ($decimal - 1));
        }
    }

    /**
     * Converts fractional odds to decimal odds.
     *
     * @since    1.0.0
     * @param    string   $fraction    The fractional odds (e.g., "3/2").
     * @return   float    The decimal odds (e.g., 2.50).
     */
    public static function fractional_to_decimal($fraction) {
        list($numerator, $denominator) = explode('/', $fraction);
        if ($denominator == 0) {
            return 1.0; // Avoid division by zero
        }
        return ($numerator / $denominator) + 1;
    }

    /**
     * Converts fractional odds to American odds.
     *
     * @since    1.0.0
     * @param    string   $fraction    The fractional odds (e.g., "3/2").
     * @return   int      The American odds (e.g., 150).
     */
    public static function fractional_to_american($fraction) {
        $decimal = self::fractional_to_decimal($fraction);
        return self::decimal_to_american($decimal);
    }

    /**
     * Converts American odds to decimal odds.
     *
     * @since    1.0.0
     * @param    int      $american    The American odds (e.g., 150 or -200).
     * @return   float    The decimal odds (e.g., 2.50).
     */
    public static function american_to_decimal($american) {
        if ($american > 0) {
            return ($american / 100) + 1;
        } else {
            return (100 / abs($american)) + 1;
        }
    }

    /**
     * Converts American odds to fractional odds.
     *
     * @since    1.0.0
     * @param    int      $american    The American odds (e.g., 150).
     * @return   string   The fractional odds (e.g., "3/2").
     */
    public static function american_to_fractional($american) {
        if ($american > 0) {
            $numerator = $american;
            $denominator = 100;
        } else {
            $numerator = 100;
            $denominator = abs($american);
        }
        $common_divisor = self::gcd($numerator, $denominator);
        return ($numerator / $common_divisor) . '/' . ($denominator / $common_divisor);
    }
    
    /**
     * Finds the greatest common divisor of two numbers.
     *
     * @since    1.0.0
     * @access   private
     * @param    int      $a    First number.
     * @param    int      $b    Second number.
     * @return   int      The greatest common divisor.
     */
    private static function gcd($a, $b) {
        return ($b) ? self::gcd($b, $a % $b) : $a;
    }
}
