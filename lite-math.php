<?php
/**
 * Plugin Name: 🧮 Lite Math
 * Plugin URI: https://erik.marketing
 * Description: Streamline your RankMath SEO workflow by focusing on essential metrics. 
 * This lightweight plugin modifies RankMath's scoring system to prioritize core SEO elements
 * while removing auxiliary tests, resulting in a more focused and efficient content optimization process.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: ErikMarketing
 * Author URI: https://erik.marketing
 * License: GPL v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: lite-math
 * Domain Path: /languages
 *
 * @package LiteMath
 * @author ErikMarketing
 * @link https://erik.marketing
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('LITE_MATH_VERSION', '1.0.0');

/**
 * Class Lite_Math
 */
class Lite_Math {
    /**
     * Constructor
     */
    public function __construct() {
        // Only run if RankMath is active
        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        if (!class_exists('RankMath')) {
            add_action('admin_notices', array($this, 'rank_math_missing_notice'));
            return;
        }

        // Add filter to modify RankMath tests
        add_filter('rank_math/researches/tests', array($this, 'modify_rank_math_tests'), 10, 2);
    }

    /**
     * Display admin notice if RankMath is not active
     */
    public function rank_math_missing_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Lite Math requires RankMath SEO plugin to be installed and activated.', 'lite-math'); ?></p>
        </div>
        <?php
    }

    /**
     * Modify RankMath SEO score tests
     *
     * @param array $tests Array of tests
     * @param string $type Type of content being tested
     * @return array Modified tests array
     */
    public function modify_rank_math_tests($tests, $type) {
        // Tests that remain active (recommended minimum)
        // Uncomment the lines below to disable these core tests
        //unset($tests['keywordInTitle']); // Keyword in Title test
        //unset($tests['keywordInContent']); // Keyword in Content test
        //unset($tests['keywordInMetaDescription']); // Keyword in Meta Description test
        //unset($tests['keywordNotUsed']); // Keyword Not Used test

        // Disable additional tests
        $tests_to_disable = array(
            'contentHasAssets',          // Contents have Images/Audio/Visuals
            'contentHasShortParagraphs', // Short Paragraphs test
            'contentHasTOC',             // Table of Contents test
            'hasContentAI',              // Content AI test
            'hasProductSchema',          // Product Schema test (WooCommerce)
            'isInternalLink',            // Internal Link test
            'isReviewEnabled',           // Review test (WooCommerce/EDD)
            'keywordDensity',            // Keyword Density test
            'keywordIn10Percent',        // Keyword in First 10% Content
            'keywordInImageAlt',         // Keyword in Image Alt test
            'keywordInPermalink',        // Keyword in Permalink test
            'keywordInSubheadings',      // Keyword in Subheadings test
            'lengthContent',             // Length of Content test
            'lengthPermalink',           // Length of Permalink test
            'linksHasDoFollow',          // DoFollow external links test
            'linksHasExternals',         // External Links test
            'linksHasInternal',          // Internal Links test
            'linksNotAllExternals',      // External Dofollow Link test
            'titleHasNumber',            // Number in Title test
            'titleHasPowerWords',        // Title Has Power Words test
            'titleSentiment',            // Title Sentiment test
            'titleStartWithKeyword'      // Title Start with Keyword test
        );

        foreach ($tests_to_disable as $test) {
            unset($tests[$test]);
        }

        return $tests;
    }
}

// Initialize the plugin
new Lite_Math();
