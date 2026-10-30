(function () {
	'use strict';

	var SECTIONS = [
		{
			root: '.gbe-home-map',
			items: '.gbe-home-map__copy > *, .gbe-home-map__visual',
			stagger: 0.1
		},
		{
			root: '.gbe-home-langues',
			items: '.gbe-home-section-head > *, .gbe-home-lang',
			stagger: 0.08
		},
		{
			root: '.gbe-home-culture-band',
			items: '.gbe-home-culture-band__inner > .gbe-home-section-kicker, .gbe-home-culture-band__title, .gbe-home-culture__item',
			stagger: 0.06
		},
		{
			root: '.gbe-home-biblio',
			items: '.gbe-home-biblio__copy > *, .gbe-home-biblio__card',
			stagger: 0.09
		},
		{
			root: '.gbe-home-research',
			items: '.gbe-home-research__head > *, .gbe-home-research__tile',
			stagger: 0.07
		},
		{
			root: '.gbe-home-actu',
			items: '.gbe-home-actu__col > .gbe-home-section-kicker, .gbe-home-actu__title, .gbe-home-actu__news-card, .gbe-home-actu__event',
			stagger: 0.08
		},
		{
			root: '.gbe-home-gallery',
			items: '.gbe-home-gallery__head > *, .gbe-home-gallery__tile',
			stagger: 0.05
		},
		{
			root: '.gbe-home-testimonials',
			items: '.gbe-home-section-kicker, .gbe-home-testimonials > h2, .gbe-home-testimonial',
			stagger: 0.1
		},
		{
			root: '.gbe-home-xotutu',
			items: '.gbe-home-xotutu__copy > *, .gbe-home-xotutu__genre, .gbe-home-xotutu__collection',
			stagger: 0.07
		},
		{
			root: '.gbe-home-rubriques',
			items: 'h2, .gbe-rubrique-card',
			stagger: 0.06
		},
		{
			root: '.gbe-home-valeurs',
			items: 'h2, .gbe-valeur-card',
			stagger: 0.08
		},
		{
			root: '.gbe-home-intro',
			items: 'p',
			stagger: 0.12
		},
		{
			root: '.gbe-home-vision-wrap',
			items: '.gbe-home-vision__title, .gbe-home-vision__block p, .gbe-home-vision__mission-list li, .gbe-devise',
			stagger: 0.06
		},
		{
			root: '.gbe-home-partners',
			items: 'h2, .gbe-partenaires-grid > *',
			stagger: 0.06
		},
		{
			root: '.gbe-home-cta',
			items: 'h2, .wp-block-button',
			stagger: 0.1
		},
	];

	function initHero(main, reduced) {
		var hero = main.querySelector('.gbe-home-hero');
		if (!hero) {
			return;
		}

		hero.classList.add('gbe-home-hero--motion');

		var parts = hero.querySelectorAll('.gbe-home-hero__inner > *');
		parts.forEach(function (el, index) {
			el.classList.add('gbe-home-reveal', 'gbe-home-reveal--hero');
			el.style.setProperty('--gbe-reveal-delay', reduced ? '0s' : index * 0.14 + 's');
		});

		if (reduced) {
			hero.classList.add('is-inview');
			parts.forEach(function (el) {
				el.classList.add('is-revealed');
			});
			return;
		}

		window.requestAnimationFrame(function () {
			hero.classList.add('is-inview');
			window.setTimeout(function () {
				parts.forEach(function (el) {
					el.classList.add('is-revealed');
				});
			}, 80);
		});
	}

	function tagSection(main, config, reduced) {
		var root = main.querySelector(config.root);
		if (!root) {
			return null;
		}

		root.classList.add('gbe-home-animate-section');

		var nodes = root.querySelectorAll(config.items);
		nodes.forEach(function (el, index) {
			el.classList.add('gbe-home-reveal');
			el.style.setProperty('--gbe-reveal-delay', reduced ? '0s' : index * config.stagger + 's');
		});

		if (reduced) {
			root.classList.add('is-inview');
			nodes.forEach(function (el) {
				el.classList.add('is-revealed');
			});
		}

		return reduced ? null : root;
	}

	function observeSections(sections) {
		if (!sections.length || !('IntersectionObserver' in window)) {
			sections.forEach(revealSection);
			return;
		}

		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}
					revealSection(entry.target);
					observer.unobserve(entry.target);
				});
			},
			{ threshold: 0.12, rootMargin: '0px 0px -6% 0px' }
		);

		sections.forEach(function (section) {
			observer.observe(section);
		});
	}

	function revealSection(section) {
		if (section.classList.contains('is-inview')) {
			return;
		}
		section.classList.add('is-inview');
		section.querySelectorAll('.gbe-home-reveal').forEach(function (el) {
			el.classList.add('is-revealed');
		});
	}

	function init() {
		var main = document.querySelector('.gbe-main--home');
		if (!main) {
			return;
		}

		var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		if (reduced) {
			main.classList.add('gbe-home-motion-reduced');
		}

		initHero(main, reduced);

		var toObserve = [];
		SECTIONS.forEach(function (config) {
			var section = tagSection(main, config, reduced);
			if (section) {
				toObserve.push(section);
			}
		});

		observeSections(toObserve);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
