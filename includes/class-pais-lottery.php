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
 * @package    Pais_Lottery
 * @subpackage Pais_Lottery/includes
 */


/**
 * The core plugin class.
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @package    Pais_Lottery
 * @subpackage Pais_Lottery/includes
 * @author     LR <admin@pais-lottery.com>
 */

class Pais_Lottery extends WP_Widget
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power the plugin.
     *
     * @access   protected
     * @var      Pais_Lottery_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;


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
        $this->version = '1.0.9';

        $widget_ops = array(
            'description' => __('Display current status of the Pais Lottery on your website.', 'pais-lottery')
        );

        // Instantiate the parent object
        parent::__construct(false, 'Pais Lottery Widget', $widget_ops);

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
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

        $title = !empty($instance['title']) ? stripslashes($instance['title']) : false;
        $title_sub = !empty($instance['title_sub']) ? stripslashes($instance['title_sub']) : false;
        $data_type = !empty($instance['data_type']) ? $instance['data_type'] : 'lottery_results';
        $data_source = !empty($instance['data_source']) ? $instance['data_source'] : 'pais_lotto';

        $layout = !empty($instance['layout']) ? $instance['layout'] : 'pais_lottery_box_small';
        $font_size = !empty($instance['font_size']) ? stripslashes($instance['font_size']) : false;
        $background_color = !empty($instance['background_color']) ? stripslashes($instance['background_color']) : false;

        $is_shortcode = 0;

        echo $before_widget;
        echo $before_title;
        echo $after_title;

        echo pais_lottery_widget(array(
            'title' => $title,
            'title_sub' => $title_sub,

            'data_type' => $data_type,
            'data_source' => $data_source,

            'layout' => $layout,
            'font_size' => $font_size,
            'background_color' => $background_color,

            'is_shortcode' => $is_shortcode
        ));

        echo $after_widget;
    }


    /**
     * Processes the widget's options to be saved.
     *
     * @param array new_instance The new instance of values to be generated via the update.
     * @param array old_instance The previous instance of values before the update.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['language'] = strip_tags($new_instance['language']);
        $instance['font_size'] = strip_tags(addslashes($new_instance['font_size']));
        $instance['background_color'] = strip_tags(addslashes($new_instance['background_color']));
        $instance['title'] = strip_tags(addslashes($new_instance['title']));
        $instance['title_sub'] = strip_tags(addslashes($new_instance['title_sub']));
        
        $instance['layout'] = strip_tags($new_instance['layout']);
        $instance['data_type'] = strip_tags($new_instance['data_type']);
        $instance['data_source'] = strip_tags($new_instance['data_source']);

        return $instance;
    }


    /**
     * Generates the administration form for the widget.
     *
     * @param array instance The array of keys and values for the widget.
     */
    public function form($instance)
    {
        $get_locale_root_array = explode('_', get_locale());
        $get_locale_root = $get_locale_root_array[0];
        if ($get_locale_root == 'he')
        {
            $language_root_wp = 'he';
        }
        else
        {
            $language_root_wp = 'en';
        }

        $title = !empty($instance['title']) ? stripslashes($instance['title']) : false;
        $title_sub = !empty($instance['title_sub']) ? stripslashes($instance['title_sub']) : false;
        $font_size = !empty($instance['font_size']) ? stripslashes($instance['font_size']) : false;
        $background_color = !empty($instance['background_color']) ? stripslashes($instance['background_color']) : false;

        $layout = !empty($instance['layout']) ? $instance['layout'] : 'pais_lottery_box_small';
        $data_type = isset($instance['data_type']) ? $instance['data_type'] : 'lottery_results';
        $data_source = isset($instance['data_source']) ? $instance['data_source'] : 'pais_lotto';
        
        echo "<script>/*<![CDATA[*/var pais_lottery_language = '$language_root_wp';/*]]>*/</script>";

        echo "<h3 style='margin:1em 0 0 0'>";
        echo __('Display', 'pais-lottery');
        echo "</h3>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('title') . "'>";
        echo __('Title', 'pais-lottery');
        echo " " . __('(optional)', 'pais-lottery');
        echo "</label>";
        echo "<input class='widefat' id='" . $this->get_field_id('title') . "' name='" . $this->get_field_name('title') . "' type='text' value=\"" . $title . "\">";
        echo "<small>";
        echo __('leave blank - if not needed', 'pais-lottery');
        echo "</small>";
        echo "</p>";
        
        echo "<p>";
        echo "<label for='" . $this->get_field_id('title_sub') . "'>";
        echo __('Sub Title', 'pais-lottery');
        echo " " . __('(optional)', 'pais-lottery');
        echo "</label>";
        echo "<input class='widefat' id='" . $this->get_field_id('title_sub') . "' name='" . $this->get_field_name('title_sub') . "' type='text' value=\"" . $title_sub . "\">";
        echo "<small>";
        echo __('leave blank - Data Source is in widget\'s sub title', 'pais-lottery');
        echo "</small>";
        echo "</p>";

        echo "<div class='widget_shortcode'>[shortcode-pais-lottery title=\"$title\" title_sub=\"$title_sub\"]</div>";

        echo "<small>";
        echo "<a href='#' class='shortcode_toggle_link'>";
        echo __('shortcode - all options', 'pais-lottery');
        echo "</a>";
        echo "</small>";

        echo "<div class='shortcode_toggle_div' style='padding:10px;background:#fafafa;display:none'>";
        echo "<i>title=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"my header title here...\" etc.";
        
        echo "<i>title_sub=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"my header sub title here...\" etc.";
        
        echo "<hr />";
        echo "<i>data_type=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"lottery_results\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"lottery_results\" / \"lottery_statistics\"";

        echo "<hr />";
        echo "<i>data_source=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"pais_lotto\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"pais_lotto\" / \"pais_chance\" / \"pais_777\" / \"pais_123\" / \"tofesyashir_chance\"";

        echo "<hr />";
        echo "<i>language=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"he\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"he\" / \"en\"";

        echo "<hr />";
        echo "<i>background_color=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"#AABBCC\" / \"red\" etc.";

        echo "<hr />";
        echo "<i>font_size=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"16px\" / \"12pt\" / \"1.2em\" / \"1rem\" / \"90%\" etc.";

        echo "<hr />";
        echo "<i>layout=\"\"</i>";
        echo "<br />";
        echo __('default', 'pais-lottery') . ": \"pais_lottery_box_small\"";
        echo "<br />";
        echo __('options', 'pais-lottery') . ": \"pais_lottery_box_small\"";

        echo "<hr />";
        echo "<br />";
        echo __('Example:', 'pais-lottery');
        echo "<br /><br />";
        echo "<i>[shortcode-pais-lottery data_type=\"lottery_results\" data_source=\"pais_lotto\" title=\"Pais Lotto - Results\" title_sub=\"Lotto Results\" font_size=\"16px\" layout=\"pais_lottery_box_small\" background_color=\"red\"]</i>";
        echo "<br /><br />";
        echo __('(excluded options load default values)', 'pais-lottery');
        echo "</div>";

        echo "<h3 style='margin:3em 0 0 0'>";
        echo __('Settings', 'pais-lottery');
        echo "</h3>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('data_source') . "'>";
        echo __('Data Source', 'pais-lottery');
        echo "</label>";
        echo pais_lottery_admin_render_select($this->get_field_id('data_source'), $this->get_field_name('data_source'), array(
            'pais_lotto' => 'Pais - Lotto',
            'pais_chance' => 'Pais - Chance',
            'tofesyashir_chance' => 'TofesYashir - Chance',
            'pais_777' => 'Pais - 777',
            'pais_123' => 'Pais - 123'
        ), $data_source);
        echo "</p>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('data_type') . "'>";
        echo __('Data Type', 'pais-lottery');
        echo "</label>";
        echo pais_lottery_admin_render_select($this->get_field_id('data_type'), $this->get_field_name('data_type'), array(
            'lottery_results' => 'Latest Pais Results',
            'lottery_statistics' => 'Latest Statistics'
        ), $data_type);
        echo "</p>";

        echo "<h3 style='margin:3em 0 0 0'>";
        echo __('Language', 'pais-lottery');
        echo "</h3>";
        echo "<p>";
        echo __('The widget\'s language is automatically chosen based on your Settings / General / Site Language settings.', 'pais-lottery');
        echo "<br />";
        echo __('If a local translation does not exist, fallback language is English.', 'pais-lottery');
        echo " <a href='https://wordpress.org/plugins/pais-lottery/#languages' target='_blank'>";
        echo __('How to translate the widget to my language?', 'pais-lottery');
        echo "</a>";

        echo "</p>";

        echo "<h3 style='margin:3em 0 0 0'>";
        echo __('Appearance', 'pais-lottery');
        echo "</h3>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('layout') . "'>";
        echo __('Layout', 'pais-lottery');
        echo "</label>";
        echo pais_lottery_admin_render_select($this->get_field_id('layout'), $this->get_field_name('layout'), array(
            'pais_lottery_box_small' => 'Box Small',
            'pais_lottery_box_large' => 'Box Large (Usually used for Statistics)'
        ), $layout);
        echo "<small>";
        echo __('Box Small - recommended for placement in homepage, as a small box', 'pais-lottery');
        echo "</small>";
        echo "</p>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('font_size') . "'>";
        echo __('Font size', 'pais-lottery');
        echo " " . __('(optional)', 'pais-lottery');
        echo "</label>";
        echo "<input class='widefat' id='" . $this->get_field_id('font_size') . "' name='" . $this->get_field_name('font_size') . "' type='text' value='" . $font_size . "'>";
        echo "<small>";
        echo __('leave blank - widget\'s font size adjusts to web site\'s font size', 'pais-lottery');
        echo "<br />";
        echo __('16px or 12pt or 1.2em or 1rem or 90% etc. - specify widget\'s font size', 'pais-lottery');
        echo "</small>";
        echo "</p>";

        echo "<p>";
        echo "<label for='" . $this->get_field_id('background_color') . "'>";
        echo __('Background Color', 'pais-lottery');
        echo " " . __('(optional)', 'pais-lottery');
        echo "</label><br />";
        echo "<input class='widefat color_picker' data-alpha='TRUE' id='" . $this->get_field_name('background_color') . "' name='" . $this->get_field_name('background_color') . "' type='colorpicker' value='$background_color'>";
        echo "<br />";
        echo "<small>";
        echo __('leave blank - widget\'s background adapt to current temperature', 'pais-lottery');
        echo "<br />";
        echo __('choose color and transparency - background color is fixed', 'pais-lottery');
        echo "</small>";
        echo "</p>";

    }


    /**
     * Load the required dependencies for this plugin.
     * Include the following files that make up the plugin:
     * - Pais_Lottery_Loader. Orchestrates the hooks of the plugin.
     * - Pais_Lottery_i18n. Defines internationalization functionality.
     * - Pais_Lottery_Admin. Defines all hooks for the admin area.
     * - Pais_Lottery_Public. Defines all hooks for the public side of the site.
     * Create an instance of the loader which will be used to register the hooks with WordPress.
     *
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-pais-lottery-loader.php';
        
        
        /**
         * The class responsible for defining internationalization functionality of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-pais-lottery-i18n.php';
        
        
        /**
         * The class responsible for defining the utils
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/selector.inc.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'utils/fetch.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'utils/parser.php';
        
        
        /**
         * The class responsible for defining all feeds interactions
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-pais-feeds.php';
        
        
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-pais-lottery-admin.php';
        
        
        /**
         * The class responsible for defining all actions that occur in the public-facing side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-pais-lottery-public.php';
        
        
        /**
         * This class handles the statistics module
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-pais-lottery-statistics.php';
        
        
        // load loaders
        $this->loader = new Pais_Lottery_Loader();
    }


    /**
     * Define the locale for this plugin for internationalization.
     * Uses the Pais_Lottery_i18n class in order to set the domain and to register the hook with WordPress.
     *
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Pais_Lottery_i18n();
        
        $this
            ->loader
            ->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }
   

    /**
     * Register all of the hooks related to the admin area functionality of the plugin.
     *
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Pais_Lottery_Admin($this->get_plugin_name(), $this->get_version());
        
        $this
            ->loader
            ->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        
        $this
            ->loader
            ->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }


    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Pais_Lottery_Public($this->get_plugin_name(), $this->get_version());
        
        $this
            ->loader
            ->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        
        $this
            ->loader
            ->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this
            ->loader
            ->run();
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
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Pais_Lottery_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
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
    'Pais_Lottery',
    'register_widget'
));


add_shortcode('shortcode-pais-lottery', 'function_shortcode_pais_lottery_widget');

add_filter('plugin_action_links_pais-lottery/pais-lottery.php', array(
    'Pais_Lottery_Admin',
    'function_pais_lottery_plugin_action_links'
)); // Where $priority is default 10, $accepted_args is default 1.



function pais_lottery_widget($attributes) {
    $get_locale_root_array = explode('_', get_locale());
    $get_locale_root = $get_locale_root_array[0];
    $language_root_wp = ($get_locale_root == 'he') ? $get_locale_root : 'en';

    $title = !empty($attributes['title']) ? stripslashes($attributes['title']) : false;
    $title_sub = !empty($attributes['title_sub']) ? stripslashes($attributes['title_sub']) : false;

    $layout = !empty($attributes['layout']) ? $attributes['layout'] : 'pais_lottery_box_small';
    $data_type = !empty($attributes['data_type']) ? $attributes['data_type'] : 'lottery_results';
    $data_source = !empty($attributes['data_source']) ? $attributes['data_source'] : 'pais_lotto';
    
    $background_color = !empty($attributes['background_color']) ? stripslashes($attributes['background_color']) : '';
    $font_size = !empty($attributes['font_size']) ? stripslashes($attributes['font_size']) : false;

    $is_shortcode = isset($attributes['is_shortcode']) ? $attributes['is_shortcode'] : 1;
    
    if (empty($title)) {
        $title = $data_source . '_'. $data_type;
    }

    $pais_lottery_data = pais_lottery_data($data_type, $data_source);

    $body = '';
    if ((!empty($pais_lottery_data)) and (is_array($pais_lottery_data))) {
        ob_start();
        require plugin_dir_path(dirname(__FILE__)) . 'templates/'.$data_type.'.tpl.php';
        $tpl = ob_get_clean();

        $body .= "<div class='pais-lottery-wrapper'";
        if (!empty($font_size))
        {
            $body .= " style=' font-size:$font_size;'";
        }
        $body .= ">";

        $body .= $tpl;

        $body .= "</div>";
    }

    return $body;
}


function pais_lottery_data($data_type, $data_source) {
    global $feedsConfig;
    
    $feeds = new Pais_Lottery_Feeds($feedsConfig);
    $data = $feeds->load($data_type, $data_source);

    return $data;
}


function function_shortcode_pais_lottery_widget($attributes) {
    return pais_lottery_widget($attributes);
}


function pais_lottery_admin_render_select($id, $name, $options, $selected = null) {
    $output = "<select class='widefat' id='$id' name='$name' type='text'>";
    
    foreach ($options as $key => $value) {
        $output .= '<option value="' . $key . '"' . selected($selected, $key, false) . '>' . esc_html($value) . '</option>';
    }
    
    $output .= '</select>';

    return $output;
}
