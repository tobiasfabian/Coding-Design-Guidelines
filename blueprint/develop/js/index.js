import AField from './components/a-field.js';

const aFields = [];

document.querySelectorAll('.a-field', (element) => {
	aFields.push(new AField(element));
});
