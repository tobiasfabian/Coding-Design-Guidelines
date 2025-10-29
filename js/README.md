# Writing JavaScript

## Compiling

JavaScript is written in plain, modern JavaScript (not Typescript). Theoretically the code could run by modern browser without compiling. In practice not every browser in use understands all modern JavaScript. JavaScript code is compiled with Babel and bundled with webpack.

By default `index.js` inside the JavaScript directory (`/develop/js/`) is compiled and bundled to (`/public/assets/js/`). If you want another JavaScript file to be compiled and bundled, you have to add this file to the `entry` option of the webpack configuration (`/webpack.config.js`).

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

All JavaScript files are linted against the [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript).

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
