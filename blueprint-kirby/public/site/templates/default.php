<?php
/** @var \Kirby\Cms\Page $page */
?>
<?php snippet('head'); ?>
<body class="t-default">
	<?php snippet('o-header') ?>
	<main class="o-main">
		<?= $page->prose()->toBlocks() ?>
	</main>
	<?php snippet('o-footer') ?>
	<?php snippet('pre-foot') ?>
</body>
<?php snippet('foot'); ?>
