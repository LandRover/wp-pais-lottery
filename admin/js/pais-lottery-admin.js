/*<![CDATA[*/
(
	function ($) {
		'use strict';
		function init_basic() {
			$('#widgets-right').on( 'click', '.shortcode_toggle_link', function() {
				$('.shortcode_toggle_div').show();
				return false;
			});
		}
		
		$(document).ready(function($) {
            init_basic();
            
            $('.color_picker').hover(function() {
                $('.color_picker').wpColorPicker();
            });
        });
        
		$(document).ajaxComplete(function() {
            init_basic();
            $('.color_picker').wpColorPicker();
        });
	}
)(jQuery);
/*]]>*/
