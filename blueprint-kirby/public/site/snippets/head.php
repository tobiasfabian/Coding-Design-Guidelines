<?php
/**
 * @var Kirby\Cms\Site $site
 * @var Kirby\Cms\Page $page
 * @var Kirby\Cms\App $kirby
 */
?>
<!doctype html>
<html lang="<?= $kirby->language()?->code() ?? 'de' ?>">

<head>
	<meta charset="utf-8">

	<title><?= $page->isHomePage() ? $site->title()->esc('attr') : $page->title()->esc('attr') . ' – ' . $site->title()->esc('attr') ?></title>

	<meta name="viewport" content="width=device-width">
	<meta name="text-scale" content="scale">
	<meta name="description" content="<?= $page->metaDescription()->esc('attr') ?>">
	<meta name="robots" content="index, follow, max-image-preview:large"><!-- Optional -->

	<link rel="stylesheet" href="<?= hashedUrl('assets/css/index.css') ?>">
	<link rel="icon" href="<?= url('favicon.ico') ?>" sizes="32x32">
	<link rel="icon" href="<?= hashedUrl('assets/images/icon.svg') ?>" type="image/svg+xml">
	<link rel="apple-touch-icon" href="<?= url('apple-touch-icon.png') ?>" sizes="180x180">
	<link rel="manifest" href="<?= url('site.webmanifest') ?>">
	<link rel="canonical" href="<?= $page->url() ?>">

	<script src="<?= hashedUrl('assets/js/index.js') ?>" type="module"></script><!-- Optional -->

	<meta property="og:title" content="<?= $page->title()->esc('attr') ?>">
	<meta property="og:site_name" content="<?= $site->title()->esc('attr') ?>">
	<?php if ($ogImage = $page->metaImage()->toFile()): ?>
		<meta property="og:image" content="<?= $ogImage->thumb('og-image')->url() ?>">
		<meta property="og:image:alt" content="<?= $ogImage->alt()->esc('attr') ?>">
		<meta property="og:image:width" content="1200">
		<meta property="og:image:height" content="630">
	<?php endif ?>
</head>
