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
				var ro = new ResizeObserver(updateHeaderOffset);
				ro.observe(header);
				var inner = header.querySelector('.gbe-header__inner');
				if (inner) {
					ro.observe(inner);
				}
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
