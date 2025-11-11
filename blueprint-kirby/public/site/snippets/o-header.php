<?php
/** @var \Kirby\Cms\Site $site */
?>
<header class="o-header">
	<div class="o-header__logo">
		<a href="<?= $site->url() ?>">
			<img src="<?= url('assets/images/logo.svg') ?>" alt="<?= $site->title() ?> Logo" width="…" height="…">
		</a>
	</div>

	<div class="o-header__nav">
		<?php snippet('m-nav-primary') ?>
	</div>
</header>

