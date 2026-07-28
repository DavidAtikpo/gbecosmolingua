(function () {
	'use strict';

	var mobileQuery = window.matchMedia('(max-width: 781px)');

	function isMobileMenu() {
		return mobileQuery.matches;
	}

	function closeSiblingPanels(item) {
		var list = item.parentElement;
		if (!list) {
			return;
		}
		list.querySelectorAll('.gbe-main-menu__item.is-open').forEach(function (sibling) {
			if (sibling !== item) {
				sibling.classList.remove('is-open');
			}
		});
	}

	function initMobileMenu() {
		document.querySelectorAll('.gbe-main-menu__item.has-children').forEach(function (item) {
			var link = item.querySelector(':scope > .gbe-main-menu__link');
			var panel = item.querySelector(':scope > .gbe-main-menu__panel');
			if (!link || !panel) {
				return;
			}

			link.addEventListener('click', function (event) {
				if (!isMobileMenu()) {
					return;
				}
				event.preventDefault();
				var open = item.classList.contains('is-open');
				closeSiblingPanels(item);
				item.classList.toggle('is-open', !open);
				if (!open && typeof item.scrollIntoView === 'function') {
					window.setTimeout(function () {
						item.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
					}, 50);
				}
			});
		});

		mobileQuery.addEventListener('change', function () {
			if (!isMobileMenu()) {
				document.querySelectorAll('.gbe-main-menu__item.is-open').forEach(function (item) {
					item.classList.remove('is-open');
				});
			}
		});
	}

	function boot() {
		initMobileMenu();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
