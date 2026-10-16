---
name: kirby-guidelines
description: Tobias Wolf's conventions for Kirby CMS websites — where PHP logic belongs (controllers, models, config extensions, site/<name> plugins), Atomic Design and BEM naming, data-attribute modifiers, and the getkirby/php-cs style. Use this skill whenever you work in a Kirby project (a repo with site/templates, site/blueprints or a kirby/ folder): writing or changing controllers, models, collections, config, hooks, routes, API routes or plugins, reviewing code, or giving feedback on templates, snippets, blueprints, CSS or JS. Also use it when starting a new site from the blueprint-kirby starter, even if the user doesn't mention conventions.
---

# Kirby guidelines

These conventions come from Tobias's Kirby sites. They say *where things go and how they are named*. Formatting is left to [getkirby/php-cs](https://github.com/getkirby/php-cs). If a project deviates on purpose, follow the project and mention the deviation.

## Roles

- **You write PHP**, mainly in `site/controllers` and `site/models`. Collections, config, hooks, routes and plugins when the task needs them.
- **Tobias writes the frontend**: templates, snippets, HTML, CSS, JS. Don't edit these files unless he asks. Support him instead: list the variables a controller provides, point out mistakes, suggest smart additions (a short code example in the chat is welcome).
- **Blueprints**: only when the task needs new fields. Say which fields you added.
- **Never touch** `kirby/`, `content/`, third-party plugins in `site/plugins/` or compiled assets (`public/assets/`).

Answer in the user's language (usually German).

## Build mode

1. **Look first.** Kirby version (`kirby/composer.json`), `site/config/config.php`, existing models and controllers, and the blueprint of the template you work on. Reuse what's there.
2. **Place the code** according to the table below.
3. **Write it.** Details and examples: [references/php.md](references/php.md).
4. **Check it.** `php -l` on changed files. Run `composer fix` if the project has that script. Render the page if a dev server is running.
5. **Hand over.** Say what changed, and list the variables the template now gets (name, type, meaning) so Tobias can write the markup.

## Review mode

- Check PHP against this file and [references/php.md](references/php.md), and the frontend against [references/frontend.md](references/frontend.md).
- Report first, don't fix. Group findings as **Fehler** (bugs, security), **Abweichung** (breaks a convention) and **Vorschlag** (useful additions). One line each, with `file:line`.
- Once Tobias agrees, you may apply PHP fixes. Frontend fixes stay suggestions unless he asks you to edit.

## Where things go

| What | Where |
|---|---|
| Everything one template needs: queries, filters, pagination, request params, prepared values | controller `site/controllers/<template>.php` |
| Data every template needs | `site/controllers/site.php` (Kirby merges it into every controller) |
| Reusable page logic: relations, computed fields, field fallbacks, methods for blueprint queries, `isCacheable()` | page model `site/models/<template>.php` |
| Page sets used in several places | `site/collections/<name>.php` |
| Clean filter URLs (`/projects/tag/design`) | a route that renders the page with data; the controller takes it as an argument |
| Data JavaScript loads with GET | content representation `<template>.json.php` (template + controller) |
| General extensions for this site: site, page and field methods, block models, hooks, routes | `site/config/config.php`, under `'extensions'` (Kirby ≥ 5.5). Move large parts to `site/config/options/*.php` |
| A clearly bounded feature (form, search, newsletter, shop, export …), even if only this site uses it | its own plugin `site/plugins/<name>/`, registered as `App::plugin('site/<name>', …)` |
| Secrets | `site/config/env.php` (gitignored) |
| Host-specific settings (debug, cache off) | `site/config/config.<host>.php` |

Templates output, they don't compute. If a template needs more than a loop or an `if`, the controller should prepare the data.

## Principles

- **Style**: getkirby/php-cs. Run `composer fix` instead of formatting by hand.
- **No `declare(strict_types)` and no namespaces in `site/`**. Models are global classes that Kirby loads by file name. Plugin classes may use the namespace `Site\<Name>`.
- **Type everything**: parameters and return types. Model the content fields with `@method Field fieldName()` on the class.
- **Kirby often returns `null`.** `toFile()`, `toPage()`, `page()`, `first()` and `findBy()` can all be empty. Handle it with `?->`, an early return or a nullable return type. This was the most common bug in the existing sites.
- **Compare explicitly**, as Kirby core does: `=== true`, `=== null`, `->isNotEmpty()`.
- **Escape what visitors send**: `get()`, `param()`, request data, and form or order data stored in content. Content from editors in the Panel may be output raw.
- **Structural pages** (overview pages, settings pages) are reached by UUID through site methods, e.g. `$site->projectsPage()`, never by slug.
- **Stubs for the IDE**: every custom site, page, file or field method gets an `@method` line in a `*-methods.stub.php` file next to where it's registered.
- **Static page cache** (staticache) is on. A page whose output depends on the request (session, query string, login) either opts out with `isCacheable()` in its model or loads the dynamic part through an API route.
- **Forms** post to an API route of a feature plugin and get JSON back. JavaScript sends them; there's no POST handling in controllers.
- **Security basics**: `content.salt` and `cookie.key` in `env.php`; validate visitor data before it's written to content.
- **Names**: kebab-case files (templates, snippets, blueprints, collections). Models are named `<Template>Page`. Methods and content fields are camelCase. Components use Atomic Design prefixes (`a-`, `m-`, `o-`, `t-`), with the same name for snippet, CSS file, CSS class and JS file.
- **Language**: comments in English, and only where the *why* isn't obvious. Panel labels and UI text in German, or `t()` keys on multilingual sites.

New sites start from `blueprint-kirby` in [Coding-Design-Guidelines](https://github.com/tobiasfabian/Coding-Design-Guidelines). The CSS, JS and HTML guides live there too.
