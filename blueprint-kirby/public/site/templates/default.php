<?php
/** @var \Kirby\Cms\Page $page */
?>
<?php snippet('head'); ?>
<body class="t-default">
	<?php snippet('o-header') ?>
	<main>
		<h1><?= $page->title() ?></h1>
	</main>
	<?php snippet('o-footer') ?>
	<?php snippet('pre-foot') ?>
</body>
<?php snippet('foot'); ?>
