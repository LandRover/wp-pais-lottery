<?php
	
	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       https://wordpress.org/plugins/pais-lottery/
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/admin
	 */
	
    
	/**
	 * The admin-specific functionality of the plugin.
	 * Defines the plugin name, version, and hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 * @author     LR <admin@pais-lottery.com>
	 */
	class Pais_Lottery_Admin
	{
		
		/**
		 * The ID of this plugin.
		 *
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;
		
        
		/**
		 * The version of this plugin.
		 *
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @param string $plugin_name The name of this plugin.
		 * @param string $version     The version of this plugin.
		 */
		public function __construct($plugin_name, $version)
		{
			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}
		
        
		/**
		 * Register the stylesheets for the admin area.
		 */
		public function enqueue_styles()
		{
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'css/pais-lottery-admin.min.css', array(), $this->version, 'all');
		}
		
        
		/**
		 * Register the JavaScript for the admin area.
		 */
		public function enqueue_scripts() {
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('wp-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array ('wp-color-picker'), '2.1.2', false);
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/pais-lottery-admin.min.js', array ('jquery'), $this->version, false);
		}
		
        
		static function function_pais_lottery_plugin_action_links($links) {
			$links_prefix = array (
				"<b>" . __('Pais Box', 'pais-lottery') . "</b><br />"
			);
			
			$links_suffix = array (
			);
			
			return array_merge( $links_prefix, $links, $links_suffix );
		}
	}
	
	if (
        (empty(get_option('pais_box_version'))) OR
        (version_compare(get_option('pais_box_version'), $this->version) == - 1)
    ) {
		update_option('pais_box_version', $this->version);
	}
    
	// get_option( 'pais_box_version' );
	/*
	 if ( version_compare( get_option( 'pais_box_version' ), '1.0.0' ) < 0 )
	{

	}
	else
	{

	}
	*/
