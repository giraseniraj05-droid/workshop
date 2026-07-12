import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('passwordVisibility', () => ({
	visible: false,

	toggle() {
		this.visible = !this.visible;
	},
}));

Alpine.start();
