document.addEventListener('alpine:init', () => {
	Alpine.data('headerMenu', () => ({

		// Реактивные переменные — хранят текущий путь и хэш
		currentPath: window.location.pathname,
		currentHash: window.location.hash, // '#courses' или ''

		// Инициализация компонента (вызывается автоматически при x-init)
		init() {
			// Слушаем изменение хэша (когда юзер кликает по якорю или жмет "Назад")
			window.addEventListener('hashchange', () => {
				this.currentHash = window.location.hash;
			});

			// Слушаем popstate (кнопки "Назад"/"Вперед" в браузере)
			window.addEventListener('popstate', () => {
				this.currentPath = window.location.pathname;
				this.currentHash = window.location.hash;
			});

			// Запускаем ScrollSpy и плавный скролл
			this.initScrollSpy();
			this.initSmoothScroll();
		},

		// Проверка ТОЧНОЙ активности (путь + якорь)
		isActive(path, hash) {
			const normalizePath = (p) => p === '/' ? '/' : p.replace(/\/$/, '');
			const cPath = normalizePath(this.currentPath);
			const lPath = normalizePath(path);

			// Если у ссылки есть якорь, проверяем ТОЧНОЕ совпадение пути и якоря
			if (hash) {
				return lPath === cPath && hash === this.currentHash;
			}

			// Если якоря нет, проверяем только путь, и что в URL тоже нет якоря
			return lPath === cPath && !this.currentHash;
		},

		// Проверка РОДИТЕЛЬСКОЙ активности (например, мы на /team/john, а ссылка на /team)
		isParentActive(path) {
			const normalizePath = (p) => p === '/' ? '/' : p.replace(/\/$/, '');
			const cPath = normalizePath(this.currentPath);
			const lPath = normalizePath(path);

			// Главная не может быть "родительской"
			if (lPath === '/') return false;

			// Проверяем, что текущий путь начинается с пути ссылки + '/'
			// Например: currentPath = '/team/john', linkPath = '/team'
			return cPath.startsWith(lPath + '/');
		},

		// ScrollSpy: автоматически меняет хэш в URL при скролле
		initScrollSpy() {
			// Находим все секции с id на странице (или любые элементы с id, которые являются якорями)
			// Важно: id элементов должны совпадать с якорями в меню (например, id="courses")
			const sections = document.querySelectorAll('[id]');
			if (sections.length === 0) return;

			// Создаем IntersectionObserver — он следит, какие секции сейчас в viewport
			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						const newHash = '#' + entry.target.id;

						// Меняем хэш только если он действительно изменился
						if (this.currentHash !== newHash) {
							// Обновляем URL без перезагрузки страницы
							history.replaceState(null, null, newHash);
							// Обновляем реактивную переменную, чтобы Alpine пересчитал :class
							this.currentHash = newHash;
						}
					}
				});
			}, {
				// Секция считается "активной", когда она находится в верхней части экрана
				// rootMargin: '-20% 0px -70% 0px' означает: 
				// верхняя граница viewport сдвинута вниз на 20%, нижняя — вверх на 70%
				// То есть секция активна, когда она находится в верхних 20% экрана
				rootMargin: '-20% 0px -70% 0px',
				threshold: 0
			});

			// Начинаем следить за всеми секциями
			sections.forEach(section => observer.observe(section));
		},

		// Плавный скролл при клике на якорь
		initSmoothScroll() {
			// Находим все ссылки, содержащие '#' (но только внутри нашего меню, чтобы не ломать другие)
			const menuLinks = document.querySelectorAll('.animated-nav a[href*="#"]');

			menuLinks.forEach(anchor => {
				anchor.addEventListener('click', function (e) {
					const href = this.getAttribute('href');
					const hashIndex = href.indexOf('#');
					if (hashIndex === -1) return;

					const hash = href.slice(hashIndex);
					const target = document.querySelector(hash);

					if (target) {
						e.preventDefault(); // Отменяем стандартный резкий прыжок браузера

						// Плавно скроллим к цели
						target.scrollIntoView({
							behavior: 'smooth',
							block: 'start' // Секция остановится у верхнего края экрана
						});

						// Обновляем URL (это важно, чтобы юзер мог скопировать ссылку)
						history.pushState(null, null, hash);

						// Триггерим событие hashchange, чтобы Alpine подхватил новый хэш
						window.dispatchEvent(new Event('hashchange'));
					}
				});
			});
		}


	}));
});