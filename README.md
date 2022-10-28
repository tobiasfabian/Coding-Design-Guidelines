# Design Guidlines

## Table of Contents

- [Writing JavaScript](js/README.md)
- [Writing (S)CSS](css/README.md)
- [Writing HTML](html/README.md)


## Atomic Design

> We’re not designing pages, we’re designing systems of components. 

– Stephen Hay

The coding guidelines are based on [Atomic Design](https://atomicdesign.bradfrost.com) by Brad Frost. For structuring individual components I use [BEM](https://getbem.com) (Block, Element, Modifier). Atomic Design in combination with BEM was described by Daniel Tonon ([ABEM. A more useful adaptation of BEM](https://css-tricks.com/abem-useful-adaptation-bem/)).

The terms *Block* (BEM method) and *Component* (Atomic Design) have the same meaning for these design guidelines and are used interchangeably.

Atomic Design distinguishes between the following *Components*.
- **Atoms** (`a`)
    > Atoms serve as the foundational building blocks that comprise all our user interfaces. These atoms include basic HTML elements like form labels, inputs, buttons, and others that can’t be broken down any further.
- **Molecules** (`m`) 
    > Molecules are relatively simple groups of UI elements functioning together as a unit. For example, a form label, search input, and button can join together to create a search form molecule.
- **Organisms** (`o`) 
    > Organisms are relatively complex UI components composed of groups of molecules and/or atoms and/or other organisms. These organisms form distinct sections of an interface.
- **Templates** (`t`)  
    > Templates are page-level objects that place components into a layout and articulate the design’s underlying content structure.

### Example

An *Atom* (`a`) component called *field*.  
`a-field` is the *Block*. `-secondary` is the *Modifier*. `a-field__counter` is an *Element* inside the block/inside the component.

```html
<div class="a-field -secondary">
  <label>Lorem</label>
  <span class="a-field__counter">5</span>
  <input value="Ipsum" type="text">
</div>
```

<details>
<summary>CSS: <code>/develop/scss/components/_a-field.scss</code></summary>

```scss
.a-field {
  > label {
    font-weight: 700;
  }
  
  &.-secondary {
    > label {
      color: gray;
    }
  }
}

.a-field__counter {
  font-size: 0.8em;
}
```

</details>

<details>
<summary>JavaScript: <code>/develop/js/components/a-field.js</code></summary>

```js
class AField {
  constructor(element) {
    const inputElement = element.querySelector('input');
    const counterElement = element.querySelector('.a-field__counter');
    
    function onInputChange() {
      counterElement.innerText = inputElement.value.length;
    }
    
    inputElement.addEventListener('change', onInputChange);
  }
}

export default AField;
```
</details>


## Compiling

Ideally, compilation is avoided. For optimal browser support and to import npm modules, compilation and bundling can’t be bypassed.

Compilation is done by `npm run` command ([npm scripts](https://docs.npmjs.com/cli/using-npm/scripts)). This has the advantage that different compilation methods can be used depending on the project.

The following scripts/commands should be available in every project:

- `npm run js`  
    Compiles JavaScript to work in all browsers to be supported. The JavaScript is minified. Source maps are created.  
  
    ```json
    "js": "npx webpack --config webpack.config.js",
    ```
    
- `npm run js-dev`  
    Compiles JavaScript and activates a watcher. The JavaScript is recompiled when a relevant file changes. The JavaScript supports only the browsers used by the developer. It is not minified to facilitate debugging and to reduce compilation time. Source maps are created.  
  
    ```json
    "js": "npx webpack --config webpack.config.dev.js",
    ```
  
- `npm run js-lint`  
    Checks and corrects all JavaScript files with [*eslint*](https://eslint.org).  
  
    ```json
    "js-lint": "npx eslint --fix develop/js",
    ```
  
- `npm run scss`  
    Compiles and minifies SASS. Source maps are created.  
  
    ```json
    "scss": "npx sass --style=compressed --embed-sources develop/scss:public/assets/css",
    ```
  
- `npm run scss-dev`  
    Compiles SASS and starts a watcher. The CSS files are not minified. Source maps are created.  
  
    ```json
    "scss-dev": "npx sass --watch --embed-sources develop/scss:public/assets/css",
    ```
  
- `npm run build`  
    Compiles JavaScript and SASS.  
  
    ```json
    "build": "npm run scss; npm run js-lint; npm run js;"
    ```


## Folder structure

- `domainname.tld`
    - `develop`
        - `js`
            - `components`
                - `a-*.js`
                - `t-*.js`
                - `m-*.js`
                - `o-*.js`
            - `config`
                - `*.js`
            - `libraries`
                - `*.js`
            - `index.js`
            - `*.js`
        - `scss`
            - `components`
                - `_a-*.scss`
                - `_t-*.scss`
                - `_m-*.scss`
                - `_o-*.scss`
            - `configs`
                - `_reset.scss`
                - `_variables.scss`
            - `fonts`
                - `_*.scss`
            - `libraries`
                - `_*.scss`
            - `index.scss`
            - `*.scss`
    - `public`
        - `assets`
            - `css`
                - `index.css`
                - `*.scss`
            - `fonts`
                - `*.woff2`
            - `images`
                - `apple-touch-icon.png`
                - `favicon.png`
                - `*.webp`
                - `*.svg`
            - `js`
                - `index.js`
                - `*.js`
        - `index.[html|php]`
    - `.babelrc`
    - `.browserslistrc`
    - `.connect-to-server`
    - `.editorconfig`
    - `.eslintrc`
    - `.gitignore`
    - `package.json`


## Appendix

- [Atomic Design, Brad Frost](https://atomicdesign.bradfrost.com)
- [BEM](https://getbem.com)
- [ABEM. A more useful adaptation of BEM. – CSS-Tricks, Daniel Tonon, 2017](https://css-tricks.com/abem-useful-adaptation-bem/)
- [Relearn CSS layout: Every Layout, Heydon Pickering and Andy Bell](https://every-layout.dev)
