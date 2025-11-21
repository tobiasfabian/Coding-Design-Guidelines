<?php
use Kirby\Cms\Site;
use Kirby\Cms\Page;

/**
 * @var Site $site
 * @var Page $page
 */
?>
<!doctype html>
<html lang="<?= $kirby->language()?->code() ?? 'de' ?>">

<head>
	<meta charset="utf-8">

	<title><?= $page->isHomePage() ? $site->title()->esc('attr') : $page->title()->esc('attr') . ' – ' . $site->title()->esc('attr') ?></title>

	<link rel="icon" href="<?= url('favicon.ico') ?>" sizes="32x32">
	<link rel="icon" href="<?= hashedUrl('assets/images/icon.svg') ?>" type="image/svg+xml">
	<link rel="apple-touch-icon" href=<?= url('apple-touch-icon.png') ?>"><!-- 180×180 -->
	<link rel="manifest" href="<?= url('site.webmanifest') ?>">

	<meta name="robots" content="index, follow"><!-- Optional -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="description" content="<?= $page->metaDescription()->esc('attr') ?>">
	<meta property="og:title" content="<?= $page->title()->esc('attr') ?>">
	<meta property="og:site_name" content="<?= $site->title()->esc('attr') ?>">
	<?php if ($ogImage = $page->metaImage()->toFile()): ?>
		<meta property="og:image" content="<?= $ogImage->thumb('og-image') ?>">
		<meta property="og:image:alt" content="<?= $ogImage->alt()->esc('attr') ?>">
		<meta property="og:image:width" content="1200">
		<meta property="og:image:height" content="630">
	<?php endif ?>

	<link rel="canonical" href="<?= $page->url() ?>"><!-- Optional -->

	<link rel="stylesheet" href="<?= hashedUrl('assets/css/index.css') ?>">
	<script src="<?= hashedUrl('assets/js/index.js') ?>" defer></script><!-- Optional -->
</head>
