(function () {
	'use strict';

	function formatGrouped(n, useSpace) {
		var s = String(Math.round(n));
		if (!useSpace) {
			return s;
		}
		return s.replace(/\B(?=(\d{3})+(?!\d))/g, '\u00a0');
	}

	function easeOutCubic(t) {
		return 1 - Math.pow(1 - t, 3);
	}

	function renderStat(el, value) {
		var suffix = el.getAttribute('data-gbe-suffix') || '';
		var grouped = el.getAttribute('data-gbe-grouped') === '1';
		el.textContent = formatGrouped(value, grouped) + suffix;
	}

	function animateStat(el, duration) {
		var end = parseInt(el.getAttribute('data-gbe-stat'), 10);
		if (isNaN(end)) {
			var text = el.getAttribute('data-gbe-text');
			if (text) {
				el.textContent = text;
			}
			return;
		}

		var startTime = null;

		function frame(ts) {
			if (!startTime) {
				startTime = ts;
			}
			var progress = Math.min((ts - startTime) / duration, 1);
			var current = end * easeOutCubic(progress);
			renderStat(el, current);
			if (progress < 1) {
				requestAnimationFrame(frame);
			} else {
				renderStat(el, end);
			}
		}

		renderStat(el, 0);
		requestAnimationFrame(frame);
	}

	function initStatsSection(section, reduced) {
		if (!section || section.getAttribute('data-gbe-stats-init') === '1') {
			return;
		}

		var values = section.querySelectorAll('.gbe-home-stats__value[data-gbe-stat], .gbe-home-stats__value[data-gbe-text], .gbe-xotutu-stats__value[data-gbe-stat], .gbe-paremiologie-stats__value[data-gbe-stat], .gbe-linguistique-stats__value[data-gbe-stat]');
		if (!values.length) {
			return;
		}

		function play() {
			if (section.getAttribute('data-gbe-stats-init') === '1') {
				return;
			}
			section.setAttribute('data-gbe-stats-init', '1');
			section.classList.add('is-animated');

			values.forEach(function (el, index) {
				if (reduced) {
					var end = parseInt(el.getAttribute('data-gbe-stat'), 10);
					if (!isNaN(end)) {
						renderStat(el, end);
					} else if (el.getAttribute('data-gbe-text')) {
						el.textContent = el.getAttribute('data-gbe-text');
					}
					return;
				}

				window.setTimeout(function () {
					animateStat(el, 1500);
				}, index * 90);
			});
		}

		if (reduced) {
			play();
			return;
		}

		if ('IntersectionObserver' in window) {
			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							play();
							observer.disconnect();
						}
					});
				},
				{ threshold: 0.2, rootMargin: '0px 0px -5% 0px' }
			);
			observer.observe(section);
		} else {
			play();
		}
	}

	function init() {
		var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		document.querySelectorAll('.gbe-home-stats, .gbe-xotutu-stats, .gbe-paremiologie-stats, .gbe-linguistique-stats').forEach(function (section) {
			initStatsSection(section, reduced);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
