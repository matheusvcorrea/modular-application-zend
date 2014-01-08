jQuery(document).ready(function($) {
	$('#username').focus();
	$('.form-new-page #general-name').focus();
	$('#myTabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	$('.summernote').summernote();

	$('input[name="save[buttons][save]"]').click(function(event) {
		/* Act on the event */
		//alert('Salvar');
		//return false;
	});

	$('input[name="save[buttons][cancel]"]').click(function(event) {
		/* Act on the event */
		//alert('Cancelar');
		//return false;
	});
});
