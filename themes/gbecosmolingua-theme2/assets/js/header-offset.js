(function () {
	'use strict';

	function updateHeaderOffset() {
		var header = document.querySelector('.gbe-site-header');
		if (!header) {
			return;
		}

		var height = Math.ceil(header.getBoundingClientRect().height);
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
