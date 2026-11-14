<?php

return [
	// Kirby options
	'locale' => 'de_DE.utf-8',
	'slugs' => 'de',
	'routes' => require __DIR__ . '/options/routes.php',
	'thumbs' => require __DIR__ . '/options/thumbs.php',
	'extensions' => [
		'templates' => [
			'robots' => __DIR__ . '/../templates/robots.txt.php',
			'site' => __DIR__ . '/../templates/site.webmanifest.php',
			'sitemap' => __DIR__ . '/../templates/sitemap.xml.php',
		],
	],
	'cache' => [
		'pages' => [
			'active' => true,
			'type' => 'static',
		],
	],
	'updates' => [
		'kirby' => 'security',
		'plugins' => [
			'tobiaswolf/hashed-url' => false,
		],
	],
	'panel' => [
		'css' => 'assets/css/panel.css',
	],

	// Custom options
	'sitemap.ignoreTemplates' => ['error'],
];
