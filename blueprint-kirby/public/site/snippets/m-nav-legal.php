<?php
/** @var \Kirby\Cms\Site $site */
$legalPages = $legalPages ?? [];
?>
<nav class="m-nav-legal" aria-label="Legal">
	<ul>
		<?php foreach ($legalPages as $item): ?>
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
