(function () {
	'use strict';

	var hero = document.querySelector('.gbe-le-gbe-hero--carousel');
	if (!hero) {
		return;
	}

	var bgSlides = hero.querySelectorAll('.gbe-le-gbe-hero__slide');
	var textSlides = hero.querySelectorAll('.gbe-le-gbe-hero__text-slide');
	var dots = hero.querySelectorAll('.gbe-le-gbe-hero__dot');
	var interval = parseInt(hero.getAttribute('data-interval') || '12000', 10);
	var index = 0;
	var timer = null;

	function setSlide(i) {
		if (!bgSlides.length) {
			return;
		}
		index = (i + bgSlides.length) % bgSlides.length;

		bgSlides.forEach(function (el, n) {
			el.classList.toggle('is-active', n === index);
		});
		textSlides.forEach(function (el, n) {
			el.classList.toggle('is-active', n === index);
		});
		dots.forEach(function (el, n) {
			el.classList.toggle('is-active', n === index);
		});

		var activeBg = bgSlides[index];
		if (activeBg && activeBg.classList.contains('gbe-le-gbe-hero__slide--overlay-light')) {
			hero.classList.add('gbe-le-gbe-hero--overlay-light');
		} else if (activeBg && activeBg.classList.contains('gbe-le-gbe-hero__slide--overlay-dark')) {
			hero.classList.remove('gbe-le-gbe-hero--overlay-light');
		}
	}

	function next() {
		setSlide(index + 1);
	}

	function start() {
		stop();
		if (bgSlides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			timer = window.setInterval(next, interval);
		}
	}

	function stop() {
		if (timer) {
			window.clearInterval(timer);
			timer = null;
		}
	}

	dots.forEach(function (dot, i) {
		dot.addEventListener('click', function () {
			setSlide(i);
			start();
		});
	});

	hero.addEventListener('mouseenter', stop);
	hero.addEventListener('mouseleave', start);

	setSlide(0);
	start();
})();
