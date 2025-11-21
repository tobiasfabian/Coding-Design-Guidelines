<?php

return [
	// Kirby options
	'locale' => 'de_DE.utf-8',
	'slugs' => 'de',
	'routes' => require __DIR__ . '/options/routes.php',
	'thumbs' => require __DIR__ . '/options/thumbs.php',
	'updates' => [
		'kirby' => 'security',
		'plugins' => [
			'tobiaswolf/hashed-url' => false,
		],
	],

	// Custom options
	'sitemap.ignoreTemplates' => ['error'],
];
