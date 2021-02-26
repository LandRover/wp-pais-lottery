<?php
/**
 * Feeds list supported by the feature
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'config/config-feeds.php';
    
/**
 * The file that defines the core plugin class
 * A class definition that includes attributes and functions used across both the public-facing side of the site and the admin area.
 *
 * @link       https://wordpress.org/plugins/pais-lottery/
 * @package    Pais_Lottery_Statistics
 * @subpackage Pais_Lottery_Statistics/includes
 */


/**
 * The core plugin class.
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @package    Pais_Lottery_Statistics
 * @subpackage Pais_Lottery_Statistics/includes
 * @author     LR <admin@pais-lottery.com>
 */

class Pais_Lottery_Statistics extends WP_Widget
{
    /**
     * The unique identifier of this plugin.
     *
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;


    /**
     * The current version of the plugin.
     *
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;


    /**
     * Define the core functionality of the plugin.
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
     */
    public function __construct()
    {
        $this->plugin_name = 'pais-lottery';
        $this->version = '1.0.0';

        $widget_ops = array(
            'description' => __('Display current statistics of the Pais Lottery on your website.', 'pais-lottery')
        );

        // Instantiate the parent object
        parent::__construct(false, 'Pais Lottery Statistics Widget', $widget_ops);
    }


    /**
     * Register the widget on widgets_init
     *
     * @return void
     */
    static function register_widget()
    {
        register_widget(__CLASS__);
    }

    /*--------------------------------------------------*/
    /* Widget API Functions
    /*--------------------------------------------------*/


    /**
     * Outputs the content of the widget.
     *
     * @param array args  The array of form elements
     * @param array instance The current instance of the widget
     */
    public function widget($args, $instance)
    {
        extract($args);

        echo $before_widget;
        echo $before_title;
        echo $after_title;

        echo pais_lottery_statistics_widget(array(
            'is_shortcode' => $is_shortcode
        ));

        echo $after_widget;
    }



    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }


    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}


add_action('widgets_init', array(
    'Pais_Lottery_Statistics',
    'register_widget'
));


add_shortcode('shortcode-pais-lottery-all-statistics', 'function_shortcode_pais_lottery_all_statistics_widget');

function pais_lottery_all_statistics_widget($attributes) {
    return pais_lottery_statistics_widget($attributes);
}

function function_shortcode_pais_lottery_all_statistics_widget($attributes) {
    return pais_lottery_all_statistics_widget($attributes);
}

function pais_lottery_statistics_widget($attributes) {
    $is_shortcode = isset($attributes['is_shortcode']) ? $attributes['is_shortcode'] : 1;

    $sourcesList = array(
        'pais_lotto' => array(
            'title' => 'שכיחות התוצאות בהגרלות הלוטו',
            'title_sub' => 'המספר החזק בהגרלות הלוטו',
            'tab' => array(
                'title' => 'הלוטו',
                'className' => 'pais_lotto',
            ),
        ),
        
        'tofesyashir_chance' => array(
            'title' => "שכיחות תוצאות בהגרלות הצ'אנס",
            'tab' => array(
                'title' => "צ'אנס",
                'className' => 'tofesyashir_chance',
            ),
        ),
        
        'pais_777' => array(
            'title' => 'שכיחות התוצאות בהגרלות 777',
            'tab' => array(
                'title' => '777',
                'className' => 'pais_777',
            ),
        ),
        
        'pais_123' => array(
            'title' => 'שכיחות התוצאות בהגרלות 123',
            'tab' => array(
                'title' => '123',
                'className' => 'pais_123',
            ),
        )
    );

    ob_start();
    require plugin_dir_path(dirname(__FILE__)) . 'templates/lottery_statistics_widget.tpl.php';
    $tpl = ob_get_clean();

    $body = "<div class='pais-lottery-statistics-wrapper'>";
        $body .= $tpl;
    $body .= "</div>";


    return $body;

}

