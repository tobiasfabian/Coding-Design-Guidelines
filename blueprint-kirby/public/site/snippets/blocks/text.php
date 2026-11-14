<?php
/** @var \Kirby\Cms\Block $block */
?>
<?= snippet('m-text', ['text' => $block->text()->permalinksToUrls(), 'attr' => [
	'data-size' => 'large',
]]) ?>
