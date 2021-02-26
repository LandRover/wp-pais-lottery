<div class="pais_lottery pais_lottery_statistics">

    <div class="lottery_statistics_tabs">
        <ul>
            <?php
                foreach($sourcesList as $source => $provider) {
                    $isCurrent = ('pais_lotto' === $source) ? ' lottery_current' : '';
                    
                    echo '<li class="'.$provider['tab']['className'].$isCurrent.'" data-source="'.$source.'" '.$isCurrent.'><strong><a href="javascript:;">'.$provider['tab']['title'].'</a></strong></li>';
                }
            ?>
        </ul>
        <div class="c"></div>
    </div>
    
    <div class="lottery_statistics_content">
        <?php
            foreach($sourcesList as $source => $provider) {
                $isCurrent = ('pais_lotto' === $source) ? ' lottery_current' : '';

                echo '<div class="pais_lottery_statistics_source lottery_statistics_'.$source.$isCurrent.'">';
                    if (array_key_exists('title_sub', $provider)) {
                        $title_sub_insert = 'title_sub="'.$provider['title_sub'].'"';
                    }

                    echo do_shortcode('[shortcode-pais-lottery data_type="lottery_statistics" data_source="'.$source.'" title="'.$provider['title'].'" '.$title_sub_insert.' layout="pais_lottery_box_large"]');
                echo '</div>';
            }
            
        ?>
    </div>
    
</div>