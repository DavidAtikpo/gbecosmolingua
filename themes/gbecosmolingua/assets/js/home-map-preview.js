(function () {
	'use strict';

	var el = document.getElementById('gbe-home-map-preview');
	if (!el || typeof L === 'undefined') {
		return;
	}

	var map = L.map(el, {
		scrollWheelZoom: false,
		dragging: false,
		zoomControl: false,
		doubleClickZoom: false,
		touchZoom: false,
		boxZoom: false,
		keyboard: false,
		attributionControl: true,
	});

	map.setView([8.2, 2.8], 6);

	L.tileLayer(
		'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
		{
			maxZoom: 18,
			attribution:
				'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics, and the GIS User Community',
		}
	).addTo(map);

	L.tileLayer(
		'https://services.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}',
		{
			maxZoom: 18,
			opacity: 0.55,
		}
	).addTo(map);

	setTimeout(function () {
		map.invalidateSize();
	}, 250);

	window.addEventListener('load', function () {
		map.invalidateSize();
	});
})();
