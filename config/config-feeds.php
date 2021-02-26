<?php

$lotteryTimezone = 'Asia/Jerusalem';

$convertStrToUnixtime = function($str) {
    global $lotteryTimezone;
    
    $date = new DateTime($str, new DateTimeZone($lotteryTimezone));
    
    return array(
        $date->format('U')
    );
};


$convertDateToCountdown = function($timestamp) {
    global $lotteryTimezone;

    $now = new DateTime('now', new DateTimeZone($lotteryTimezone));
    $expires = new DateTime('@'. $timestamp, new DateTimeZone($lotteryTimezone));
    $interval = $now->diff($expires, true);
    
    return array(
        array(
            'days' => $interval->format('%D'),
            'hours' => $interval->format('%H'),
            'minutes' => $interval->format('%I')
        )
    );
};


/**
 * Config, contains all feed formats and urls
 *
 * @access   private
 * @var      Object $props containg all configuration, paths and ways to parse the information.
 */
$feedsConfig = array(
        'lottery_results' => array(
        
            // lotto
            'pais_lotto' => array(
                'archive' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9sb3R0by9zaG93TW9yZVJlc3VsdHMuYXNweD9hbW91bnQ9MQ==', //
                    'ttl' => 60 * 60 * 1,
                    'type' => 'html',
                    'fields' => array(
                        'id' => array(
                            'selector' => 'li .lotto_number div',
                            'path' => '2.text'
                        ),
                        
                        'date' => array(
                            'selector' => 'li .date div',
                            'path' => '2.text'
                        ),
                        
                        'time' => array(
                            'selector' => 'li .date div',
                            'path' => '4.text'
                        ),
                        
                        'number_strong' => array(
                            'selector' => 'li .strong div',
                            'path' => '2.text'
                        ),
                        
                        'numbers' => array(
                            'selector' => 'li .numbers ol li div',
                            'path' => '{Iterator}.text',
                        ),
                        
                        'prize' => array(
                            'selector' => 'li .total div',
                            'path' => '2.text',
                            'numeric' => true
                        )
                    )
                ),
                
                'next' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9pbmNsdWRlL2dldE5leHRMb3R0ZXJ5RGF0ZS5hc2h4P3R5cGU9MQ==',
                    'type' => 'json',
                    'ttl' => 60 * 60 * 1,
                    'fields' => array(
                        'datetime' => array(
                            'path' => '0.nextLottoryDate'
                        ),
                        
                        'date' => array(
                            'path' => '0.displayDate'
                        ),
                        
                        'time' => array(
                            'path' => '0.displayTime'
                        ),
                        
                        'prize_first' => array(
                            'path' => '0.firstPrize'
                        ),
                        
                        'prize_second' => array(
                            'path' => '0.secondPrize'
                        ),
                        
                        'unixtime' => array(
                            'src' => 'datetime',
                            'convertor' => $convertStrToUnixtime
                        ),
                        
                        'timeleft' => array(
                            'src' => 'unixtime',
                            'convertor' => $convertDateToCountdown
                        )
                    )
                ),
                
                
                'extra' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9sb3R0by8=',
                    'type' => 'html',
                    'ttl' => 60 * 60 * 1,
                    'fields' => array(
                        'numbers' => array(
                            'selector' => '.cat_h_data_group .extra_num',
                            'path' => '{Iterator}.text',
                            'reverse' => true
                        )
                    )
                ),
            ),
            
            
            // chance
            'pais_chance' => array(
                'archive' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9jaGFuY2UvU2hvd01vcmVSZXN1bHRzTWluaW1pemVkLmFzcHg/YW1vdW50PTE=',
                    'type' => 'html',
                    'ttl' => 60 * 60 * 0.5,
                    'replace' => array(
                        'src' => array(
                            'עלה',
                            'יהלום',
                            'לב',
                            'תלתן',
                            'שעת הגרלה:',
                            'תאריך הגרלה:',
                        ),
                        'dst' => array(
                            'spades',
                            'diamonds',
                            'hearts',
                            'clubs',
                        ),
                    ),
                    'fields' => array(
                        'id' => array(
                            'selector' => '.complex_line_block div',
                            'path' => '0.text',
                            'numeric' => true
                        ),
                        
                        'date' => array(
                            'selector' => '.timing > div',
                            'path' => '0.text'
                        ),
                        
                        'time' => array(
                            'selector' => '.comlex_line_time',
                            'path' => '0.text'
                        ),
                        
                        'cards_type' => array(
                            'selector' => '.card > div:nth-child(1)',
                            'path' => '{Iterator}.text',
                            'reverse' => true
                        ),
                        
                        'cards_symbols' => array(
                            'selector' => '.card > div:nth-child(2)',
                            'path' => '{Iterator}.text'
                        ),
                        
                        'prize' => array(
                            'selector' => '.sum',
                            'path' => '{Iterator}.text',
                            'numeric' => true
                        ),
                    )
                ),
                
                'next' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9pbmNsdWRlL2dldE5leHRMb3R0ZXJ5RGF0ZS5hc2h4P3R5cGU9Mw==',
                    'type' => 'json',
                    'ttl' => 60 * 60 * 0.5,
                    'fields' => array(
                        'datetime' => array(
                            'path' => '0.nextLottoryDate'
                        ),
                        
                        'date' => array(
                            'path' => '0.displayDate'
                        ),
                        
                        'time' => array(
                            'path' => '0.displayTime'
                        ),
                        
                        'unixtime' => array(
                            'src' => 'datetime',
                            'convertor' => $convertStrToUnixtime
                        ),
                        
                        'timeleft' => array(
                            'src' => 'unixtime',
                            'convertor' => $convertDateToCountdown
                        )
                        
                    )
                ),
                
            ),
            
            
            // 777
            'pais_777' => array(
                'archive' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC83Nzcvc2hvd01vcmVSZXN1bHRzLmFzcHg/YW1vdW50PTE=',
                    'type' => 'html',
                    'replace' => array(
                        'src' => array(
                            'שעת הגרלה:',
                            'תאריך הגרלה:',
                        ),
                        'dst' => array(),
                    ),
                    'fields' => array(
                        'id' => array(
                            'selector' => '.lotto_number div[tabindex="0"]',
                            'path' => '0.text',
                            'numeric' => true
                        ),
                        
                        'date' => array(
                            'selector' => '.date > div:nth-child(2)',
                            'path' => '0.text'
                        ),
                        
                        'time' => array(
                            'selector' => '.date > div:nth-child(3)',
                            'path' => '0.text'
                        ),
                        
                        'numbers' => array(
                            'selector' => '.loto_info_num._777',
                            'path' => '{Iterator}.text'
                        ),
                        
                        'prize' => array(
                            'selector' => '.total div[tabindex="0"]',
                            'path' => '{Iterator}.text',
                            'numeric' => true
                        ),
                    )
                ),
                
                'next' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9pbmNsdWRlL2dldE5leHRMb3R0ZXJ5RGF0ZS5hc2h4P3R5cGU9NQ==',
                    'type' => 'json',
                    'fields' => array(
                        'datetime' => array(
                            'path' => '0.nextLottoryDate'
                        ),
                        
                        'date' => array(
                            'path' => '0.displayDate'
                        ),
                        
                        'time' => array(
                            'path' => '0.displayTime'
                        ),
                        
                        'unixtime' => array(
                            'src' => 'datetime',
                            'convertor' => $convertStrToUnixtime
                        ),
                        
                        'timeleft' => array(
                            'src' => 'unixtime',
                            'convertor' => $convertDateToCountdown
                        )
                        
                    )
                ),
            ),
            
            
            // 123
            'pais_123' => array(
                'archive' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC8xMjMvc2hvd01vcmVSZXN1bHRzLmFzcHg/YW1vdW50PTE=',
                    'type' => 'html',
                    'replace' => array(
                        'src' => array(
                            'שעת הגרלה:',
                            'תאריך הגרלה:',
                        ),
                        'dst' => array(),
                    ),
                    'fields' => array(
                        'id' => array(
                            'selector' => '._123_number div[tabindex="0"] h4',
                            'path' => '0.text',
                            'numeric' => true
                        ),
                        
                        'date' => array(
                            'selector' => '.date > div:nth-child(2)',
                            'path' => '0.text'
                        ),
                        
                        'time' => array(
                            'selector' => '.date > div:nth-child(3)',
                            'path' => '0.text'
                        ),
                        
                        'numbers' => array(
                            'selector' => '.cat_data_info._123 li div',
                            'path' => '{Iterator}.text',
                            'reverse' => true
                        ),
                        
                        'prize' => array(
                            'selector' => '.total div[tabindex="0"]',
                            'path' => '{Iterator}.text',
                            'numeric' => true
                        ),
                    )
                ),
                
                'next' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9pbmNsdWRlL2dldE5leHRMb3R0ZXJ5RGF0ZS5hc2h4P3R5cGU9NA==',
                    'type' => 'json',
                    'fields' => array(
                        'datetime' => array(
                            'path' => '0.nextLottoryDate'
                        ),
                        
                        'date' => array(
                            'path' => '0.displayDate'
                        ),
                        
                        'time' => array(
                            'path' => '0.displayTime'
                        ),
                        
                        'unixtime' => array(
                            'src' => 'datetime',
                            'convertor' => $convertStrToUnixtime
                        ),
                        
                        'timeleft' => array(
                            'src' => 'unixtime',
                            'convertor' => $convertDateToCountdown
                        )
                        
                    )
                ),
            ),
        ),
        
        
        
        'lottery_statistics' => array(
        
            'pais_lotto' => array(
                'dist' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9zdGF0aXN0aWNzL1N0YXRpc3RpY3MuYXNoeA==',
                    'ttl' => 60 * 60 * 12,
                    'post' => array(
                        'gameType' => 'Lotto',
                        'statType' => 'dist',
                        'amount' => 500,
                        'fromDate' => '',
                        'toDate' => '',
                        'fromNum' => '',
                        'toNum' => '',
                    ),
                    'type' => 'json',
                    'fields' => array(
                        'numbers' => array(
                            'path' => '0.array.{Iterator}.number'
                        ),
                        
                        'count' => array(
                            'path' => '0.array.{Iterator}.count'
                        ),
                    )
                ),

                'hotstrong' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9zdGF0aXN0aWNzL1N0YXRpc3RpY3MuYXNoeA==',
                    'ttl' => 60 * 60 * 12,
                    'post' => array(
                        'gameType' => 'Lotto',
                        'statType' => 'hotstrong',
                        'amount' => 500,
                        'fromDate' => '',
                        'toDate' => '',
                        'fromNum' => '',
                        'toNum' => '',
                    ),
                    'type' => 'json',
                    'fields' => array(
                        'numbers' => array(
                            'path' => '0.array.{Iterator}.number'
                        ),
                        
                        'count' => array(
                            'path' => '0.array.{Iterator}.count'
                        ),
                    )
                ),
            ),
            
            
            'pais_chance' => array(
                'dist' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9zdGF0aXN0aWNzL1N0YXRpc3RpY3MuYXNoeA==',
                    'ttl' => 60 * 60 * 12,
                    'post' => array(
                        'gameType' => 'Chance',
                        'statType' => 'dist',
                        'amount' => 500,
                        'fromDate' => '',
                        'toDate' => '',
                        'fromNum' => '',
                        'toNum' => '',
                    ),
                    'type' => 'json',
                    'fields' => array(
                        'spades_cards_number' => array(
                            'path' => '0.array.{Iterator}.number'
                        ),
                        'spades_cards_count' => array(
                            'path' => '0.array.{Iterator}.count'
                        ),
                        
                        'diamonds_cards_number' => array(
                            'path' => '2.array.{Iterator}.number'
                        ),
                        'diamonds_cards_count' => array(
                            'path' => '2.array.{Iterator}.count'
                        ),
                        
                        'hearts_cards_number' => array(
                            'path' => '1.array.{Iterator}.number'
                        ),
                        'hearts_cards_count' => array(
                            'path' => '1.array.{Iterator}.count'
                        ),
                        
                        'clubs_cards_number' => array(
                            'path' => '3.array.{Iterator}.number'
                        ),
                        'clubs_cards_count' => array(
                            'path' => '3.array.{Iterator}.count'
                        ),
                    )
                ),
            ),
            
            
            'pais_777' => array(
                'dist' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9zdGF0aXN0aWNzL1N0YXRpc3RpY3MuYXNoeA==',
                    'ttl' => 60 * 60 * 12,
                    'post' => array(
                        'gameType' => '777',
                        'statType' => 'dist',
                        'amount' => 500,
                        'fromDate' => '',
                        'toDate' => '',
                        'fromNum' => '',
                        'toNum' => '',
                    ),
                    'type' => 'json',
                    'fields' => array(
                        'numbers' => array(
                            'path' => '0.array.{Iterator}.number'
                        ),
                        
                        'count' => array(
                            'path' => '0.array.{Iterator}.count'
                        ),
                    )
                ),
            ),
            
            
            'pais_123' => array(
                'dist' => array(
                    'url' => 'aHR0cHM6Ly93d3cucGFpcy5jby5pbC9zdGF0aXN0aWNzL1N0YXRpc3RpY3MuYXNoeA==',
                    'ttl' => 60 * 60 * 12,
                    'post' => array(
                        'gameType' => '123',
                        'statType' => 'dist',
                        'amount' => 500,
                        'fromDate' => '',
                        'toDate' => '',
                        'fromNum' => '',
                        'toNum' => '',
                    ),
                    'type' => 'json',
                    'fields' => array(
                        'numbers' => array(
                            'path' => '0.array.{Iterator}.number'
                        ),
                        
                        'count' => array(
                            'path' => '0.array.{Iterator}.count'
                        ),
                    )
                ),
            ),
            
            'tofesyashir_chance' => array(
                'dist' => array(
                    'url' => 'aHR0cHM6Ly93d3cudG9mZXN5YXNoaXIuY28uaWwvY2hhbmNlL3N0YXRpc3RpY3M=',
                    'ttl' => 60 * 60 * 1.5,
                    'type' => 'html',
                    'fields' => array(
                        'spades' => array(
                            'selector' => '#Ale_jumps',
                            'raw' => true,
                        ),
                        
                        'hearts' => array(
                            'selector' => '#Lev_jumps',
                            'raw' => true,
                        ),
                        
                        'diamonds' => array(
                            'selector' => '#Yhalom_jumps',
                            'raw' => true,
                        ),
                        
                        'clubs' => array(
                            'selector' => '#Tiltan_jumps',
                            'raw' => true,
                        ),
                    )
                ),
            ),
        ),
    );
