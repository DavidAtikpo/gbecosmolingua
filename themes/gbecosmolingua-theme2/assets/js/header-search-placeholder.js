(function () {
	'use strict';

	var phrases = (window.gbeHeaderSearch && window.gbeHeaderSearch.phrases) || [
		'Rechercher sur le site…',
		'Un proverbe gbe…',
		'Xótùtù, récits oraux…',
		'Langues et cultures…',
		'Partenaires, événements…'
	];

	var intervalMs = 3200;
	var fadeMs = 420;

	function prefersReducedMotion() {
		return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function initSearchAnimation() {
		var search = document.querySelector('.gbe-header__search');
		if (!search) {
			return;
		}

		var input = search.querySelector('.wp-block-search__input');
		var wrapper = search.querySelector('.wp-block-search__inside-wrapper');
		if (!input || !wrapper) {
			return;
		}

		var staticPlaceholder = input.getAttribute('placeholder') || 'Rechercher sur le site…';

		if (prefersReducedMotion()) {
			return;
		}

		var overlay = document.createElement('span');
		overlay.className = 'gbe-header__search-placeholder';
		overlay.setAttribute('aria-hidden', 'true');
		wrapper.appendChild(overlay);
		search.classList.add('gbe-header__search--animated');

		var index = 0;
		var timer = null;

		function setPhrase(text) {
			overlay.textContent = text;
		}

		function updateVisibility() {
			var hide =
				document.activeElement === input ||
				(input.value && input.value.trim() !== '');
			search.classList.toggle('gbe-header__search--hide-placeholder', hide);
		}

		function nextPhrase() {
			if (document.activeElement === input || (input.value && input.value.trim() !== '')) {
				return;
			}
			overlay.classList.add('is-changing');
			window.setTimeout(function () {
				index = (index + 1) % phrases.length;
				setPhrase(phrases[index]);
				overlay.classList.remove('is-changing');
			}, fadeMs);
		}

		setPhrase(phrases[0]);
		input.setAttribute('placeholder', ' ');
		input.setAttribute('aria-label', staticPlaceholder);

		input.addEventListener('focus', function () {
			updateVisibility();
		});
		input.addEventListener('blur', function () {
			updateVisibility();
		});
		input.addEventListener('input', updateVisibility);

		timer = window.setInterval(nextPhrase, intervalMs);

		input.addEventListener('focus', function () {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		});

		input.addEventListener('blur', function () {
			if (!timer && !prefersReducedMotion()) {
				timer = window.setInterval(nextPhrase, intervalMs);
			}
			updateVisibility();
		});
	}

	function boot() {
		initSearchAnimation();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
