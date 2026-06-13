document.addEventListener('alpine:init', () => {
	Alpine.data('headerMenu', () => ({
		mobileMenuOpen: false,
		scrollY: 0,

		openMenu() {
			this.scrollY = window.scrollY;
			document.body.style.overflow = 'hidden';
			document.body.style.position = 'fixed';
			document.body.style.top = `-${this.scrollY}px`;
			document.body.style.width = '100%';
			this.mobileMenuOpen = true;
		},

		closeMenu() {
			this.mobileMenuOpen = false;
			// Разблокируем body сразу — он не участвует в анимации меню.
			// Анимация закрытия панели идёт в отдельном div.
			this.unlockBody();
		},

		unlockBody() {
			document.body.style.overflow = '';
			document.body.style.position = '';
			document.body.style.top = '';
			document.body.style.width = '';
			// КЛЮЧЕВОЕ: возвращаем страницу на исходную позицию скролла
			window.scrollTo(0, this.scrollY);
		}
	}));
});
