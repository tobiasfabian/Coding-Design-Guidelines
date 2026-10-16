---
name: kirby-new-site
description: Sets up a new Kirby website project from the starters in this repository (blueprint-kirby plus the develop/ frontend from blueprint) — copies them, replaces the placeholders, writes env.php with fresh secrets, creates the git repository with Kirby, staticache and content/ as submodules, and runs the first build. Use this skill whenever the user wants to start, create or set up a new Kirby site or project ("neues Projekt", "neue Website aufsetzen", "Kirby-Projekt für example.com anlegen"), even if they don't mention the starter.
---

# New Kirby site

Sets up a new project from `blueprint-kirby` and `blueprint` in this repository. For everything after the setup, follow the **kirby-guidelines** skill.

Every project is set up the same way:

- The project is a **git repository**.
- **Kirby** is a submodule (`public/kirby`), and so is staticache.
- **`content/`** is a submodule too: its own local repository without a remote.

## Ask first

- **Domain** (e.g. `example.com`) and **target folder** (usually `~/Projekte/<domain>`).
- **Languages**: one or several?
- **local-dev-server**? It comes from the private repo [tobiasfabian/local-dev-server](https://github.com/tobiasfabian/local-dev-server), so `npm install` needs SSH access to GitHub.

## Set up

Run the script from this skill's folder. It refuses a target folder that isn't empty.

```bash
scripts/new-site.sh ~/Projekte/example.com example.com --local-dev-server
```

What it does:

- Copies the committed state of `blueprint-kirby`, with a real copy of `develop/` from `blueprint` (the starter only has a symlink there).
- Leaves out `.htpasswd`, `.php-cs-fixer.cache` and Panel media, and adds the first two to `.gitignore`.
- Replaces `example.com` and `example.local`, renames the test config to `config.<name>.test.php`, and adds `config.localDevServer` to `package.json`.
- With `--local-dev-server`, it also adds the package and its npm scripts, plus an `.npmrc` with `allow-git=root`. Since npm 12, git dependencies are refused unless a project allows them.
- Writes `env.php` with random `content.salt` and `cookie.key`. Never print these values.
- Runs `git init`. Adds Kirby (latest stable tag) and staticache as shallow submodules, and makes `content/` its own repository, registered as a submodule with the local URL `./public/content`.
- Runs `npm install` and `npm run build`.

The script doesn't commit anything in the project. The one exception is the content repository: it needs a first commit to become a submodule. If that commit fails (commit signing without an agent, for example), the setup still finishes and prints what to do.

## Afterwards

- **Several languages**: add `'languages' => true` to `config.php` and a file per language in `site/languages/` (or create the languages in the Panel).
- **Check it renders**: start the local-dev-server, or run `php -S 127.0.0.1:8000 -t public public/kirby/router.php`, then request `/`, `/sitemap.xml` and `/robots.txt`. The user creates the first Panel account.
- **Hand over** the to-do list the script prints at the end (server paths, `.connect-to-server`, `env.php` on the server, license, fonts, logo).
- **Offer the first commit**, and make it only if the user agrees.
