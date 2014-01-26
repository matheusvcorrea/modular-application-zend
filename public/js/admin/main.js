jQuery(document).ready(function($) {
	// Define Focus
	$('#username').focus();	
	$('input[name="general[page_name]"]').focus();
	
	// Configure Tabs Bootstrap
	$('#myTabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	
	// Configure Summernote plugin
	if ($('.summernote').length > 0) {
		$('.summernote').summernote({
			height: 300
		});
	}	
});

(function() {

var win = $(window);

win.resize(function() {
	var main_height = (win.height()-51);
	$('.main').css({
		'min-height' : main_height
	});
}).resize();
  
})(jQuery);
