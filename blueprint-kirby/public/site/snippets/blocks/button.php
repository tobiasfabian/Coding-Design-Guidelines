<?php
/** @var \Kirby\Cms\Block $block */
$href = $block->link()->toUrl();
$target = $block->target()->toBool() ? '_blank' : null;

if (empty($href)) return;
?>
<a <?= attr([
	'class' => 'a-button',
	'href' => $href,
	'target' => $target,
]) ?>><?= $block->text() ?></a>
