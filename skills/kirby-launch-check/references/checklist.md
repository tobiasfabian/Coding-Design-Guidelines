# Checklist

Each line says what to check and roughly how. Skip what doesn't apply to the project (no forms, no tracking, single language …).

## Config

- `debug` is `false` in production. It's only `true` in `config.<host>.test.php` or the local `env.php`.
- The page cache is on in production and off in the local test config.
- A host config exists for every domain the site runs on (production, staging), and none of them enables `debug`.

## Secrets and repository

- `env.php` is in `.gitignore` and not tracked (`git ls-files`).
- `content.salt` and `cookie.key` are set to long random values in `env.php`. If only the server's `env.php` has them, list that under "Nicht prüfbar".
- Not in git, not in the docroot, and not deployed: `.htpasswd`, `DEBUG.php`, `INFO.php`, other one-off scripts, `site/accounts`, `site/sessions`, `site/cache`, `site/logs`, `site/config/.license`. Check `.gitignore` and the deploy excludes (e.g. `scripts/rsync-excludes`).
- No secrets in tracked files: API keys, tokens, passwords in `config.php`, blueprints or JS.

## Security

- Visitor input is escaped wherever it's output: `get()`, `param()`, `$_GET`, request data, and stored form or order data in templates, snippets, emails and the Panel (`panelInfo`, `info` texts).
- Every public POST endpoint (API routes with `'auth' => false`) has spam protection and a CSRF token, and validates its input before writing anything.
- `.htaccess` blocks `content/`, `site/`, `kirby/` and dotfiles (the starter's rules do).
- Third-party plugins and Kirby are reasonably current (`kirby/composer.json`; known security releases).

## SEO and meta

- An error page exists and answers with status 404.
- `sitemap.xml`, `robots.txt` and `site.webmanifest` respond. The sitemap leaves out `error` and other templates that shouldn't be indexed.
- `<title>`, meta description and canonical are set on every page type.
- OG tags are separate `<meta>` tags. `og:image:width`/`height` match the preset that's actually used.
- `<html lang>` matches the page language (on multilingual sites, per language).
- Staging/preview hosts are protected (basic auth) or `noindex`.

## Content and accessibility

- Images have alt texts: the image snippet passes `alt`, and the file blueprints have an `alt` field.
- Navigations have an `aria-label`, and the current page gets `aria-current="page"`.
- Every page type has exactly one `<h1>`.
- Email addresses and phone numbers work as links (`mailto:`, `tel:`).

## Caching

- The staticache rules are in `.htaccess` above the Kirby rewrite rules, and the cache folder is writable.
- Pages whose output depends on the request (session, cart, login, query string) opt out with `isCacheable()` or load that part via API.
- Hashed asset URLs (`hashedUrl()`) and the matching `.htaccess` rule are in place.

## Privacy

- Tracking only runs after consent. Scripts waiting for consent have exactly one `type="text/plain"`; a second `type` attribute wins over it.
- Embeds (YouTube, Vimeo, maps, iframes) load only after a click or consent (`data-src`, youtube-nocookie).
- Imprint and privacy pages exist and are linked from every page (usually the footer).
- No external fonts or scripts are loaded without need (Google Fonts, CDNs).

## Live checks (only with a URL from the user)

Use only `curl -sI` / `curl -s` (GET or HEAD):

- `/` answers 200 over HTTPS, and `http://` and `www.` redirect with 301 to the canonical host.
- `/gibt-es-nicht` answers 404 and shows the error page, not a Whoops/debug page.
- `/.htpasswd`, `/.git/HEAD`, `/site/config/env.php`, `/content/`, `/DEBUG.php`, `/INFO.php` don't answer 200.
- `/sitemap.xml`, `/robots.txt` and `/site.webmanifest` answer 200 with the right content type.
- The second request to a page comes from the static cache: the HTML ends with `<!-- static … -->`, unless the comment is turned off.
- No headers reveal versions (`X-Powered-By` with the PHP version).
- If the project has `unlighthouse`, run it, or suggest Tobias run it, and add the scores to the report.
