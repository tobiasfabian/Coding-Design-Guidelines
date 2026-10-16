# PHP in Kirby sites

Short examples of the patterns in SKILL.md. They show the shape, not every detail.

## Controllers

One controller per template, named like the template. Ask only for the arguments you use; Kirby injects them by name. Use the model class as the type of `$page`.

```php
<?php

return function (ProjectsPage $page, string|null $tag = null): array {
	$projects = $page->projects();

	if ($tag !== null) {
		$projects = $projects->filterBy('tags', $tag, ',');
	}

	$projects = $projects->paginate(12);

	return [
		'projects' => $projects,
		'pagination' => $projects->pagination(),
		'tag' => $tag,
	];
};
```

- Return a flat array of everything the template outputs. The template shouldn't need further queries.
- `$tag` comes from a route (see Routes and filter URLs); `get()` and `param()` work too.
- Pass request values into the template as they are. The template escapes them when it outputs them.
- No form handling or `go()` redirects for forms here; forms go through API routes (see below).

## Routes and filter URLs

Clean filter URLs (`/projects/tag/design`) come from a route that renders the page with data. The controller receives that data as an argument, as above.

```php
<?php

return [
	[
		'pattern' => 'projects/tag/(:alphanum)',
		'action' => function (string $tag) {
			return site()->projectsPage()?->render(['tag' => $tag]);
		},
	],
];
```

- Use the narrowest pattern (`(:alphanum)`, `(:num)`). `(:any)` also matches `projects.json`. Use `$this->next()` to fall through to the next route, and `go($url, 301)` for permanent redirects.
- Kirby doesn't cache a page rendered with data, and never caches requests with a query string or params. If filter pages should be in the static cache, clone the page with the filter value instead and include that value in `cacheId()` (as `ProjectsPage` in wagnerwagner.de does).

## JSON for the frontend

Data that JavaScript loads with GET (load more, filter results) is a content representation: `site/templates/<template>.json.php` plus a controller `site/controllers/<template>.json.php`. Kirby sets the content type, and staticache stores the result like a page (`/projects.json`) as long as the URL has no query string. API routes are for POST.

```php
<?php
/** @var \Kirby\Cms\Pages $projects */

echo json_encode($projects->values(fn (ProjectPage $project) => [
	'title' => $project->title()->value(),
	'url' => $project->url(),
]));
```

A JSON template is data, not markup, so you may write it.

## Models

`site/models/<template>.php`, class `<Template>Page extends Page`, no namespace.

```php
<?php

use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Kirby\Content\Field;

/**
 * @method Field client()
 * @method Field teaser()
 */
class ProjectPage extends Page
{
	/** @return ClientPage|null */
	public function clientPage(): Page|null
	{
		return $this->client()->toPage();
	}

	/** Used by the blueprint query `page.relatedProjects` */
	public function relatedProjects(): Pages
	{
		return $this->siblings(false)->listed()->filterBy('client', $this->client()->value());
	}

	/** Falls back to the meta description */
	public function teaser(): Field
	{
		return parent::teaser()->or($this->metaDescription());
	}
}
```

- Put a method in the model when more than one template, a blueprint query or another model needs it. Anything only one template needs goes in that template's controller.
- Computed values that templates treat like fields are returned as `new Field($this, 'name', $value)`.
- To add a fallback to a field, name the method like the field and call `parent::name()`, which returns the raw field. Templates keep calling `$page->teaser()`.
- Store expensive results in a private property, or in a Kirby cache that a hook flushes when content changes.
- Pages with request-dependent output: `public function isCacheable(VersionId|null $versionId = null): bool { return false; }`.

## Config and extensions

General extensions for the site live in `config.php` (Kirby ≥ 5.5). Large blocks go to `config/options/*.php`.

```php
<?php

return [
	'routes' => require __DIR__ . '/options/routes.php',
	'thumbs' => require __DIR__ . '/options/thumbs.php',
	'cache' => [
		'projects' => true,
	],
	'extensions' => [
		'siteMethods' => [
			'projectsPage' => fn (): ProjectsPage|null => page('page://…'),
		],
		'hooks' => [
			'page.*:after' => function () {
				kirby()->cache('projects')->flush();
			},
		],
	],
];
```

- Structural pages get a site method that looks them up by UUID. Add it to the stub file (see below).
- `env.php` holds secrets and is not committed. `config.<host>.php` holds what differs per host: `debug`, the page cache, test keys.
- Don't call `kirby()`, `site()` or `page()` at the top level of `config.php`; Kirby isn't ready at that point. Inside closures (hooks, routes, methods) they're fine. Setup that needs Kirby goes into the `'ready'` callback.

## IDE stubs

Every custom site, page, file or field method gets an `@method` line in a stub file. That way the IDE knows `$site->projectsPage()` or `$field->toIntlDate()`. The stub sits next to where the methods are registered: `site/config/` for the `'extensions'` in `config.php`, the plugin folder for a feature plugin. Kirby never loads these files; only the IDE reads them.

| Extension | File | Class |
|---|---|---|
| `siteMethods` | `site-methods.stub.php` | `Kirby\Cms\Site` |
| `pageMethods` | `page-methods.stub.php` | `Kirby\Cms\Page` |
| `fileMethods` | `file-methods.stub.php` | `Kirby\Cms\File` |
| `fieldMethods` | `field-methods.stub.php` | `Kirby\Content\Field` |

```php
<?php

namespace Kirby\Cms;

/**
 * @method \ProjectsPage|null projectsPage() The projects overview
 * @method \Kirby\Cms\Page|null contactPage() The contact page
 */
class Site extends \Kirby\Cms\Site {}
```

- Put all `@method` lines in one docblock. A second docblock replaces the first, and the IDE loses those methods.
- For field methods, leave out the first `$field` parameter. Kirby passes it in; callers write `$page->date()->toIntlDate('d. MMMM y')`.
- Keep stub files out of php-cs. The fixer shortens `extends \Kirby\Cms\Site` to `extends Site`, so the class extends itself. The `.php-cs-fixer.dist.php` of `blueprint-kirby` already excludes `*.stub.php` and checks only plugins registered as `site/*`; copy it into older projects.
- Page models are their own classes, so their content fields are declared on the model with `@method Field …` (see Models).

## Feature plugins

A feature with a clear boundary (contact form, newsletter, search, shop, ICS export …) gets its own plugin, even if no other site uses it:

```
site/plugins/contact/
├── index.php        App::plugin('site/contact', [...])
├── api/             one file per API route
├── src/             classes (namespace Site\Contact)
└── translations/
```

The plugin brings everything the feature needs: API routes, options, hooks, blueprints, translations. Its snippets, CSS and JS still belong to the user.

- **Options** get defaults in the plugin (`'options' => ['apiKey' => null]`) and are read with `option('site.contact.apiKey')`. Secrets are set in `env.php` as `'site.contact.apiKey' => '…'`.
- **Cache**: `'options' => ['cache' => true]` gives the plugin its own cache, `kirby()->cache('site.contact')`.
- **Classes** in `src/` are loaded with `load([...], __DIR__ . '/src')` in `index.php`.
- **Emails** use a preset (`'email' => ['presets' => [...]]`) with templates `site/templates/emails/<name>.html.php` and `<name>.text.php`. The SMTP transport and its credentials go in `env.php`.

## Forms

The page stays statically cached. JavaScript posts the form to an API route of the feature plugin, and the route answers with JSON.

```php
<?php

use Kirby\Toolkit\V;

return [
	'pattern' => 'contact',
	'method' => 'POST',
	'auth' => false,
	'action' => function () {
		$data = $this->requestBody();

		// spam protection: honeypot, minimum fill time, CSRF token fetched by JS

		$errors = V::invalid($data, [
			'email' => ['required', 'email'],
			'message' => ['required', 'maxLength' => 5000],
		]);

		if ($errors !== []) {
			return ['status' => 'error', 'code' => 400, 'details' => $errors];
		}

		// send mail, log …

		return ['status' => 'ok'];
	},
];
```

- Because the page is cached, a CSRF token can't be embedded in the page. JavaScript fetches it from a route of the plugin, which creates it with `csrf()`; the submit route checks it with `csrf($token)`.
- An error response keeps the shape `['status' => 'error', 'code' => 4xx, 'details' => …]`. Kirby uses `code` as the HTTP status.
- Escape stored visitor data wherever it's output again: confirmation pages, emails, the Panel.

## Security

- Set `content.salt` and `cookie.key` in `env.php` to long random strings. Kirby derives tokens (e.g. for draft previews) from the salt and signs cookies with the key; both default to guessable values.
- Never pass request data unchecked to `createChild()`, `update()` and the like. Validate first and take only the keys you expect.
- Wrap `$kirby->impersonate('kirby', fn () => …)` around exactly the one write that needs it, not around the whole route.
- Sanitize anything that becomes a path: slugs, file names, templates of virtual pages (`Str::slug()`, `F::safeName()`).

## Collections

Reusable page sets: `site/collections/<name>.php`.

```php
<?php

use Kirby\Cms\Pages;
use Kirby\Cms\Site;

return function (Site $site): Pages {
	return $site->projectsPage()?->children()->listed() ?? new Pages();
};
```
