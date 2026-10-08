<?php

use Kirby\Cms\Response;

return [
	[
		'pattern' => 'site.webmanifest',
		'action' => function (): Response {
			$content = snippet('routes/manifest', ['site' => site()], true);
			return new Response($content, 'application/manifest+json');
		},
	],
	[
		'pattern' => 'robots.txt',
		'action' => function (): Response {
			$content = snippet('routes/robots', ['kirby' => kirby()], true);
			return new Response($content, 'text/plain');
		},
	],
	[
		'pattern' => 'sitemap.xml',
		'language' => '*', // allow sitemap for each language
		'action'  => function (): Response {
			$content = snippet('routes/sitemap', ['site' => site()], true);
			return new Response($content, 'application/xml');
		},
	],
];
