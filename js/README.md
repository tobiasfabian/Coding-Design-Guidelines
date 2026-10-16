# Writing JavaScript

## Compiling

JavaScript is written in plain, modern JavaScript (not TypeScript). In theory it could run in modern browsers without compiling. In practice not every browser in use understands all modern JavaScript, and npm modules have to be bundled anyway. JavaScript is bundled with [esbuild](https://esbuild.github.io) (`/develop/build.mjs`).

Every JavaScript file directly inside the JavaScript directory (`/develop/js/`), usually just `index.js`, is bundled to `/public/assets/js/`. For another bundle, for example one that only certain pages load, add another file there.

## Components

When a component needs some JavaScript, each components gets its own JavaScript file. These files are stored in the `components/` directory.

Each component file contains only one class with the name of the component written in UpperCamelCase. (e.g. `AField`). The class has to have a constructor. Usually the first argument of the constructor is `element`, which is a DOM element. This class is exported as `default` (`export default AField;`).

The `index.js` (or other JavaScript files in the JavaScript root directory) imports the classes and creates instances.

## Style Guide

### Order within `constructor`
- super
	`super(elememt)`
- element variables
	`const loremElement = element.querySelector(…)`  
	`const loremElements = element.querySelectorAll(…)`
- other variables
	`const lorem = …`
- class element properties
	`this.loremElement = …`  
	`this.loremElements = …`
- class properties
	`this.lorem = …`
- functions
	`function lorem() {…}`
- event functions
	`function onLorem() {…}`
- event listeners
	`loremElement.addEventListener('lorem', onLorem)`
- init
	Run functions or method functions.

### Order of methods
- constructor
	`constructor(element) {}`
- gets
	`get isInView() {}`
- methods
	`lorem() {}`
- event methods
	`onLorem() {}`
- init method
	`init() {}`
	
### Example
```js
import AbstractElement from '../configs/abstract-element';

class AField extends AbstractElement {
  /** @param {HTMLDivElement} element */
  constructor(element) {
    // super
    super(element);

    // variables
    const { theme } = element.dataset;

    // class properties
    this.element = element;

    /** @type {HTMLInputElement} */
    this.inputElement = element.querySelector('input');

    // functions
    function lorem() {
      // …
    }

    // event functions
    /** @param {InputEvent} event */
    function onInput(event) {
      // …
    }

    // event listeners
    if (theme === 'positive') {
      this.inputElement.addEventListener('input', onInput);
    }

    // init
    this.init();
  }

  get value() {
    return this.inputElement.value;
  }

  init() {
    // …
  }
}

document.querySelectorAll('.a-field').forEach((_) => new AField(_));

export default AField;
```

## Linting

All JavaScript files are linted with [ESLint](https://eslint.org) (`eslint.config.mjs`): the recommended rules plus tab indentation via `@stylistic`. Run `npx eslint develop/js`.

## JSDoc

[JSDoc](https://jsdoc.app/howto-es2015-classes) comments should be used whenever possible.

### Advanced

Type definitions can be imported.

```js
/** @typedef {import("../custom-elements/my-field").default} MyField */

//…
/** @type {MyField} */
const aFieldElement = document.querySelector('my-field');
//…
```
