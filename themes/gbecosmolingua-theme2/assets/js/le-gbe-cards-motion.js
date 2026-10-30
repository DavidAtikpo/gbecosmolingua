(function () {
	'use strict';

	var bands = document.querySelectorAll('.gbe-le-gbe-rubriques .gbe-culture-band, .gbe-hub-rubriques .gbe-culture-band');
	if (!bands.length) {
		return;
	}

	if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		bands.forEach(function (band) {
			band.classList.add('gbe-is-visible');
		});
		return;
	}

	if (!('IntersectionObserver' in window)) {
		bands.forEach(function (band) {
			band.classList.add('gbe-is-visible');
		});
		return;
	}

	var observer = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('gbe-is-visible');
					observer.unobserve(entry.target);
				}
			});
		},
		{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
	);

	bands.forEach(function (band) {
		observer.observe(band);
	});
})();
