<?php
	
	/**
	 * Fired during plugin activation
	 *
	 * @link       https://wordpress.org/plugins/pais-lottery/
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 */
	
	/**
	 * Fired during plugin deactivation.
	 * This class defines all code necessary to run during the plugin's deactivation.
	 *
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 * @author     LR <admin@pais-lottery.com>
	 */
	class Pais_Lottery_Deactivator
	{
		
		/**
		 * Short Description. (use period)
		 * Long Description.
		 */
		public static function deactivate()
		{
			// delete transients
			global $wpdb;
			$wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE '%pais_box_transient_%'" );
		}
		
	}
