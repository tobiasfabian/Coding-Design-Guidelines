<?php
/** @var \Kirby\Cms\Block $block */

$image = $block->image()->toFile();
if ($image === null) {
	return;
}
?>
<?php snippet('m-figure', [
	'media' => $image,
	'alt' => $block->caption(),
	'ratio' => $block->ratio(),
	'caption' => $block->caption(),
]) ?>
