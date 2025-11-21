<?php

use Kirby\Cms\File;

/** @var File $image */

$image = $image ?? null;

/** @var $attr additional optional attributes */
$attr = $attr ?? [];

if (!($image instanceof File)) {
	if (option('debug') === true) {
		return 'Error in snippet `image`';
	}
	return;
}

$sizes = $sizes ?? '100vw';
$alt = $alt ?? $image->alt();
$srcset = (string)($srcset ?? 'default');
$width = option('thumbs.presets')[$srcset]['width'];
$height = option('thumbs.presets')[$srcset]['crop'] === true ? option('thumbs.presets')[$srcset]['height'] : round($width * $image->ratio());
?>
<img <?= attr(array_merge([
	'src' => $image->thumb($srcset)->url(),
	'srcset' => $image->srcset($srcset),
	'alt' => esc($alt, 'attr'),
	'width' => $width,
	'height' => $height,
	'sizes' => $sizes,
	'loading' => $loading ?? null,
	'fetchpriority' => $fetchpriority ?? null,
	'decoding' => $decoding ?? null,
], $attr)) ?>>
