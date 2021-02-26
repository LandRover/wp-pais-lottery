<?php
	
	/**
	 * Defines a remote call wrapper, to fetch remote data, returns as string
     * Wrapper around wordpress' generic remote function call.
     * Supports both post and get.
	 *
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/utils
	 * @author     LR <admin@pais-lottery.com>
	 */
	class Pais_Lottery_Fetch
	{
        private $useragent = 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3629.101 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';


        /**
         * 
         * 
         */
        public function remote($url, $method = 'GET', $props = [], $ttl = 3600) {
            $cacheKey = $this->_cache_key($url, $method, $props, $ttl);

            if (false === ($return = get_transient($cacheKey)))
            {
                switch ($method) {
                    case 'GET':
                        $data = $this->_get($url, $props);
                        break;
                    case 'POST':
                        $data = $this->_post($url, $props);
                        break;
                }

                if (!empty($data))
                {
                    set_transient($cacheKey, $data, $ttl);
            
                    $return = $data;
                }
            }

            return $return;
        }
        

        /**
         * 
         * 
         */
        private function _get($url, $props, $timeout = 20) {
            $wp_remote_get_response = wp_remote_get(esc_url_raw($url), array(
              'timeout' => $timeout,
              'user-agent' => $this->useragent,
            ));
            
            $pais_transient_data = wp_remote_retrieve_body($wp_remote_get_response);
            
            return $pais_transient_data;
        }
        
        
        private function _post($url, $props, $timeout = 20) {
            $wp_remote_post_response = wp_remote_post(esc_url_raw($url), array(
              'timeout' => $timeout,
              'body' => $props,
              'headers' => array(
                'user-agent' => $this->useragent,
              )
              
            ));
            
            $pais_transient_data = wp_remote_retrieve_body($wp_remote_post_response);
            
            
            return $pais_transient_data;
        }
        
        
        /**
         * Generates a key, to store the cache
         */
        private function _cache_key($url, $method, $props = [], $ttl) {
            $key = array($url, $method, $props, $ttl);
            
            return md5(json_encode($key));
        }
        
	}
