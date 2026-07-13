<?php
/**
 * Map data for the Gbe continuum interactive map.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns map configuration: center, zoom, markers, zones.
 *
 * @return array<string, mixed>
 */
function gbe_get_map_data() {
	return array(
		'center'  => array( 'lat' => 7.2, 'lng' => 1.5 ),
		'zoom'    => 6,
		'markers' => array(
			array(
				'lat'     => 6.13,
				'lng'     => 1.22,
				'title'   => 'Lomé — Éwé, Gen (Mina)',
				'type'    => 'langue',
				'country' => 'Togo',
				'desc'    => 'Zone principale des variétés éwé et gen au sud-est du Togo.',
			),
			array(
				'lat'     => 8.0,
				'lng'     => 1.17,
				'title'   => 'Notsé — Mémoire collective gbe',
				'type'    => 'patrimoine',
				'country' => 'Togo',
				'desc'    => 'Centre symbolique des récits fondateurs et traditions migratoires gbe.',
			),
			array(
				'lat'     => 6.37,
				'lng'     => 2.43,
				'title'   => 'Porto-Novo / Cotonou — Fon, Gun',
				'type'    => 'langue',
				'country' => 'Bénin',
				'desc'    => 'Aire fon et gun, royaumes précoloniaux et patrimoine vodun.',
			),
			array(
				'lat'     => 6.82,
				'lng'     => 1.67,
				'title'   => 'Abomey — Patrimoine royal fon',
				'type'    => 'patrimoine',
				'country' => 'Bénin',
				'desc'    => 'Ancienne capitale du royaume du Danxomè, centre patrimonial majeur.',
			),
			array(
				'lat'     => 6.45,
				'lng'     => 1.88,
				'title'   => 'Aja — Variété aja',
				'type'    => 'langue',
				'country' => 'Bénin',
				'desc'    => 'Zone de la variété aja à la frontière Togo-Bénin.',
			),
			array(
				'lat'     => 6.1,
				'lng'     => 0.82,
				'title'   => 'Accra — Éwé (Ghana)',
				'type'    => 'langue',
				'country' => 'Ghana',
				'desc'    => 'Communautés éwé dans la région orientale et le sud-est du Ghana.',
			),
			array(
				'lat'     => 6.6,
				'lng'     => 0.47,
				'title'   => 'Ho — Éwé',
				'type'    => 'langue',
				'country' => 'Ghana',
				'desc'    => 'Capitale de la région Volta, forte présence éwé.',
			),
			array(
				'lat'     => 6.45,
				'lng'     => 3.39,
				'title'   => 'Lagos / Badagry — Gun, Phla-Phera',
				'type'    => 'langue',
				'country' => 'Nigeria',
				'desc'    => 'Zone côtière nigériane du continuum gbe occidental.',
			),
			array(
				'lat'     => 6.35,
				'lng'     => 2.88,
				'title'   => 'Ouidah — Route des esclaves',
				'type'    => 'migration',
				'country' => 'Bénin',
				'desc'    => 'Port historique, échanges culturels et routes migratoires transatlantiques.',
			),
		),
		'zones'   => array(
			array(
				'name'    => 'Continuum gbe — Togo',
				'color'   => '#1f5b2a',
				'coords'  => array(
					array( 6.0, 0.6 ),
					array( 6.0, 1.8 ),
					array( 11.0, 1.8 ),
					array( 11.0, 0.6 ),
				),
			),
			array(
				'name'    => 'Continuum gbe — Bénin',
				'color'   => '#8a4a12',
				'coords'  => array(
					array( 6.0, 1.8 ),
					array( 6.0, 3.9 ),
					array( 12.0, 3.9 ),
					array( 12.0, 1.8 ),
				),
			),
			array(
				'name'    => 'Continuum gbe — Ghana (Volta)',
				'color'   => '#b87913',
				'coords'  => array(
					array( 5.5, -0.2 ),
					array( 5.5, 1.2 ),
					array( 8.5, 1.2 ),
					array( 8.5, -0.2 ),
				),
			),
		),
	);
}
