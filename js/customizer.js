/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
	// Site title and description.
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});
	wp.customize('readly_background_color', function(value) {
		value.bind(function(to) {
			$('body, button, input, select, textarea, #page, #masthead, #colophon').css('background', to);
			$('.entry-content a').css('border-bottom', '1px solid ' + to);
			background_color = to;
		});
	});
	wp.customize('readly_color', function(value) {
		value.bind(function(to) {
			$('.entry-content a').css('color', to);
			hover_color = to;
		});
	});
})(jQuery);
