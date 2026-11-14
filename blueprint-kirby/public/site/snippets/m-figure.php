<?php
/** @var \Kirby\Cms\File */
$media ??= null;
/** @var \Kirby\Content\Field|Stringable */
$alt ??= null;
/** @var \Kirby\Content\Field|Stringable|float */
$ratio ??= null;
/** @var \Kirby\Content\Field|Stringable */
$caption ??= null;

if ($media === null) {
	return;
}
?>
<figure class="m-figure">
	<?php if ($media->type() === 'image'): ?>
		<?= snippet('img', ['image' => $media, 'alt' => $alt, 'srcset' => $ratio]) ?>
	<?php endif ?>
	<?php if ($caption !== null): ?>
		<figcaption>
			<?= $caption ?>
		</figcaption>
	<?php endif ?>
</figure>
