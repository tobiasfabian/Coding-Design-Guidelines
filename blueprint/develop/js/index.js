import AField from './components/a-field.js';

const aFields = [];

document.querySelectorAll('.a-field').forEach((element) => {
	aFields.push(new AField(element));
});
