# Writing CSS

CSS files in the `/develop/css` directory (*css-root*) contain only imports, but no custom rules. These files are compiled to (`/public/assets/css`).

In the *css-root* there is an `index.css` file. This file contains all fonts, libraries, configs, helpers and components that are relevant for most of the whole website.

For special pages a separate CSS file can be created. For example, this file can contain large libraries and/or components that are only relevant for certain pages/templates. Not everything needs to be placed in the index.css. Thus, the index.css can be kept small. The load time of the web pages are optimized thereby.

<details>
<summary>What should be swapped out to a separate css file?</summary>

In general, large CSS libraries (for example mapbox-gl.css) that are only needed on certain pages should not be imported into index.css.

</details>


## Naming

Each *Block* must have a prefix (`a`, `m`, `o` or `t`, according to Atomic Design) followed by `-` and the name of the block (e.g `header`). *Kebab-case* is used, words are connected with `-`.  
Example: `m-alert-banner`

The name of the *Element* is separated by `__`.  
Example: `m-alert-banner__heading`

### Modifier
The name of a *Modifier* is preceded by `-`. (e.g. `-danger`). The *Modifier* isn’t hard wired to the *Element* (in pure BEM it would be `m-alert-banner--danger`). This must be taken into account. The pros and cons of this technique are described in [ABEM. A more useful adaptation of BEM. – CSS-Tricks](https://css-tricks.com/abem-useful-adaptation-bem/#aa-abem-modifier-issues).  
Example: `a-button -danger`

### Function over appearance
Generally names should describe the function not the appearance. Names should be as general as possible but as specific as needed. A red “delete item” button should get a *Modifier* called `-danger` instead of `-red`. `-red` is describing the appearance. `-delete` is too specific, `-danger` is more generic.

### Variables
Variables should be named after the property for which they are intended.  
Example: `--transition-duration: 300ms` instead of `--transition: 300ms`.  
`--transition: opacity 200ms linear` is fine, beacuse it describes the whole transition property.

Most of the time, variables are meant for a specific *thing*. To describe this specific *thing*, use `--` to separate the attribute name from the *thing*.  
Example: `--transition-duration--popup: 500ms`

For *variables*, the rule that function is preferable over appearance also applies. 
Example: `--font-family--heading` instead of `--font-family--serif`.

<details>
<summary><strong>Colors</strong></summary>

Colors can be named according to their appearance. You should use `--color-red` if you want something to be red. But if you want to indicate that something might have a negative effect, you should use `--color-negative`. This could be an alias of `--color-red`.

For graduations of colors you should use the numbers used for `font-weight`, where 500 should be the default color.

```css
--color-red-300: hsl(0, 90%, 70%);
--color-red-400: hsl(0, 90%, 60%);
--color-red-500: hsl(0, 90%, 50%);
--color-red-600: hsl(0, 90%, 40%);
--color-red: var(--color-red-600);
--color-negative: var(--color-red);
```
</details>


## Nesting

Nesting makes writing CSS much easier. But when it's overused, the specificity is getting higher and the indentations get longer and longer. It’s getting harder to read and more difficult to maintain. That's why not everything that can be nested is nested.

### Blocks and Elements

Each block get’s its own file (e.g. `components/_m-alert-banner.css`. The file starts with the rule of the *Block* selector itself. The *Block* selector is followed by the *Element* selectors.

```css
.m-alert-banner {
	…
}

.m-alert-banner__heading {
	…
}

.m-alert-banner__buttons {
	…
}
```

*Elements* theoretically could be nested inside of the *Block* (`&__heading`), but this would clutter the *Block* which make it harder to maintain and read.

### Modifiers

*Modifiers* are written inside of each *Block* or *Element*. Preferably only *Blocks* do have *Modifiers*, but *Elements* can have *Modifiers* too.

```css
.m-alert-banner {
	&.-danger {
		…
	}
}
```
#### Element with Block Modifier
```css
.m-alert-banner__heading {
	.m-alert-banner.-danger & {
		…
	}
}
```

### CSS selectors

Inside a *Block*/*Element* there might be rules for other DOM elements. To avoid conflicts these rules should be very specific. Namely DOM elements should be selected only with the [Child combinator](https://developer.mozilla.org/en-US/docs/Web/CSS/Child_combinator).

```css
.m-alert-banner {
	> h2 {
		…
		
		> span {
			…
		}
	}
}
```

Maximal two children should be nested. 

### Order inside of *Block*/*Element*

The rules inside of a *Block*/*Element* could be very long that’s why a specific order could become handy to find things. After each group of rules there should be single empty line.

- [`@keyframes`](https://developer.mozilla.org/en-US/docs/Web/CSS/@keyframes)
- Properties  
	See [*Order of properties*](#order-of-properties)
- [Pseudeo-elements](https://developer.mozilla.org/en-US/docs/Web/CSS/Pseudo-elements)  
	`&::after`, `::backdrop`
- [Child combinator](https://developer.mozilla.org/en-US/docs/Web/CSS/Child_combinator)  
	`> h1`
- [Adjacent sibling combinator](https://developer.mozilla.org/en-US/docs/Web/CSS/Adjacent_sibling_combinator) in combination with *Child combinator*   
	This is used to define how elements behave against other elements. E.g. the `margin-block-start` of a `p` element after a `h1` element. (See [The Stack: Every Layout](https://every-layout.dev/layouts/stack/))  
	`> h1 + p` 
- *Modifiers* ([Element with Block Modifier](#element-with-block-modifier))  
	`.m-alert-banner.-danger &`
- *Modifiers*  
	`&.-danger`
- `@supports` rules
- [Pseudo-classes](https://developer.mozilla.org/en-US/docs/Web/CSS/Pseudo-classes)  
	`:hover`, `:focus-visible`
- *Adjacent sibling combinator* for the *Block*/*Element* itself  
	This is used to define how this *Block*/*Element* behaves against other *Blocks*/*Elements* of the same kind.  
	`& + &`
- *Adjacent sibling combinator* for the *Block*/*Element* against other *Blocks*/*Elements*  
	This is used to define how this *Block*/*Element* behaves against other *Blocks*/*Elements*.  
	`.m-form + &`
- `@media` queries  
	`(min-width: …)` before `not all and (min-width: …)`

#### Fictive example

```css
.m-alert-banner {
	@keyframes pulse {
		…
	}
	
	--var-lorem: …;

	padding: 1rem;
	border: 2px solid var(--color-alert);
	animation-name: pulse;
	…
	
	> h2 {
		font-size: …;
	}
	> p {
		…
	}
	
	> h2 + p {
		margin-block-start: 1rem;
	}
	
	&.-danger {
		…
	}
	
	@supports (…) {
		…
		
		&.-danger {
			…
		}
	}
	
	&:focus-inside {
		> h2 {
			…
		}
	}

	& + & {
		margin-block-start: 1rem;
	}
	
	.m-form + & {
		…
	}
	
	@media (min-width: …) {
		…
	}
	@media not all and (min-width: …) {
		…
	}
}
```

### Selecting *Blocks*/*Elements* inside of *Blocks*/*Elements*

*Blocks*/*Elements* are independent components. That’s why *Blocks*/*Elements* may not be selected inside of another *Blocks*/*Elements*. 

When it’s needed to style a *Block* depended on another *Block*, this could be achieved like this:

```css
.a-button {
		…

	.m-alert-banner & {
		background-color: …;
	}
}
```

This syntax should be avoided. What if the `a-button` is inside a `m-dialog` (which is inside of `m-alert-banner`). `a-button` will get the background-color which might not be the intended behavior.  
Modifiers should be used instead.

```css
.a-button {

	&.-alert {
		background-color: …;
	}
}
```


## Media queries

A mobile-first approach should be followed. In most cases, the user interface design for mobile devices is simpler than that for larger devices. Additional complexitiy (larger devices) is added to the simpler mobile styles. This is the reason why `@media (min-width: …)` should be used.

To add specific styles for smaller devices the `(min-width)` rule can be negated like this `@media not all and (min-width: …)`


## Order of properties

There are about 400 CSS properties. To quickly find the right property there is the following order. The list is incomplete. Missing properties can be sorted accordingly.

- variables
	`--var-*`
- generated content  
	`content`
- appearance  
	`position`, `display`, `appearance`, `opacity`, `visibility`, `cursor`, `pointer-events`
	- clipping  
		`clip-path`, `overflow`
- positioning
		- size  
			`box-sizing`, `width`, `height`, `[min|max]-[width|heigh]`,
		- grid/flex (Properties for the Children)  
			`grid-[row|column]-[start|end]`  
			`flex-base`, `flex-shrink`, `flex-grow`  
			`justify-self`, `align-self`
		- inset/margin  
			`inset`, `z-index`, `margin`
		- `translate`  
- border  
	`box-shadow`, `border`, `border-radius`, `outline`
- padding  
	`padding-[inline|block]`
- content  
		- grid/flex (Properties for the Parent)   
			`grid-template-[columns|rows]`, `[justify|align]-[content|items]`, `gap`
		- lists/columns/table  
			`list-style`, `columns`, `border-collapse`
		- typography  
			`text-[align|transform|...]`  
			`line-height`, `letter-spacing`  
			`font-[size|weight|...]`  
			`white-space`, `hyphens`  
			`color`
- background  
	`background-[image|color|...]`, `backdrop-filter`
- animation  
	`transition`, `animation`, `will-change`
