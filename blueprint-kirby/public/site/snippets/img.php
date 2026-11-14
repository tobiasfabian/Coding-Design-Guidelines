<?php

use Kirby\Cms\File;

/** @var File */
$image ??= null;

/** @var array Additional optional attributes */
$attr ??= [];

$sizes ??= '100vw'; /** Switch to auto, when loading is lazy and browser support is better. */

/** @var \Stringable */
$alt ??= $image->alt();

$srcset = (string)($srcset ?? 'default');

if (!($image instanceof File)) {
	if (option('debug') === true) {
		return 'Error in snippet `image`';
	}
	return;
}

$width = option('thumbs.presets')[$srcset]['width'];
$height = option('thumbs.presets')[$srcset]['crop'] === true ? option('thumbs.presets')[$srcset]['height'] : round($width * $image->ratio());
?>
<img <?= attr([
	'src' => $image->thumb($srcset)->url(),
	'srcset' => $image->srcset($srcset),
	'alt' => $alt,
	'width' => $width,
	'height' => $height,
	'sizes' => $sizes,
	...$attr,
]) ?>>
