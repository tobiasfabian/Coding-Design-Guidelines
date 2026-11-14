<?php

use Kirby\Cms\Page;
use Kirby\Cms\Response;

/**
 * Renders a virtual page as content representation,
 * so the pages cache stores it as e.g. sitemap.xml
 */
$representation = function (string $slug, string $contentType, string $mime): Response {
	$page = new Page([
		'slug' => $slug,
		'template' => $slug,
	]);
	return new Response($page->render([], $contentType), $mime);
};

return [
	[
		'pattern' => 'site.webmanifest',
		'action' => fn () => $representation('site', 'webmanifest', 'application/manifest+json'),
	],
	[
		'pattern' => 'robots.txt',
		'action' => fn () => $representation('robots', 'txt', 'text/plain'),
	],
	[
		'pattern' => 'sitemap.xml',
		'language' => '*', // allow sitemap for each language
		'action' => fn () => $representation('sitemap', 'xml', 'application/xml'),
	],
];
