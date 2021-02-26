<div class="pais_lottery <?=$layout ?> <?=$data_type ?> <?=$data_source ?>">

    <div class="lottery_heading">
    	<h4<?php echo (!empty($background_color))? ' style="color: '.$background_color.'"' : ''; ?>><?=$title ?></h4>
    	
    	<div class="lottery_timer">
    		<ul class="lottery_timer_header">
    			<li>דקות</li>
    			<li>שעות</li>
    			<li>ימים</li>
    		</ul>
    		
    		<div class="c"></div>
    		
    		<ul class="lottery_timer_countdown" data-epoc-now="<?=time() ?>" data-epoc-expires="<?=$pais_lottery_data['next']['unixtime'][0] ?>">
    			<li class="lottery_minutes"<?php echo (!empty($background_color))? ' style="background-color: '.$background_color.'"' : ''; ?>><?=$pais_lottery_data['next']['timeleft'][0]['minutes'] ?></li>
    			<li class="lottery_hours"<?php echo (!empty($background_color))? ' style="background-color: '.$background_color.'"' : ''; ?>><?=$pais_lottery_data['next']['timeleft'][0]['hours'] ?></li>
    			<li class="lottery_days"<?php echo (!empty($background_color))? ' style="background-color: '.$background_color.'"' : ''; ?>><?=$pais_lottery_data['next']['timeleft'][0]['days'] ?></li>
    		</ul>
    		
    		<div class="c"></div>
    	</div>
    </div>
    
    <div class="lottery_content"<?php echo (!empty($background_color))? ' style="border-color: '.$background_color.'"' : ''; ?>>
    	<h4><?=$title_sub ?></h4>
    	
    	<div class="lottery_id">הגרלה מספר: <span><?=$pais_lottery_data['archive']['id'][0] ?></span></div>
    	
    	<div class="lottery_date">
    		מתאריך: <span><?=$pais_lottery_data['archive']['date'][0] ?></span>
    		שעה: <span><?=$pais_lottery_data['archive']['time'][0] ?></span>
    	</div>
    	
    	
        <?php
            if (
                array_key_exists('cards_type', $pais_lottery_data['archive']) && is_array($pais_lottery_data['archive']['cards_type']) &&
                array_key_exists('cards_symbols', $pais_lottery_data['archive']) && is_array($pais_lottery_data['archive']['cards_symbols'])
            ) {
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
                
                echo '<div class="lottery_cards">';
                    echo '<ol>';
                        foreach($pais_lottery_data['archive']['cards_type'] as $card) {
                            echo '<li class="lottery_symbol_'.$card.'" style="color: '.$cardIcons[$card]['color'].'">'.$cardIcons[$card]['icon'].'</li>';
                        }
                    echo '</ol>';
                    
                    echo '<ul>';
                        foreach($pais_lottery_data['archive']['cards_symbols'] as $symbol) {
                            echo '<li>'.$symbol.'</li>';
                        }
                    echo '</ul>';
                
                echo '</div>';
            }
            
            
            if (array_key_exists('numbers', $pais_lottery_data['archive']) && is_array($pais_lottery_data['archive']['numbers'])) {
                echo '<div class="lottery_numbers">';
                    echo '<ol class="balls">';
                    
                    if (!empty($background_color)) {
                        $num_bg_color = ' style="background-color: '.$background_color.'"';
                    }
                
                    foreach($pais_lottery_data['archive']['numbers'] as $number) {
                        echo '<li'.$num_bg_color.'>'.$number.'</li>';
                    }
                    
                    if (array_key_exists('number_strong', $pais_lottery_data['archive'])) {
                        echo '<li>'.$pais_lottery_data['archive']['number_strong'][0].'</li>';
                    }
                    
                    echo '</ol>';
                echo '</div>';
            }
        ?>

        <?php
            if (array_key_exists('extra', $pais_lottery_data)) {
                $numbers_list = '';
                foreach($pais_lottery_data['extra']['numbers'] as $number) {
                    $numbers_list .= $number;
                }
                
                echo '<div class="lottery_extra">אקסטרה: <span>'.$numbers_list.'</span></div>';
            }
            
        ?>
    	
    	
    </div>

</div>