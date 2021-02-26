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
	class Pais_Lottery_Feeds
	{
        /**
         * Contains an instance of a fetcher, Pais_Lottery_Fetch
         *
         * @access   private
         * @var      Object $fetch contains an instance of Pais_Lottery_Fetch fetcher, to download remote data.
         */
	    private $fetch = null;
        

        /**
         * Feeds config supported
         *
         * @access   private
         * @var      Object of feeds
         */
	    private $feedsConfig = null;
        
       
        public function __construct($feedsConfig) {
            $this->feedsConfig = $feedsConfig;
            
            $this->fetch = new Pais_Lottery_Fetch();
            $this->parser = new Pais_Lottery_Parser();
        }
        
        
        //
        public function load($data_type, $data_source) {
        // @TODO: input validation.
            $config = $this->feedsConfig[$data_type][$data_source];
            $output = array();
            
            if (is_array($config)) {
                foreach ($config as $key => $section) {
                    $url = base64_decode($section['url']);
                    $type = $section['type'];
                    $fields = $section['fields'];
                    $method = array_key_exists('post', $section) ? 'POST' : 'GET';
                    $params = array_key_exists('post', $section) ? $section['post'] : [];
                    $replace = array_key_exists('replace', $section) ? $section['replace'] : array();
                    $ttl = array_key_exists('ttl', $section) ? $section['ttl'] : 3600;
                    
                    $body = $this->fetch->remote($url, $method, $params, $ttl);
                    
                    if (array_key_exists('src', $replace) && array_key_exists('dst', $replace)) {
                        $body = str_replace($replace['src'], $replace['dst'], $body);
                    }
                    
                    
                    $res = $this->parser->load($type, $fields, $body);
                    $output[$key] = $res;
                    
                }
            }
            
            //print_r(['HGLO.load', $output]);
            
            return $output;
        }

	}
