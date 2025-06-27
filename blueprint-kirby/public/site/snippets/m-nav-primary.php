<?php
/** @var \Kirby\Cms\Site $site */
?>
<nav class="m-nav-primary" aria-label="Primary">
	<ul>
		<?php foreach ($site->pages()->listed() as $item): ?>
			<li>
				<a <?= attr([
					'href' => $item->url(),
					'class' => 'a-nav-item',
					'data-selected' => $item->isOpen() ? true : null,
					'aria-current' => $item->isActive() ? 'page' : null,
				]) ?> >
					<?=  $item->title() ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
</nav>
