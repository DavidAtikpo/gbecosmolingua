(function () {
	'use strict';

	function readAdminBarHeight() {
		if (!document.body || !document.body.classList.contains('admin-bar')) {
			return 0;
		}

		var adminBar = document.getElementById('wpadminbar');
		if (adminBar) {
			return Math.ceil(adminBar.offsetHeight);
		}

		return window.matchMedia('(max-width: 782px)').matches ? 46 : 32;
	}

	function updateHeaderOffset() {
		var header = document.querySelector('.gbe-site-header');
		if (!header) {
			return;
		}

		var adminHeight = readAdminBarHeight();
		var adminValue = adminHeight + 'px';

		document.documentElement.style.setProperty('--gbe-admin-bar-height', adminValue);
		if (document.body) {
			document.body.style.setProperty('--gbe-admin-bar-height', adminValue);
		}

		// Hauteur totale du bandeau fixe (padding admin-bar + chrome header).
		var height = Math.ceil(header.getBoundingClientRect().height) + 4;
		var value = height + 'px';

		document.documentElement.style.setProperty('--gbe-header-height', value);
		if (document.body) {
			document.body.style.setProperty('--gbe-header-height', value);
		}
	}

	/* Mesure immédiate si le DOM est déjà prêt (script dans <head>). */
	if (document.body) {
		updateHeaderOffset();
	}

	function scheduleUpdate() {
		window.requestAnimationFrame(updateHeaderOffset);
	}

	function init() {
		scheduleUpdate();
		window.addEventListener('resize', scheduleUpdate);

		if (typeof ResizeObserver !== 'undefined') {
			var header = document.querySelector('.gbe-site-header');
			if (header) {
				var ro = new ResizeObserver(scheduleUpdate);
				ro.observe(header);
				var inner = header.querySelector('.gbe-header__inner');
				if (inner) {
					ro.observe(inner);
				}
				var bottom = header.querySelector('.gbe-header__bottom');
				if (bottom) {
					ro.observe(bottom);
				}
			}

			var adminBar = document.getElementById('wpadminbar');
			if (adminBar) {
				var adminRo = new ResizeObserver(scheduleUpdate);
				adminRo.observe(adminBar);
			}
		}

		window.addEventListener('load', scheduleUpdate);

		if (document.fonts && document.fonts.ready) {
			document.fonts.ready.then(scheduleUpdate);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
