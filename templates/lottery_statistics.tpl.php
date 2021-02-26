<div class="pais_lottery <?=$layout ?> <?=$data_type ?> <?=$data_source ?>">
    <div class="lottery_heading">
    </div>
    
    <div class="lottery_content"<?php echo (!empty($background_color))? ' style="border-color: '.$background_color.'"' : ''; ?>>
        <h4<?php echo (!empty($background_color))? ' style="color: '.$background_color.'"' : ''; ?>><?=$title ?> <span>עבור 500 הגרלות אחרונות</span></h4>
    
<?php
            // proper cards
            $cardIcons = array(
                'spades' => array(
                    'icon' => '♠',
                    'color' => 'black'
                ),
                'diamonds' => array(
                    'icon' => '♦',
                    'color' => 'red'
                ),
                'hearts' => array(
                    'icon' => '♥',
                    'color' => 'red'
                ),
                'clubs' => array(
                    'icon' => '♣',
                    'color' => 'black'
                )
            );
            
            $rowsList = array(
                '7' => 'קלף 7',
                '8' => 'קלף 8',
                '9' => 'קלף 9',
                '10' => 'קלף 10',
                '11' => 'קלף J',
                '12' => 'קלף Q',
                '13' => 'קלף K',
                '14' => 'קלף A'
            );

            if (
                array_key_exists('spades_cards_number', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['spades_cards_number']) &&
                array_key_exists('diamonds_cards_number', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['diamonds_cards_number']) &&
                array_key_exists('hearts_cards_number', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['hearts_cards_number']) &&
                array_key_exists('clubs_cards_number', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['clubs_cards_number'])
            ) {
                echo '<table>';
                    echo '<thead>';
                        echo '<th></th>';
                        
                        foreach($cardIcons as $card) {
                            echo '<th><strong style="color: '.$card['color'].';">'.$card['icon'].'</strong></th>';
                        }
                        
                    echo '</thead>';
                    echo '<tbody>';
                        foreach($rowsList as $cardIndex => $cardTitle) {
                            echo '<tr>';
                                echo '<td>'.$cardTitle.'</td>';
                                

                                foreach($cardIcons as $cardID => $card) {
                                    $key = array_search($cardIndex, $pais_lottery_data['dist'][$cardID. '_cards_number']);
                                    
                                    echo '<td>'.$pais_lottery_data['dist'][$cardID. '_cards_count'][$key].'</td>';
                                }

                                
                            echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
            }
        ?>
        
    
        <?php
            // regular numbers
            if (
                array_key_exists('numbers', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['numbers']) &&
                array_key_exists('count', $pais_lottery_data['dist']) && is_array($pais_lottery_data['dist']['count'])
            ) {
                echo '<div class="lottery_numbers_primary">';
                    echo '<ol>';
                        for ($number = 0; $number < count($pais_lottery_data['dist']['numbers']); $number++) {
                            $key = array_search($number, $pais_lottery_data['dist']['numbers']);
                            $count = $pais_lottery_data['dist']['count'][$key];
                            
                            if (0 == $count && 0 == $number) continue;
                            
                            echo '<li><strong>'.$number.'</strong> <span><em>'.$count.'</em> הופעות</span></li>';
                        }
                    echo '</ol>';
                    
                    echo '<div class="c"></div>';
                    
                echo '</div>';
            }
        ?>
        
        <?php
            if (
                array_key_exists('hotstrong', $pais_lottery_data) && is_array($pais_lottery_data['hotstrong']) &&
                array_key_exists('numbers', $pais_lottery_data['hotstrong']) && is_array($pais_lottery_data['hotstrong']['numbers']) &&
                array_key_exists('count', $pais_lottery_data['hotstrong']) && is_array($pais_lottery_data['hotstrong']['count'])
            ) {
                ?>
                
                <h4 class="lottery_numbers_secondary"><?=$title_sub ?> <span>עבור 500 הגרלות אחרונות</span></h4>
                
                <?php
                echo '<div class="lottery_numbers_secondary clottery_numbers_hotstrong">';
                    echo '<ol>';
                        for ($number = 1; $number < count($pais_lottery_data['hotstrong']['numbers'])-1; $number++) {
                            $key = array_search($number, $pais_lottery_data['hotstrong']['numbers']);
                            $count = $pais_lottery_data['hotstrong']['count'][$key];
                            
                            echo '<li><strong>'.$number.'</strong> <span><em>'.$count.'</em> הופעות</span></li>';
                        }
                    echo '</ol>';
                    
                    echo '<div class="c"></div>';
                    
                echo '</div>';
            }
        ?>
        
        <?php
            if (
                'tofesyashir_chance' === $data_source &&
                array_key_exists('spades', $pais_lottery_data['dist']) &&
                array_key_exists('hearts', $pais_lottery_data['dist']) &&
                array_key_exists('diamonds', $pais_lottery_data['dist']) &&
                array_key_exists('clubs', $pais_lottery_data['dist'])
            ) {

                // proper cards
                $cardsList = array(
                    'spades' => array(
                        'title' => 'עלה',
                        'title_sub' => 'מה רואים פה? בטבלה זו תוכלו לראות כמה פעמים לקח לכל מספר עד שהופיע בעשר ההופעות האחרונות שלו.',
                        'icon' => '♠',
                        'color' => 'black'
                    ),
                    'hearts' => array(
                        'title' => 'לב',
                        'title_sub' => 'מה רואים פה? בטבלה זו תוכלו לראות כמה פעמים לקח לכל מספר עד שהופיע בעשר ההופעות האחרונות שלו.',
                        'icon' => '♥',
                        'color' => 'red'
                    ),
                    'diamonds' => array(
                        'title' => 'יהלום',
                        'title_sub' => 'מה רואים פה? בטבלה זו תוכלו לראות כמה פעמים לקח לכל מספר עד שהופיע בעשר ההופעות האחרונות שלו.',
                        'icon' => '♦',
                        'color' => 'red'
                    ),
                    'clubs' => array(
                        'title' => 'תילתן',
                        'title_sub' => 'מה רואים פה? בטבלה זו תוכלו לראות כמה פעמים לקח לכל מספר עד שהופיע בעשר ההופעות האחרונות שלו.',
                        'icon' => '♣',
                        'color' => 'black'
                    )
                );

                echo '<div class="lottery_tofes_yashir_statistics">';
                    foreach($cardsList as $tableID => $table) {
                        echo '<h5>'.$table['title'].'</h5>';
                        echo $pais_lottery_data['dist'][$tableID];
                        
                        echo '<div class="c"></div>';
                        
                        echo '<small>'.$table['title_sub'].'</small>';
                    }
                    
                echo '</div>';
                
                
            }
        ?>
        
        
    </div>

</div>

<?php
//print_r($pais_lottery_data);
