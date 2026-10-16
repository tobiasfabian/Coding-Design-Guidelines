---
name: kirby-launch-check
description: Go-live and audit checklist for Kirby CMS websites — config, secrets and repo hygiene, security, SEO/meta, accessibility, caching and privacy — with a report grouped as Fehler / Warnung / OK. Use this skill whenever a Kirby site is about to launch or be deployed, or when the user wants an existing Kirby site checked, audited or reviewed for problems ("Launch-Check", "ist die Seite bereit für live?", "prüf mal das Projekt", "Sicherheitscheck"), even if they don't say "checklist".
---

# Kirby launch check

Checks a Kirby site before launch, or audits an existing one. The checks come from mistakes that came up again and again in Tobias's sites. Conventions (where code goes, naming) are in the **kirby-guidelines** skill; this skill only checks.

## How to run it

1. **Find your way around.** Kirby version, docroot (`public/` or root), host configs (`site/config/config.*.php`), how the site is deployed (`scripts/rsync-excludes`, `.connect-to-server`, git hooks).
2. **Check the repository** against [references/checklist.md](references/checklist.md). Use `git ls-files` for "is it in git", and read the files themselves instead of guessing.
3. **Check the live site** if the user gives a URL (staging or production): only `GET`/`HEAD` requests with `curl`, as listed in the checklist. Never log in, never send forms.
4. **Report**, then stop. Don't fix anything until Tobias says so. After that, PHP and config fixes are yours; templates, snippets, CSS and JS stay suggestions unless he asks you to edit them.

Never put secret values in the report (salts, keys, passwords, tokens). Say "gesetzt", "fehlt" or "im Repo", nothing more.

Some things can't be checked from the repository, for example the `env.php` on the server or the server's PHP version. List them under **Nicht prüfbar** so they don't get forgotten.

## Report

Answer in German, in this shape:

```markdown
## Launch-Check: <Projekt> (<Datum>)

### Fehler
- `pfad/datei.php:12` – was falsch ist – warum es wichtig ist

### Warnung
- …

### OK
- Kurzliste dessen, was geprüft wurde und passt

### Nicht prüfbar
- …
```

- **Fehler**: security holes, things that break the site, or data protection problems.
- **Warnung**: things that should be fixed before launch but don't break anything.
- One line per finding, with `file:line` (or the URL for live checks).
