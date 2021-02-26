<?php

/**
 * @link              https://github.com/LandRover
 * @package           Pais_Lottery
 * @wordpress-plugin
 * Plugin Name:       Pais Lottery Widget
 * Plugin URI:        https://wordpress.org/plugins/pais-lottery/
 * Description:       Pais Lottery Results
 * Version:           1.0.9
 * Author:            LRz
 * Author URI:        https://github.com/LandRover
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pais-lottery
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}


/**
 * The code that runs during plugin activation.
 */
function activate_pais_lottery() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-pais-lottery-activator.php';
	Pais_Lottery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_pais_lottery() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-pais-lottery-deactivator.php';
	Pais_Lottery_Deactivator::deactivate();
}


register_activation_hook(__FILE__, 'activate_pais_lottery');
register_deactivation_hook(__FILE__, 'deactivate_pais_lottery');


/**
 * The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-pais-lottery.php';


/**
 * Begins execution of the plugin.
 */
function run_pais_lottery() {
    $plugin = new Pais_Lottery();
    $plugin->run();
}

run_pais_lottery();
