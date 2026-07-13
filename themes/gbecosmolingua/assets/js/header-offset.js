(function () {
	'use strict';

	function updateHeaderOffset() {
		var header = document.querySelector('.gbe-site-header');
		if (!header) {
			return;
		}

		var height = Math.ceil(header.getBoundingClientRect().height);
		document.documentElement.style.setProperty('--gbe-header-height', height + 'px');
	}

	function init() {
		updateHeaderOffset();
		window.addEventListener('resize', updateHeaderOffset);

		if (typeof ResizeObserver !== 'undefined') {
			var header = document.querySelector('.gbe-site-header');
			if (header) {
				new ResizeObserver(updateHeaderOffset).observe(header);
			}
		}

		window.addEventListener('load', updateHeaderOffset);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
