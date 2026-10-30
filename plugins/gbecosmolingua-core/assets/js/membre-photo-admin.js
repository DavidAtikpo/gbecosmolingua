jQuery(function ($) {
	var frame;

	function renderPreview(attachment) {
		var preview = $('#gbe_membre_photo_preview');
		if (!attachment || !attachment.id) {
			preview.html('<p class="gbe-membre-photo-admin__empty"><em>Aucune photo.</em></p>');
			$('.gbe-membre-photo-remove').prop('disabled', true);
			return;
		}

		var sizes = attachment.sizes || {};
		var image = sizes.medium || sizes.thumbnail || attachment;
		var src = image.url || attachment.url;

		preview.html(
			'<img src="' + src + '" alt="" style="max-width:100%;height:auto;border-radius:12px;" />'
		);
		$('.gbe-membre-photo-remove').prop('disabled', false);
	}

	$(document).on('click', '.gbe-membre-photo-select', function (event) {
		event.preventDefault();

		if (frame) {
			frame.open();
			return;
		}

		frame = wp.media({
			title: 'Photo du membre',
			button: { text: 'Utiliser cette photo' },
			library: { type: 'image' },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$('#gbe_membre_thumbnail_id').val(attachment.id);
			renderPreview(attachment);
		});

		frame.open();
	});

	$(document).on('click', '.gbe-membre-photo-remove', function (event) {
		event.preventDefault();
		$('#gbe_membre_thumbnail_id').val('0');
		renderPreview(null);
	});
});
