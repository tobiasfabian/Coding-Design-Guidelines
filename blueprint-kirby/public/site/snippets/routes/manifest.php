<?php
/** @var Kirby\Cms\Site $site */

$json = [
	'name' => $site->title()->toString(),
	'start_url' => $site->url(),
	'display' => 'minimal-ui',
];

$icon = asset('assets/images/icon.png');

if ($icon) {
	$json['icons'] = [
		[
			'src' => $icon->crop(192)->url(),
			'type' => 'image/png',
			'sizes' => '192x192',
		],
		[
			'src' => $icon->crop(512)->url(),
			'type' => 'image/png',
			'sizes' => '512x512',
		],
	];
}

echo json_encode($json, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
