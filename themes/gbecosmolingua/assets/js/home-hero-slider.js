(function () {
	'use strict';

	var DURATION = 1800;
	var FRAGMENT_DURATION = 2600;
	var DEFAULT_INTERVAL = 7000;
	var FRAGMENT_COLS = 12;
	var FRAGMENT_ROWS = 7;

	function prefersReducedMotion() {
		return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function isFragmentEffect(effect) {
		return effect === 'fragment' || effect.indexOf('fragment-') === 0;
	}

	function getFragmentVariant(effect) {
		if (effect === 'fragment-cascade') {
			return 'cascade';
		}
		if (effect === 'fragment-shatter') {
			return 'shatter';
		}
		return 'scatter';
	}

	function clearEffectClasses(slide) {
		slide.classList.remove('is-entering', 'is-exiting');
		Array.prototype.slice.call(slide.classList).forEach(function (className) {
			if (className.indexOf('gbe-hero-effect-') === 0) {
				slide.classList.remove(className);
			}
		});
	}

	function getSlideImageUrl(slide) {
		var style = slide.getAttribute('style') || '';
		var match = style.match(/url\(\s*['"]?([^'")]+)['"]?\s*\)/);
		return match ? match[1] : '';
	}

	function removeFragmentLayers(slidesEl) {
		slidesEl.querySelectorAll('.gbe-home-hero__fragments').forEach(function (layer) {
			layer.remove();
		});
	}

	function configureFragmentTile(tile, row, col, variant, mode) {
		var centerCol = (FRAGMENT_COLS - 1) / 2;
		var centerRow = (FRAGMENT_ROWS - 1) / 2;
		var index = row * FRAGMENT_COLS + col;
		var delay;
		var offsetX = 0;
		var offsetY = 0;
		var rotate = 0;
		var scale = 1;

		if (variant === 'cascade') {
			delay = row * 70 + col * 24;
			if (mode === 'enter') {
				offsetY = -90 - row * 14;
				offsetX = (col % 2 === 0 ? -1 : 1) * 12;
				rotate = (col % 2 === 0 ? -1 : 1) * 8;
				scale = 0.65;
			} else {
				offsetY = 110 + row * 18;
				offsetX = (col % 3 - 1) * 18;
				rotate = (col % 2 === 0 ? 1 : -1) * 14;
				scale = 0.55;
			}
		} else if (variant === 'shatter') {
			var dx = col - centerCol;
			var dy = row - centerRow;
			var dist = Math.sqrt(dx * dx + dy * dy) || 1;
			delay = dist * 52 + Math.random() * 35;
			offsetX = (dx / dist) * (100 + Math.random() * 80);
			offsetY = (dy / dist) * (100 + Math.random() * 80);
			rotate = (dx * 6) + (dy * 4) + (Math.random() - 0.5) * 30;
			scale = mode === 'enter' ? 0.05 : 0.2;
		} else {
			delay = index * 16 + Math.floor(Math.random() * 80);
			offsetX = (Math.random() - 0.5) * 180;
			offsetY = (Math.random() - 0.5) * 140;
			rotate = (Math.random() - 0.5) * 55;
			scale = 0.15 + Math.random() * 0.35;
		}

		tile.style.setProperty('--gbe-frag-delay', delay + 'ms');
		tile.style.setProperty('--gbe-frag-x', offsetX + 'px');
		tile.style.setProperty('--gbe-frag-y', offsetY + 'px');
		tile.style.setProperty('--gbe-frag-rot', rotate + 'deg');
		tile.style.setProperty('--gbe-frag-scale', scale.toFixed(2));
	}

	function createFragmentLayer(imageUrl, mode, variant) {
		var layer = document.createElement('div');
		layer.className =
			'gbe-home-hero__fragments gbe-home-hero__fragments--' +
			mode +
			' gbe-home-hero__fragments--' +
			variant;
		layer.setAttribute('aria-hidden', 'true');

		for (var row = 0; row < FRAGMENT_ROWS; row++) {
			for (var col = 0; col < FRAGMENT_COLS; col++) {
				var tile = document.createElement('div');
				tile.className = 'gbe-home-hero__fragment';

				var xPos = FRAGMENT_COLS > 1 ? (col / (FRAGMENT_COLS - 1)) * 100 : 50;
				var yPos = FRAGMENT_ROWS > 1 ? (row / (FRAGMENT_ROWS - 1)) * 100 : 50;

				tile.style.backgroundImage = 'url("' + imageUrl + '")';
				tile.style.backgroundSize = FRAGMENT_COLS * 100 + '% ' + FRAGMENT_ROWS * 100 + '%';
				tile.style.backgroundPosition = xPos + '% ' + yPos + '%';

				configureFragmentTile(tile, row, col, variant, mode);
				layer.appendChild(tile);
			}
		}

		return layer;
	}

	function playFragmentLayer(layer) {
		window.requestAnimationFrame(function () {
			layer.classList.add('is-playing');
		});
	}

	function initHeroSlider(hero) {
		var slidesEl = hero.querySelector('.gbe-home-hero__slides');
		var slides = hero.querySelectorAll('.gbe-home-hero__slide');
		if (!slides.length || !slidesEl) {
			return;
		}

		if (slides.length === 1 || prefersReducedMotion()) {
			slides[0].classList.add('is-active');
			return;
		}

		var dots = hero.querySelectorAll('.gbe-home-hero__dot');
		var interval = parseInt(hero.getAttribute('data-gbe-hero-interval') || DEFAULT_INTERVAL, 10);
		var current = 0;
		var timer = null;
		var busy = false;

		function setDot(index) {
			dots.forEach(function (dot, i) {
				var active = i === index;
				dot.classList.toggle('is-active', active);
				dot.setAttribute('aria-selected', active ? 'true' : 'false');
			});
		}

		function finishTransition(prev, next, index, duration) {
			window.setTimeout(function () {
				prev.classList.remove('is-active');
				clearEffectClasses(prev);
				clearEffectClasses(next);
				removeFragmentLayers(slidesEl);
				hero.classList.remove('is-transitioning', 'is-fragment-transition');
				hero.removeAttribute('data-gbe-fragment-variant');
				slidesEl.classList.remove('is-fragment-active');
				current = index;
				setDot(current);
				busy = false;
			}, duration);
		}

		function runFragmentTransition(prev, next, index, variant) {
			var prevUrl = getSlideImageUrl(prev);
			var nextUrl = getSlideImageUrl(next);

			if (!prevUrl || !nextUrl) {
				busy = false;
				return;
			}

			hero.classList.add('is-fragment-transition');
			hero.setAttribute('data-gbe-fragment-variant', variant);
			slidesEl.classList.add('is-fragment-active');
			clearEffectClasses(prev);
			clearEffectClasses(next);

			prev.classList.add('is-exiting');
			next.classList.add('is-entering', 'is-active');

			removeFragmentLayers(slidesEl);

			var exitLayer = createFragmentLayer(prevUrl, 'exit', variant);
			var enterLayer = createFragmentLayer(nextUrl, 'enter', variant);

			slidesEl.appendChild(exitLayer);
			slidesEl.appendChild(enterLayer);

			playFragmentLayer(exitLayer);

			window.setTimeout(function () {
				playFragmentLayer(enterLayer);
				next.classList.remove('is-entering');
			}, variant === 'shatter' ? 380 : 520);

			finishTransition(prev, next, index, FRAGMENT_DURATION);
		}

		function goTo(index) {
			if (busy || index === current || !slides[index]) {
				return;
			}

			busy = true;
			var prev = slides[current];
			var next = slides[index];
			var effect = next.getAttribute('data-gbe-transition') || 'crossfade';

			hero.classList.add('is-transitioning');
			removeFragmentLayers(slidesEl);

			if (isFragmentEffect(effect)) {
				runFragmentTransition(prev, next, index, getFragmentVariant(effect));
				return;
			}

			clearEffectClasses(prev);
			clearEffectClasses(next);

			prev.classList.add('is-exiting', 'gbe-hero-effect-' + effect + '-exit');
			next.classList.add('is-entering', 'is-active', 'gbe-hero-effect-' + effect + '-enter');

			finishTransition(prev, next, index, DURATION);
		}

		function next() {
			goTo((current + 1) % slides.length);
		}

		function start() {
			stop();
			timer = window.setInterval(next, interval);
		}

		function stop() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		}

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var index = parseInt(dot.getAttribute('data-gbe-hero-index') || '0', 10);
				goTo(index);
				start();
			});
		});

		hero.addEventListener('mouseenter', stop);
		hero.addEventListener('mouseleave', start);
		hero.addEventListener('focusin', stop);
		hero.addEventListener('focusout', function (event) {
			if (!hero.contains(event.relatedTarget)) {
				start();
			}
		});

		document.addEventListener('visibilitychange', function () {
			if (document.hidden) {
				stop();
			} else {
				start();
			}
		});

		setDot(0);
		start();
	}

	function init() {
		document.querySelectorAll('.gbe-home-hero--slider').forEach(initHeroSlider);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
