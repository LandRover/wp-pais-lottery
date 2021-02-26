<?php
	
	/**
	 * Define the generic parser, responsible for converting HTML to JSON object according to fields
	 * Loads input as string
	 *
	 * @link       https://wordpress.org/plugins/pais-lottery/
	 * @package    Pais_Lottery
	 * @subpackage Pais_Lottery/utils
	 */
	class Pais_Lottery_Parser
	{
	   
        public function load($type, $fields = [], $body) {
            //print_r(['load debug print', $type, $fields, $body]);
            
            switch ($type) {
                case 'html':
                    $output = $this->html($fields, $body);
                    break;
                case 'json':
                    $output = $this->json($fields, $body);
                    
                    break;
            }

            return $output;
        }
        

        private function html($fields = [], $body) {
            $dom = new SelectorDOM($body);
            
            $output = array();
            foreach ($fields as $name => $props) {
                $raw = (array_key_exists('raw', $props) && true === $props['raw']) ? true : false;
                
                $json = $dom->select($props['selector'], !$raw);
                
                if ($raw) {
                    $resultNode = $json->item(0);
                    $newDom = new DOMDocument;
                    $newDom->appendChild($newDom->importNode($resultNode,1));
                    
                    $output[$name] = $newDom->saveXML();
                } else {
                    $output[$name] = $this->_parseField($output, $json, $props);
                }
            }
            
            return $output;
        }
        
        
        private function json($fields = [], $body) {
            $json = json_decode($body, true);
                
            $output = array();
            foreach ($fields as $name => $props) {
                $output[$name] = $this->_parseField($output, $json, $props);
            }
            
            return $output;
        }
        
        
        private function _parseField($parsedFieldsList, $json, $props) {
                $parsed = null;
                
                if (array_key_exists('path', $props)) {
                    $parsed = $this->_parse($json, $props['path'], array(
                        'numeric' => (array_key_exists('numeric', $props) && true === $props['numeric']) ? true : false,
                        'reverse' => (array_key_exists('reverse', $props) && true === $props['reverse']) ? true : false,
                    ));
                }
                
                if (array_key_exists('convertor', $props) && array_key_exists('src', $props) && is_callable($props['convertor'])) {
                    $parsed = $props['convertor']($parsedFieldsList[$props['src']][0]);
                }
                
                return $parsed;
        }
        
        
        private function _parse($json, $path, $props = array()) {
            $output = array();
            $len = 1;
            
            if (false !== strpos($path, '{Iterator}')) {
                $prefixTreeAll = explode('{Iterator}', $path);
                $prefixTree = $prefixTreeAll[0];

                $reduceList = $json;
                
                if ('' !== $prefixTree) {
                    // clean dots, prefix and sufix
                    $prefixTree = preg_replace('/\.+$/', '', $prefixTree);
                    $prefixTree = preg_replace('/^\.+/', '', $prefixTree);
    
                    $pathList = explode('.', $prefixTree);
                    $reduceList = array_reduce($pathList,
                        function ($accumulator, $item) {
                            return $accumulator[$item];
                        },
                        $json
                    );
               }
               
               $len = count($reduceList);
            }
            
            
            for ($i = 0; $i < $len; $i++) {
                $selectorLocal = str_replace('{Iterator}', $i, $path);
                
                $pathList = explode('.', $selectorLocal);
                
                $reduceRes = array_reduce($pathList,
                    function ($accumulator, $item) {
                        return $accumulator[$item];
                    },
                    $json
                );
                
                $output[$i] = $this->normalizeTitle($reduceRes);
            }
            
            if (array_key_exists('reverse', $props) && true === $props['reverse']) {
                $output = array_reverse($output);
            }
            
            if (array_key_exists('numeric', $props) && true === $props['numeric']) {
                $output = str_replace(',', '', $output);
                $output = preg_replace('/[^0-9]/', '', $output);
            }
            
            
            return $output;
        }
        
    
        private function normalizeTitle($str) {
            return trim($str);
        }

        
	}
    
