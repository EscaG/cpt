document.addEventListener('alpine:init', () => {
	Alpine.data('headerMenu', () => ({
		mobileMenuOpen: false,

		openMenu() {
			// Сначала пробуем современный вариант — сохраняет sticky
			document.documentElement.style.overflow = 'clip';
			document.body.style.overflow = 'clip';

			// Проверяем, сработало ли. Если нет — фолбэк на старый способ.
			// getComputedStyle вернёт то, что реально применил браузер.
			const applied = getComputedStyle(document.body).overflow;
			if (applied !== 'clip') {
				// Старый браузер — применяем hidden (sticky сломается, но как раньше)
				document.documentElement.style.overflow = 'hidden';
				document.body.style.overflow = 'hidden';
			}

			this.mobileMenuOpen = true;
		},

		closeMenu() {
			this.mobileMenuOpen = false;
			document.documentElement.style.overflow = '';
			document.body.style.overflow = '';
		},

		/**
		 * Делегированный обработчик кликов внутри меню.
		 * Ловит любые клики по <a> — и якорные, и внешние.
		 */
		handleMenuClick(event) {
			const link = event.target.closest('a');
			if (!link) return;

			const href = link.getAttribute('href');

			// Якорная ссылка на текущей странице (#section)
			if (href && href.startsWith('#') && href.length > 1) {
				event.preventDefault(); // отменяем нативный прыжок браузера
				this.closeMenu();

				// Ждём окончания анимации закрытия меню
				// (у тебя x-transition:leave duration-200, берём с запасом)
				setTimeout(() => {
					const target = document.querySelector(href);
					if (target) {
						target.scrollIntoView({ behavior: 'smooth', block: 'start' });
						// Обновляем URL, чтобы работала кнопка «Назад»
						history.pushState(null, '', href);
					}
				}, 250);
			} else {
				// Любая другая ссылка (instagram, telegram и т.д.) — просто закрываем меню
				this.closeMenu();
			}
		}
	}));
});