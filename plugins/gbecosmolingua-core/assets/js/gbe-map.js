(function () {
	'use strict';

	if (typeof L === 'undefined' || typeof gbeMapData === 'undefined') {
		return;
	}

	var mapEl = document.getElementById('gbe-map');
	if (!mapEl) {
		return;
	}

	var data = gbeMapData;
	var map = L.map('gbe-map', {
		scrollWheelZoom: true,
		zoomControl: true
	}).setView([data.center.lat, data.center.lng], data.zoom);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	var typeColors = {
		langue: '#1a3c34',
		patrimoine: '#c45c26',
		migration: '#d4a853'
	};

	if (data.zones && data.zones.length) {
		data.zones.forEach(function (zone) {
			var bounds = zone.coords.map(function (c) {
				return [c[0], c[1]];
			});
			L.rectangle(bounds, {
				color: zone.color,
				weight: 1,
				fillColor: zone.color,
				fillOpacity: 0.08
			}).addTo(map).bindPopup('<strong>' + zone.name + '</strong>');
		});
	}

	if (data.markers && data.markers.length) {
		data.markers.forEach(function (marker) {
			var color = typeColors[marker.type] || '#1a3c34';
			var icon = L.divIcon({
				className: 'gbe-map-marker',
				html: '<span style="background:' + color + '"></span>',
				iconSize: [18, 18],
				iconAnchor: [9, 9]
			});

			L.marker([marker.lat, marker.lng], { icon: icon })
				.addTo(map)
				.bindPopup(
					'<strong>' + marker.title + '</strong><br>' +
					'<em>' + marker.country + '</em><br>' +
					marker.desc
				);
		});
	}

	setTimeout(function () {
		map.invalidateSize();
	}, 200);
})();
