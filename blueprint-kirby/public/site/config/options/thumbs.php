<?php

// Ratios available e.g. in image and gallery block
$crops = [
	'default' => null,
	'9/16' => 9/16,
	'10/16' => 10/16,
	'2/3' => 2/3,
	'4/5' => 4/5,
	'1/1' => 1/1,
	'5/4' => 5/4,
	'3/2' => 3/2,
	'16/10' => 16/10,
	'16/9' => 16/9,
];

$presets = [];
$srcsets = [];

foreach ($crops as $key => $value) {
	// Define presets
	$presets[$key] = [
		'width' => 2048,
		'height' => $value === null ? null : round(2048 / $value),
		'crop' => $value === null ? false : true,
		'quality' => 80,
	];

	// Define srcsets
	$srcsets[$key] = [
		// Moto G Power (Page Speed Test)
		'412w' => [
			'width' => 412,
			'height' => $value === null ? null : round(376 / $value),
			'crop' => $value === null ? false : true,
		],
		'824w' => [
			'width' => 824,
			'height' => $value === null ? null : round(824 / $value),
			'crop' => $value === null ? false : true,

		],
		'1024w' => [
			'width' => 1080,
			'height' => $value === null ? null : round(1080 / $value),
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
			'quality' => 70,

		],

	];
}

return [
	'quality' => 80,
	'interlace' => true,
	'presets' => $presets,
	'srcsets' => $srcsets,
];
