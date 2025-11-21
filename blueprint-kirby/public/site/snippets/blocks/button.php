<?php
$href = $block->link()->toUrl();

if (empty($href)) return;
?>
<a class="a-button" href="<?= $href ?>">
	<?= $block->text() ?>
</a>
