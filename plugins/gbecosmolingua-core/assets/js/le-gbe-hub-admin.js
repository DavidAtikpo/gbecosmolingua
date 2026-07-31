jQuery(function ($) {
	$(document).on('click', '.gbe-le-gbe-pick-media', function (e) {
		e.preventDefault();
		var targetId = $(this).data('target');
		var $input = $('#' + targetId);
		var $preview = $input.siblings('.gbe-le-gbe-media-preview');

		var frame = wp.media({
			title: 'Choisir une image',
			library: { type: 'image' },
			multiple: false,
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$input.val(attachment.id);
			if (attachment.sizes && attachment.sizes.medium) {
				$preview.html(
					'<img src="' + attachment.sizes.medium.url + '" alt="" style="max-width:100%;height:auto;" />'
				);
			} else if (attachment.url) {
				$preview.html(
					'<img src="' + attachment.url + '" alt="" style="max-width:100%;height:auto;" />'
				);
			}
		});

		frame.open();
	});

	$(document).on('click', '.gbe-le-gbe-clear-media', function (e) {
		e.preventDefault();
		var targetId = $(this).data('target');
		$('#' + targetId).val('');
		$('#' + targetId)
			.siblings('.gbe-le-gbe-media-preview')
			.html('<span class="description">Aucune image</span>');
	});

	var $slidesWrap = $('#gbe-le-gbe-hero-slides');
	if ($slidesWrap.length) {
		function reindexHeroSlides() {
			$slidesWrap.find('.gbe-le-gbe-hero-slide').each(function (i) {
				var $slide = $(this);
				$slide.find('.gbe-le-gbe-hero-slide__label').text('Diapositive ' + (i + 1));
				$slide.find('[name^="gbe_le_gbe_hero_slides["]').each(function () {
					var $field = $(this);
					var suffix = $field.attr('name').replace(/^gbe_le_gbe_hero_slides\[[^\]]+\]/, '');
					$field.attr('name', 'gbe_le_gbe_hero_slides[' + i + ']' + suffix);
				});
				var $bgInput = $slide.find('input[type="hidden"][id^="gbe_hero_slide_bg_"]');
				if ($bgInput.length) {
					$bgInput.attr('id', 'gbe_hero_slide_bg_' + i);
					$slide.find('.gbe-le-gbe-pick-media, .gbe-le-gbe-clear-media').attr('data-target', 'gbe_hero_slide_bg_' + i);
				}
			});
		}

		$('#gbe-le-gbe-add-hero-slide').on('click', function (e) {
			e.preventDefault();
			var tmpl = $('#tmpl-gbe-le-gbe-hero-slide').html();
			if (!tmpl) {
				return;
			}
			var index = $slidesWrap.find('.gbe-le-gbe-hero-slide').length;
			var html = tmpl.replace(/__INDEX__/g, String(index));
			$slidesWrap.append(html);
			reindexHeroSlides();
		});

		$slidesWrap.on('click', '.gbe-le-gbe-remove-hero-slide', function (e) {
			e.preventDefault();
			if ($slidesWrap.find('.gbe-le-gbe-hero-slide').length <= 1) {
				window.alert('Il faut au moins une diapositive.');
				return;
			}
			$(this).closest('.gbe-le-gbe-hero-slide').remove();
			reindexHeroSlides();
		});

		if ($.fn.sortable) {
			$slidesWrap.sortable({
				items: '.gbe-le-gbe-hero-slide',
				handle: 'legend',
				axis: 'y',
				stop: reindexHeroSlides,
			});
		}

		$('#post, #gbe-hub-composer-form').on('submit', reindexHeroSlides);
		$('#publish, #save-post, #gbe-hub-composer-form input[type="submit"]').on('click', reindexHeroSlides);
	}
});
