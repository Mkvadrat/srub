$(document).ready(function() {
	$(document).ready(function() {
		//Form Submit for IE Browser
		$('button[type=\'submit\']').on('click', function() {
			$("form[id*='form-']").submit();
		});

		// Highlight any found errors
		$('.text-danger').each(function() {
			var element = $(this).parent().parent();

			if (element.hasClass('form-group')) {
				element.addClass('has-error');
			}
		});

		// Set last page opened on the menu
		$('#menu a[href]').on('click', function() {
			sessionStorage.setItem('menu', $(this).attr('href'));
		});

		if (!sessionStorage.getItem('menu')) {
			$('#menu #dashboard').addClass('active');
		} else {
			// Sets active and open to selected page in the left column menu.
			$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active open');
		}

		if (localStorage.getItem('column-left') == 'active') {
			$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

			$('#column-left').addClass('active');

			// Slide Down Menu
			$('#menu li.active').has('ul').children('ul').addClass('collapse in');
			$('#menu li').not('.active').has('ul').children('ul').addClass('collapse');
		} else {
			$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

			$('#menu li li.active').has('ul').children('ul').addClass('collapse in');
			$('#menu li li').not('.active').has('ul').children('ul').addClass('collapse');
		}

		// Menu button
		$('#button-menu').on('click', function() {
			// Checks if the left column is active or not.
			if ($('#column-left').hasClass('active')) {
				localStorage.setItem('column-left', '');

				$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

				$('#column-left').removeClass('active');

				$('#menu > li > ul').removeClass('in collapse');
				$('#menu > li > ul').removeAttr('style');
			} else {
				localStorage.setItem('column-left', 'active');

				$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

				$('#column-left').addClass('active');

				// Add the slide down to open menu items
				$('#menu li.open').has('ul').children('ul').addClass('collapse in');
				$('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
			}
		});

		// Menu
		$('#menu').find('li').has('ul').children('a').on('click', function() {
			if ($('#column-left').hasClass('active')) {
				$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
				$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
			} else if (!$(this).parent().parent().is('#menu')) {
				$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
				$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
			}
		});

		// Override summernotes image manager
		$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');

		$(document).delegate('button[data-toggle=\'image\']', 'click', function() {
			$('#modal-image').remove();

			$(this).parents('.note-editor').find('.note-editable').focus();

			$.ajax({
				url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
				dataType: 'html',
				beforeSend: function() {
					$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-image').prop('disabled', true);
				},
				complete: function() {
					$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
					$('#button-image').prop('disabled', false);
				},
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

					$('#modal-image').modal('show');
				}
			});
		});
		
		// Image Manager	
		$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
			e.preventDefault();

			$('.popover').popover('hide', function() {
				$('.popover').remove();
			});

			var element = this;

			$(element).popover({
				html: true,
				placement: 'right',
				trigger: 'manual',
				content: function() {
					return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-imagemanager" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i></button></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
				}
			});

			$(element).popover('show');

			$('#button-image').on('click', function() {
				$('#modal-image').remove();

				$.ajax({
					url: 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
					dataType: 'html',
					beforeSend: function() {
						$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
						$('#button-image').prop('disabled', true);
					},
					complete: function() {
						$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
						$('#button-image').prop('disabled', false);
					},
					success: function(html) {
						$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

						$('#modal-image').modal('show');
					}
				});

				$(element).popover('hide', function() {
					$('.popover').remove();
				});
			});
			
			$('#button-imagemanager').on('click', function() {
				$('#modal-image').remove();

				$.ajax({
					url: 'index.php?route=common/imagemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
					dataType: 'html',
					beforeSend: function() {
						$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
						$('#button-image').prop('disabled', true);
					},
					complete: function() {
						$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
						$('#button-image').prop('disabled', false);
					},
					success: function(html) {
						$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

						$('#modal-image').modal('show');
					}
				});

				$(element).popover('hide', function() {
					$('.popover').remove();
				});
			});

			$('#button-clear').on('click', function() {
				$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

				$(element).parent().find('input').attr('value', '');

				$(element).popover('hide', function() {
					$('.popover').remove();
				});
			});
		});
		
		// tooltips on hover
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

		// Makes tooltips work on ajax generated content
		$(document).ajaxStop(function() {
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		});

		// https://github.com/opencart/opencart/issues/2595
		$.event.special.remove = {
			remove: function(o) {
				if (o.handler) {
					o.handler.apply(this, arguments);
				}
			}
		}

		$('[data-toggle=\'tooltip\']').on('remove', function() {
			$(this).tooltip();
			$(this).tooltip('destroy');
		});
	});
});