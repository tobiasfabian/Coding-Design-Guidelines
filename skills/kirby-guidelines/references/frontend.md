# Frontend conventions

The user writes these files. Use this page to review them and to make suggestions. The full guides are `css/README.md`, `js/README.md` and `html/README.md` in [Coding-Design-Guidelines](https://github.com/tobiasfabian/Coding-Design-Guidelines).

## Templates

- Skeleton: `snippet('head')`, then `<body>` with `o-header`, `<main>`, `o-footer` and `snippet('pre-foot')`, then `snippet('foot')`. `head` opens `<html>` and `foot` closes it.
- A PHP block at the top declares `$page` and the controller variables with `/** @var … */`.
- Use the alternative syntax (`foreach (…): ?> … <?php endforeach ?>`) and `<?= ?>` for output.
- Templates only output. Anything they need to compute belongs in the controller.

## Snippets

- Components carry an Atomic Design prefix, and the snippet, CSS class, CSS file and JS file share one name (`m-card`). Blocks live in `snippets/blocks/<type>.php`. Infrastructure snippets (`head`, `foot`, the image snippet, `routes/*`) have no prefix.
- Snippets get their data as props, not from global or controller variables. Defaults go at the top (`$size ??= null;`), followed by an early `return` if a required prop is missing.
- Build dynamic attributes with `attr([...])`; a `null` value drops the attribute.
- Images go through the project's image snippet, which uses the thumbs presets from `config/options/thumbs.php`, sets width and height, and loads lazily except above the fold.

## Markup

- BEM: block `m-card`, element `m-card__title`.
- Modifiers are data attributes named after what they do, not how they look: `data-kind`, `data-theme`, `data-size`. Leave out the default value.
- State goes in `aria-*` or `data-*` attributes, not in classes.
- Accessibility basics: alt texts, `aria-current` in navigations, labels on navigation landmarks.

## Blueprints

- Folders: `pages/`, `tabs/`, `fields/`, `blocks/`, `files/`, `sections/`. Reuse through `extends:` (`tabs/content`, `tabs/meta`, `fields/writer`, `fields/alt` …).
- File names are kebab-case, field names camelCase, labels German.
- Queries call model methods (`page.relatedProjects`) instead of long query chains.

## CSS

- One file per component in `develop/css/components/`. `index.css` contains only imports.
- The block rule comes first, followed by element rules as separate rulesets (no `&__element`).
- Modifiers are nested as `&[data-kind="…"]`. DOM children are selected with `>`, at most two levels deep.
- Mobile first: `@media (min-width: …rem)`.
- Use the tokens (`--color-content-primary`, `--size-400`, `--font-label-medium`). Component-private variables start with `--_`.
- Logical properties throughout. Property order as in `css/README.md`.

## JavaScript

- One class per component in `develop/js/components/`, named after it (`MToc`), with `constructor(element)`.
- The component file creates its own instances at the end:
  `document.querySelectorAll('.m-toc').forEach((_) => new MToc(_));`
  `index.js` only imports: `import './components/m-toc.js';`.
- Plain modern JavaScript (no TypeScript), ES modules, JSDoc for types. Built with esbuild (`npm run dev` / `npm run build`).
- State goes in data and aria attributes (`toggleAttribute`, `removeAttribute`).

## Mistakes worth checking for

These turned up repeatedly in the existing sites:

- No null check after `toFile()`, `toPage()` or `first()`.
- A non-nullable return type on a method that can return null (`teaserImage(): File`), which throws a TypeError on every page that calls it.
- Visitor input output unescaped (`value="<?= get('q') ?>"`).
- Snippets that only work because a controller variable leaks in as a global. This hides typos.
- Unbalanced parentheses in media query strings: `matchMedia('(min-width: 64em')`.
- `element.dataset.x = null` sets the string `"null"`; use `delete element.dataset.x` instead.
- Duplicate `@import` in `index.css`, or calls to snippets that don't exist (they silently render nothing).
- `.htpasswd`, `DEBUG.php` or `INFO.php` committed or left in the docroot.
