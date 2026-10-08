<?php
/** @var Kirby\Cms\Site $site */

$pages = $site->index();
$ignoreTemplates = option('sitemap.ignoreTemplates', []);
?>
<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($pages as $page): ?>
		<?php /** @var Kirby\Cms\Page $page */ ?>
		<?php if (in_array($page->intendedTemplate()->name(), $ignoreTemplates)) continue ?>
		<url>
			<loc><?= html($page->url()) ?></loc>
			<lastmod><?= $page->modified('c', 'date') ?></lastmod>
		</url>
	<?php endforeach ?>
</urlset>
