/*<![CDATA[*/
(
	function ($) {
		'use strict';
        
        
        // BASIC WIDGET COUNTERS
        let secondsInterval = 30;

        let secondsToCountdown = function(seconds) {
            seconds = (seconds <= 0) ? 0 : seconds;
            
            return {
                days: ('0' + Math.floor(seconds / (3600*24))).slice(-2),
                hours: ('0' + Math.floor(seconds % (3600*24) / 3600)).slice(-2),
                minutes: ('0' + Math.floor(seconds % 3600 / 60)).slice(-2)
            }
        }
        
        let monitorTimers = function() {
            document.querySelectorAll('.lottery_timer_countdown').forEach((el) => {
                let now = Date.now()/1000,
                    expires = el.dataset.epocExpires;
                
                let diff = expires - now;
                let countdown = secondsToCountdown(diff);

                el.querySelector('.lottery_days').innerHTML = countdown['days'];
                el.querySelector('.lottery_hours').innerHTML = countdown['hours'];
                el.querySelector('.lottery_minutes').innerHTML = countdown['minutes'];
            });
        };
        
        let startCountdowns = function() {
            console.info('[v] Starting countdown for lottery countdowns');
            
            setInterval(function() {
                monitorTimers();
            }, secondsInterval * 1000);
        };
        
        
        // STASTICS WIDGET TABS SWTICHER
        let bindTabs = function() {
            let tabs = document.querySelectorAll('.lottery_statistics_tabs ul li strong a');
            
            tabs.forEach(function(el) {
                el.onclick = function(e) {
                    // swtich active tab
                    let tabsList = e.target.parentNode.parentNode.parentNode;
                    let sourceId = e.target.parentNode.parentNode.getAttribute('data-source');
                    
                    $(tabsList).find('li').removeClass('lottery_current');
                    
                    $(e.target.parentNode.parentNode).addClass('lottery_current');
                    
                    // swtich active content
                    let activeContent = tabsList.parentNode.parentNode.parentNode.parentNode;
                    $(activeContent).find('.pais_lottery_statistics_source').removeClass('lottery_current');
                    
                    $(activeContent).find('.lottery_statistics_'+ sourceId).addClass('lottery_current');
                };
            });
        };
        
        
        
        
		$(document).ready(function($) {
            console.info('[v] Lottery initializing...');
            startCountdowns();
            monitorTimers();
            bindTabs();
        });
	}
)(jQuery);
/*]]>*/