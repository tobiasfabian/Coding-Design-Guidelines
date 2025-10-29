class AbstractElement {
	/** @param {HTMLElement} element */
	constructor(element) {
		this.element = element;
	}

	get isInView() {
		const rect = this.element.getBoundingClientRect();
		return (
			rect.top >= 0
			&& rect.left >= 0
			&& rect.bottom <= (window.innerHeight)
			&& rect.right <= (window.innerWidth)
		);
	}
}

export default AbstractElement;
