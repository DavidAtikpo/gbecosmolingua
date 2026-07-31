(function () {
	'use strict';

	var mobileQuery = window.matchMedia('(max-width: 781px)');

	function isMobileMenu() {
		return mobileQuery.matches;
	}

	function setItemOpen(item, open) {
		item.classList.toggle('is-open', open);
		var toggle = item.querySelector(':scope > .gbe-main-menu__toggle');
		if (toggle) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		}
	}

	function closeAllPanels() {
		document.querySelectorAll('.gbe-main-menu__item.is-open').forEach(function (item) {
			setItemOpen(item, false);
		});
	}

	function closeSiblingPanels(item) {
		var list = item.parentElement;
		if (!list) {
			return;
		}
		list.querySelectorAll('.gbe-main-menu__item.is-open').forEach(function (sibling) {
			if (sibling !== item) {
				setItemOpen(sibling, false);
			}
		});
	}

	function initMobileMenu() {
		var menu = document.querySelector('.gbe-main-menu');
		if (!menu) {
			return;
		}

		document.querySelectorAll('.gbe-main-menu__item.has-children').forEach(function (item) {
			var toggle = item.querySelector(':scope > .gbe-main-menu__toggle');
			var panel = item.querySelector(':scope > .gbe-main-menu__panel');
			if (!toggle || !panel) {
				return;
			}

			toggle.addEventListener('click', function (event) {
				if (!isMobileMenu()) {
					return;
				}
				event.preventDefault();
				event.stopPropagation();
				var open = item.classList.contains('is-open');
				closeSiblingPanels(item);
				setItemOpen(item, !open);
			});

			panel.addEventListener('click', function (event) {
				event.stopPropagation();
			});
		});

		document.addEventListener('click', function (event) {
			if (!isMobileMenu()) {
				return;
			}
			if (!menu.contains(event.target)) {
				closeAllPanels();
			}
		});

		mobileQuery.addEventListener('change', function () {
			if (!isMobileMenu()) {
				closeAllPanels();
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
