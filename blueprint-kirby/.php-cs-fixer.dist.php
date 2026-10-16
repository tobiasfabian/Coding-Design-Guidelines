<?php

// Only own plugins are checked: those registered as `site/*`.
// Third-party plugins are left as they are.
$ownPlugins = array_filter(
	glob(__DIR__ . '/public/site/plugins/*', GLOB_ONLYDIR) ?: [],
	fn (string $dir): bool => is_file($dir . '/index.php') && preg_match(
		'/plugin\(\s*(name:\s*)?[\'"](site)\//',
		file_get_contents($dir . '/index.php')
	) === 1
);

return Kirby\PhpCs\Config::create()->setFinder(
	PhpCsFixer\Finder::create()
		->in([__DIR__ . '/public/site', ...$ownPlugins])
		->exclude(['dependencies', 'plugins', 'vendor'])
		// php-cs would turn `extends \Kirby\Cms\Site` into `extends Site`
		->notName('*.stub.php')
);
