(function () {
	'use strict';

	var mobileQuery = window.matchMedia('(max-width: 781px)');
	var SCROLL_THRESHOLD = 10;
	var TOP_ALWAYS_SHOW = 20;

	var header = null;
	var lastScrollY = 0;
	var ticking = false;

	function isMobileNav() {
		return mobileQuery.matches;
	}

	function closeMobilePanels() {
		document.querySelectorAll('.gbe-main-menu__item.is-open').forEach(function (item) {
			item.classList.remove('is-open');
			var toggle = item.querySelector(':scope > .gbe-main-menu__toggle');
			if (toggle) {
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	function setNavCollapsed(collapsed) {
		if (!header) {
			return;
		}

		var next = collapsed && isMobileNav();
		var current = header.classList.contains('is-nav-collapsed');

		if (next === current) {
			return;
		}

		header.classList.toggle('is-nav-collapsed', next);

		if (next) {
			closeMobilePanels();
		}
	}

	function handleScroll() {
		if (!header || !isMobileNav()) {
			setNavCollapsed(false);
			return;
		}

		var scrollY = window.scrollY || window.pageYOffset || 0;
		var delta = scrollY - lastScrollY;

		if (scrollY <= TOP_ALWAYS_SHOW) {
			setNavCollapsed(false);
		} else if (delta > SCROLL_THRESHOLD) {
			setNavCollapsed(true);
		} else if (delta < -SCROLL_THRESHOLD) {
			setNavCollapsed(false);
		}

		lastScrollY = scrollY;
	}

	function onScroll() {
		if (!ticking) {
			ticking = true;
			window.requestAnimationFrame(function () {
				handleScroll();
				ticking = false;
			});
		}
	}

	function onViewportChange() {
		if (!isMobileNav()) {
			setNavCollapsed(false);
			lastScrollY = window.scrollY || window.pageYOffset || 0;
		}
	}

	function init() {
		header = document.querySelector('.gbe-site-header');
		if (!header) {
			return;
		}

		lastScrollY = window.scrollY || window.pageYOffset || 0;
		window.addEventListener('scroll', onScroll, { passive: true });
		mobileQuery.addEventListener('change', onViewportChange);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
