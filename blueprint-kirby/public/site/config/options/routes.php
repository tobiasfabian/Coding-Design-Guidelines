<?php

return [
	[
		'pattern' => 'site.webmanifest',
		'action' => function() {
			$content = snippet('manifest', ['site' => site()], true);
			return new Kirby\Cms\Response($content, 'application/manifest+json');
		},
	],
	[
		'pattern' => 'robots.txt',
		'action' => function() {
			$content = snippet('robots', ['kirby' => kirby()], true);
			return new Kirby\Cms\Response($content, 'text/plain');
		},
	],
	[
		'pattern' => 'sitemap.xml',
		'language' => '*', // allow sitemap for each language
		'action'  => function() {
			$content = snippet('sitemap', ['site' => site()], true);
			return new Kirby\Cms\Response($content, 'application/xml');
		},
	],
];
