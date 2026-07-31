jQuery(function ($) {
	function fieldKey($el, type) {
		var attr =
			type === 'band'
				? 'data-band-field'
				: type === 'more'
					? 'data-more-field'
					: 'data-sub-field';
		var key = $el.attr(attr);
		if (!key) {
			key = $el.data(type === 'band' ? 'bandField' : type === 'more' ? 'moreField' : 'subField');
		}
		return key;
	}

	function reindexLayout() {
		$('#gbe-le-gbe-bands-list .gbe-le-gbe-band').each(function (bi) {
			var $band = $(this);
			$band.find('[data-band-field]').each(function () {
				var field = fieldKey($(this), 'band');
				if (field) {
					$(this).attr('name', 'gbe_le_gbe_layout[bands][' + bi + '][' + field + ']');
				}
			});
			$band.find('.gbe-le-gbe-subcards-list .gbe-le-gbe-subcard').each(function (si) {
				$(this)
					.find('[data-sub-field]')
					.each(function () {
						var field = fieldKey($(this), 'sub');
						if (field) {
							$(this).attr(
								'name',
								'gbe_le_gbe_layout[bands][' + bi + '][subcards][' + si + '][' + field + ']'
							);
						}
					});
			});
		});

		$('#gbe-le-gbe-more-list .gbe-le-gbe-more-card').each(function (mi) {
			$(this)
				.find('[data-more-field]')
				.each(function () {
					var field = fieldKey($(this), 'more');
					if (field) {
						$(this).attr('name', 'gbe_le_gbe_layout[more][' + mi + '][' + field + ']');
					}
				});
		});
	}

	function initSubcardSortable($scope) {
		if (!$.fn.sortable) {
			return;
		}
		$scope.find('.gbe-le-gbe-subcards-list').each(function () {
			var $list = $(this);
			if ($list.data('ui-sortable')) {
				return;
			}
			$list.sortable({
				handle: '.gbe-le-gbe-subcard-handle',
				update: reindexLayout,
			});
		});
	}

	if ($.fn.sortable) {
		$('#gbe-le-gbe-bands-list').sortable({
			handle: '.gbe-le-gbe-band-handle',
			placeholder: 'gbe-le-gbe-sort-placeholder',
			update: reindexLayout,
		});

		$('#gbe-le-gbe-more-list').sortable({
			handle: '.gbe-le-gbe-more-card-handle',
			placeholder: 'gbe-le-gbe-sort-placeholder',
			update: reindexLayout,
		});
	}

	initSubcardSortable($(document));

	$('#gbe-le-gbe-add-band').on('click', function (e) {
		e.preventDefault();
		var tpl = $('#gbe-le-gbe-band-template').html();
		$('#gbe-le-gbe-bands-list').append(tpl);
		initSubcardSortable($('#gbe-le-gbe-bands-list .gbe-le-gbe-band').last());
		reindexLayout();
	});

	$('#gbe-le-gbe-add-more-card').on('click', function (e) {
		e.preventDefault();
		var tpl = $('#gbe-le-gbe-more-card-template').html();
		$('#gbe-le-gbe-more-list').append(tpl);
		reindexLayout();
	});

	$(document).on('click', '.gbe-le-gbe-add-subcard', function (e) {
		e.preventDefault();
		var $list = $(this).closest('.gbe-le-gbe-band').find('.gbe-le-gbe-subcards-list');
		var tpl = $('#gbe-le-gbe-subcard-template').html();
		$list.append(tpl);
		reindexLayout();
	});

	$(document).on('click', '.gbe-le-gbe-remove-band', function (e) {
		e.preventDefault();
		if (window.confirm('Supprimer cette section ?')) {
			$(this).closest('.gbe-le-gbe-band').remove();
			reindexLayout();
		}
	});

	$(document).on('click', '.gbe-le-gbe-remove-subcard', function (e) {
		e.preventDefault();
		$(this).closest('.gbe-le-gbe-subcard').remove();
		reindexLayout();
	});

	$(document).on('click', '.gbe-le-gbe-remove-more-card', function (e) {
		e.preventDefault();
		$(this).closest('.gbe-le-gbe-more-card').remove();
		reindexLayout();
	});

	reindexLayout();

	$('#post, #gbe-hub-composer-form').on('submit', function () {
		reindexLayout();
	});

	$(document).on('click', '#publish, #save-post, .editor-post-publish-button, #gbe-hub-composer-form input[type="submit"]', function () {
		reindexLayout();
	});
});
