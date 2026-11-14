<?php
/** @var \Kirby\Content\Field|Stringable */
$text ??= null;
$attr ??= [];

if (empty($text)) {
	return;
}
?>
<div class="m-text" <?= attr([$attr]) ?>><?= $text ?></div>
