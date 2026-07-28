(function () {
	'use strict';

	function closeSwitcher(nav) {
		var btn = nav.querySelector('.gbe-lang-switcher__toggle');
		var menu = nav.querySelector('.gbe-lang-switcher__menu');
		nav.classList.remove('is-open');
		if (btn) {
			btn.setAttribute('aria-expanded', 'false');
		}
		if (menu) {
			menu.hidden = true;
		}
	}

	function initSwitcher(nav) {
		var btn = nav.querySelector('.gbe-lang-switcher__toggle');
		var menu = nav.querySelector('.gbe-lang-switcher__menu');
		if (!btn || !menu) {
			return;
		}

		closeSwitcher(nav);

		btn.addEventListener('click', function (event) {
			event.preventDefault();
			event.stopPropagation();
			var open = !nav.classList.contains('is-open');
			if (open) {
				document.querySelectorAll('.gbe-lang-switcher--dropdown.is-open').forEach(function (other) {
					if (other !== nav) {
						closeSwitcher(other);
					}
				});
			}
			nav.classList.toggle('is-open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			menu.hidden = !open;
		});

		menu.addEventListener('click', function (event) {
			event.stopPropagation();
		});

		menu.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				closeSwitcher(nav);
			});
		});
	}

	function boot() {
		document.querySelectorAll('.gbe-lang-switcher--dropdown').forEach(initSwitcher);

		document.addEventListener('click', function () {
			document.querySelectorAll('.gbe-lang-switcher--dropdown.is-open').forEach(closeSwitcher);
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				document.querySelectorAll('.gbe-lang-switcher--dropdown.is-open').forEach(closeSwitcher);
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
