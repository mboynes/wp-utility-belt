jQuery(function($){
	if($('#wpadminbar').length)
		$('.navbar-fixed-top').css('top',$('#wpadminbar').height());

	$('#view_wrapper').on('click','input:submit',function(e){
		e.preventDefault();
		$form = $(this).parents('form');
		button = ($(this).attr('name') ? '&' + $(this).attr('name') + '=' + $(this).val() : '');
		url = $form.find('input[name="full"]').length ? '/' : ajaxurl;
		$.post(url, $form.serialize()+button, function(data){
			if('<html>'==data.substr(0,6)) {
				$('#'+$form.data('response')+'').html(data.replace(/<\/?html>/,'')).fadeIn();
			} else if (-1 !== data.indexOf('xdebug-var-dump')) {
				data = data.replace('xdebug-var-dump', 'xdebug-var-dump well');
				$('#'+$form.data('response')+'').html(data).fadeIn();
			} else {
				$('#'+$form.data('response')+'').html( $('<pre class="well" />').text( data ) ).fadeIn();
			}
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
				initialize_codemirror();
			});
		}
		$('.active').removeClass('active');
		$('a[href="#'+hash+'"]').parent().addClass('active');
	}
	window.onhashchange = get_hash;

	function initialize_codemirror() {
		$('#view_wrapper')
			// Include a data-ub-codemirror attribute to make it eligible for CodeMirror.
			.find('[data-ub-codemirror]')
			.each(function(index, element) {
				var $element = $(element);

				if ($element.data('ub-codemirror') === '1') {
					// Already initialized.
					return;
				}

				// Initialize CodeMirror instance.
				var editor = wp.codeEditor.initialize($element);
				$element.data('ub-codemirror', '1');

				// Copy code back to <textarea> on change so it's submitted.
				editor.codemirror.on('change', function () {
					var value = editor.codemirror.getValue();
					if (value !== $element.val()) {
						$element.val(value).trigger('change');
					}
				});
			});
	}

	get_hash();
	initialize_codemirror();
});
var hash;
