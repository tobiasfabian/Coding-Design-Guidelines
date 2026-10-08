<?php
/** @var \Kirby\Cms\Block $block */

$href = $block->link()->toUrl();
$target = $block->target()->toBool() ? '_blank' : null;
$attr ??= [];

snippet('a-button', [
	'href' => $href,
	'target' => $target,
	'text' => $block->text(),
	...$attr,
]);
