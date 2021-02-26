<?php
	
	/**
	 * Define the internationalization functionality
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @link       https://wordpress.org/plugins/pais-lottery/
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 */
	
	/**
	 * Define the internationalization functionality.
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 * @author     LR <admin@pais-lottery.com>
	 */
	class Pais_Lottery_i18n
	{
		
		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain()
		{
			load_plugin_textdomain( 'pais-lottery', FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
		}
		
	}
