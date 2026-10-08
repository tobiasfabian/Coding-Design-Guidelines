<?php

use Kirby\Cms\App;
use Kirby\Filesystem\F;

function hashedUrl(string $path)
{
	$file = kirby()->roots()->index() . DIRECTORY_SEPARATOR . $path;
	if (!option('tobiaswolf.hashed-url', true) || !file_exists($file)) {
		return url($path);
	}
	$asset = dirname($path) . '/';
	$asset .= F::name($path) . '.';
	$asset .= dechex(filemtime($file)) . '.';
	$asset .= F::extension($file);
	return url($asset);
}

App::plugin('tobiaswolf/hashed-url', []);
