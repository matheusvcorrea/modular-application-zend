jQuery(document).ready(function($) {
	$('#username').focus();
	
	$('.form-new-page #general-name').focus();
	
	$('#myTabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	
	$('.summernote').summernote({
		height: 300
	});
});


