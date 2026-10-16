<?php
/** @var \Kirby\Cms\Site $site */
/** @var \Kirby\Cms\Pages */
$legalPages = $site->legalPages()->toPages();
?>
<footer class="o-footer">
	<?php if ($legalPages->count() > 0): ?>
		<?php snippet('m-nav-footer', [
			'legalPages' => $legalPages,
		]) ?>
	<?php endif ?>
</footer>
