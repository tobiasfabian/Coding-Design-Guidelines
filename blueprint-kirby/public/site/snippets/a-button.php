<?php
$href ??= null;
$target ??= null;
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
