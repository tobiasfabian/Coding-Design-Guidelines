<?php
/** @var \Kirby\Cms\Site $site */
/** @var \Kirby\Cms\Pages $legalPages */
$legalPages = $site->legalPages()->toPages();
?>
<footer class="o-footer">
	<?php if ($legalPages->count() > 0): ?>
		<?php snippet('m-nav-primary', [
			'legalPages' => $legalPages,
		]) ?>
	<?php endif ?>
</footer>
