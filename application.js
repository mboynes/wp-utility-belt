jQuery(function($){
	if($('#wpadminbar').length)
		$('.navbar-fixed-top').css('top',$('#wpadminbar').height());

	$('#view_wrapper').on('click','input:submit',function(e){
		e.preventDefault();
		$form = $(this).parents('form');
		button = ($(this).attr('name') ? '&' + $(this).attr('name') + '=' + $(this).val() : '');
		url = $form.find('input[name="full"]').length ? '/' : ajaxurl;
		$.post(url, $form.serialize()+button, function(data){
			if('<html>'==data.substr(0,6))
				$('#'+$form.data('response')+'').html(data.replace(/<\/?html>/,'')).fadeIn();
			else
				$('#'+$form.data('response')+'').html( $('<pre class="well" />').text( data ) ).fadeIn();
		});
	});
	$('#view_wrapper').on('click','.reload',function(e){
		e.preventDefault();
		page = $(this).data('page');
		$('#'+page).remove();
		get_hash(page);
	});
	$("#response").ajaxError(function(e, jqxhr, settings, exception) {
		$('#response').html('<pre class="well">'+exception+' ('+jqxhr.status+")\n"+jqxhr.responseText+'</pre>').fadeIn();
	});
	$('#change_view').click(function(e) {
		e.preventDefault();
		$('#view_wrapper').toggleClass('row');
		$('.view-container').toggleClass('span6');
		if ($('textarea.span12').length)
			$('textarea.span12').removeClass('span12').addClass('span6');
		else
			$('textarea.span6').removeClass('span6').addClass('span12');
	});

	function get_hash(h) {
		if (!h || typeof h != 'string') {
			// hash = e.newURL.split('#').pop();
			hash = window.location.hash.substr(1);
			if (!hash) hash = 'home';
		}
		else {
			hash = h;
			if (window.location.hash != '#' + hash ) {
				window.location.hash = '#' + hash;
				return;
			}
		}
		$('#view_wrapper > div').hide();
		if ($('#'+hash).length) {
			$('#'+hash).fadeIn('fast');
		}
		else {
			$.get(ajaxurl, {action:hash}, function(data){
				$('#view_wrapper').append(data);
			});
		}
		$('.active').removeClass('active');
		$('a[href="#'+hash+'"]').parent().addClass('active');
	}
	window.onhashchange = get_hash;

	get_hash();
});
var hash;