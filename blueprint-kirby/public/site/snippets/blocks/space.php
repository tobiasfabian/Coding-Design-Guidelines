<?php
/** @var \Kirby\Cms\Block $block */
$size = $block->size()->value();
?>
<div class="a-space" <?= attr([
	'data-size' => $size === 'medium' ? null : $size,
]) ?>></div>
