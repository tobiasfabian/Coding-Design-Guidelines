<?php

/**
 * Ratios available e.g. in image and gallery block
 * @see /public/site/blueprints/fields/ratio.yml
 */
$crops = [
	'default' => null,
	'16/9' => 16 / 9,
	'16/10' => 16 / 10,
	'3/2' => 3 / 2,
	'5/4' => 5 / 4,
	'1/1' => 1 / 1,
	'4/5' => 4 / 5,
	'2/3' => 2 / 3,
	'10/16' => 10 / 16,
	'9/16' => 9 / 16,
];

$presets = [];
$srcsets = [];
$quality2x = 70;

foreach ($crops as $key => $value) {
	// Define presets
	$presets[$key] = [
		'width' => 2048,
		'height' => $value === null ? null : round(2048 / $value),
		'crop' => $value === null ? false : true,
		'quality' => $quality2x,
	];

	// Define srcsets
	$srcsets[$key] = [
		// Moto G Power (Page Speed Test)
		'412w' => [
			'width' => 412,
			'height' => $value === null ? null : round(412 / $value),
			'crop' => $value === null ? false : true,
		],
		'824w' => [
			'width' => 824,
			'height' => $value === null ? null : round(824 / $value),
			'crop' => $value === null ? false : true,
		],
		'1024w' => [
			'width' => 1024,
			'height' => $value === null ? null : round(1024 / $value),
			'crop' => $value === null ? false : true,
		],
		'1236w' => [
			'width' => 1236,
			'height' => $value === null ? null : round(1236 / $value),
			'crop' => $value === null ? false : true,
		],
		'1440w' => [
			'width' => 1440,
			'height' => $value === null ? null : round(1440 / $value),
			'crop' => $value === null ? false : true,
		],
		'2048w' => [
			'width' => 2048,
			'height' => $value === null ? null : round(2048 / $value),
			'crop' => $value === null ? false : true,
			'quality' => $quality2x,
		],
	];
}

return [
	'quality' => 80,
	'interlace' => true,
	'presets' => [
		'og-image' => [
			'width' => 1200,
			'height' => 630,
			'crop' => true,
		],
		...$presets,
	],
	'srcsets' => [
		...$srcsets,
	],
];
