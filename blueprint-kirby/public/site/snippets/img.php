<?php

use Kirby\Cms\File;

/** @var File */
$image ??= null;

/** @var array Additional optional attributes */
$attr ??= [];

if (!($image instanceof File)) {
	if (option('debug') === true) {
		return 'Error in snippet `image`';
	}
	return;
}

$sizes ??= '100vw'; /** Switch to auto, when loading is lazy and browser support is better. */
$alt ??= $image->alt();
$srcset = (string)($srcset ?? 'default');
$width = option('thumbs.presets')[$srcset]['width'];
$height = option('thumbs.presets')[$srcset]['crop'] === true ? option('thumbs.presets')[$srcset]['height'] : round($width * $image->ratio());
?>
<img <?= attr([
	'src' => $image->thumb($srcset)->url(),
	'srcset' => $image->srcset($srcset),
	'alt' => esc($alt, 'attr'),
	'width' => $width,
	'height' => $height,
	'sizes' => $sizes,
	'loading' => $loading ?? null,
	'fetchpriority' => $fetchpriority ?? null,
	'decoding' => $decoding ?? null,
	...$attr,
]) ?>>
