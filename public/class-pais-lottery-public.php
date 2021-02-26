<?php
	
	/**
	 * The public-facing functionality of the plugin.
	 *
	 * @link       https://wordpress.org/plugins/pais-lottery/
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/public
	 */
	
	/**
	 * The public-facing functionality of the plugin.
	 * Defines the plugin name, version, and hooks to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/includes
	 * @author     LR <admin@pais-lottery.com>
	 */
	class Pais_Lottery_Public
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
		 * @param string $plugin_name The name of the plugin.
		 * @param string $version     The version of this plugin.
		 */
		public function __construct( $plugin_name, $version )
		{
			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}
		
		/**
		 * Register the stylesheets for the public-facing side of the site.
		 */
		public function enqueue_styles()
		{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pais-lottery-public.min.css', array (), $this->version, 'all' );
		}
		
		/**
		 * Register the JavaScript for the public-facing side of the site.
		 */
		public function enqueue_scripts()
		{
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pais-lottery-public.min.js', array ( 'jquery' ), $this->version, FALSE );
		}
		
		/*
		static function function_filter_bad_words( $example )
		{
			return $example;
		}
		*/
	}
	
