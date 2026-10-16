# example.com

Kirby site, built from Tobias Wolf's `blueprint-kirby` starter.

## Conventions

Follow the **kirby-guidelines** skill. If your tool can't load skills, read `SKILL.md` and its references here:
https://github.com/tobiasfabian/Coding-Design-Guidelines/tree/main/skills/kirby-guidelines

## Roles

- **Agents write PHP**, preferably in `public/site/controllers` and `public/site/models`. Config, collections and plugins when the task needs them.
- **Tobias writes the frontend**: templates, snippets, CSS, JS. Don't edit these files unless he asks. Review them, point out mistakes and suggest improvements.

## Layout

- `public/` is the docroot, `public/site/` the Kirby site.
- `develop/` holds the CSS and JS sources. They are built into `public/assets/`; don't edit the built files.
- Don't touch `public/kirby/`, `public/content/` or third-party plugins in `public/site/plugins/`.

## Commands

- `npm run dev`: build CSS and JS, and watch for changes
- `npm run build`: production build
- `composer fix`: format PHP with getkirby/php-cs (needs [cpx](https://github.com/RedExplosion/cpx))

## Project notes

<!-- Languages, special plugins, hosts, anything an agent should know about this site. -->
