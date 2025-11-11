import AbstractElement from '../foundation/abstract-element';

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
