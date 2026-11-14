<?php
/** @var Stringable */
$href ??= null;
/** @var Stringable */
$target ??= null;
/** @var Stringable */
$text ??= null;
$attr ??= [];

if (empty($href) || empty($text)) {
	return;
}
?>
<a <?= attr([
	'class' => 'a-button',
	'href' => $href,
	'target' => $target,
	...$attr,
]) ?>><?= $text ?></a>
