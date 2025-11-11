# Writing HTML

## Spaces

For better grouping, one line can be left blank between two elements. Two blank lines are not allowed. No blank line is allowed before a closing tag.

```html
<header>
	…
</header>

<main>
	<div>
		<span></span>
		<span></span>
		
		<h1></h1>
		
		<p></p>
	</div>
</main>

<footer>
	…
</footer>
```

## Attributes

Normally attributes are written inline. If there are more than three attributes, the attributes are written one below the other.

```html
<header
	id="header"
	class="o-header"
	data-example="*"
	aria-describedby="header-heading"
>
	…
</header>
```

### Order of Attributes
- `id`
- `href`
- `type`
- `name`
- `title`
- `class`
- `data-*`
- `aria-*`
- `hidden`
