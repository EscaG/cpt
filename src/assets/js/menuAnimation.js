document.addEventListener('alpine:init', () => {
	Alpine.data('headerMenu', () => ({
		// === ЛОГИКА МОБИЛЬНОГО МЕНЮ ===
		mobileMenuOpen: false,

		// === РЕАКТИВНЫЕ ПЕРЕМЕННЫЕ ДЛЯ ПОДСВЕТКИ ===
		currentPath: window.location.pathname,
		currentHash: window.location.hash,

		init() {
			// Слушаем изменение хэша
			window.addEventListener('hashchange', () => {
				this.currentHash = window.location.hash;
			});

			// Слушаем popstate (кнопки "Назад"/"Вперед")
			window.addEventListener('popstate', () => {
				this.currentPath = window.location.pathname;
				this.currentHash = window.location.hash;
			});

			// Запускаем ScrollSpy и плавный скролл ТОЛЬКО если мы на главной
			if (this.currentPath === '/') {
				this.initScrollSpy();
			}
		},

		// === ЛОГИКА МОБИЛЬНОГО МЕНЮ ===
		openMenu() {
			document.documentElement.style.overflow = 'clip';
			document.body.style.overflow = 'clip';
			const applied = getComputedStyle(document.body).overflow;
			if (applied !== 'clip') {
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

		handleMenuClick(event) {
			const link = event.target.closest('a');
			if (!link) return;

			const href = link.getAttribute('href');

			// Якорная ссылка на текущей странице (#section)
			if (href && href.startsWith('#') && href.length > 1) {
				event.preventDefault();
				this.closeMenu();

				setTimeout(() => {
					const target = document.querySelector(href);
					if (target) {
						target.scrollIntoView({ behavior: 'smooth', block: 'start' });
						history.pushState(null, '', href);
						// Обновляем реактивную переменную
						this.currentHash = href;
					}
				}, 250);
			} else {
				this.closeMenu();
			}
		},

		// === ЛОГИКА ПОДСВЕТКИ АКТИВНЫХ ССЫЛОК ===
		isActive(path, hash) {
			const normalizePath = (p) => p === '/' ? '/' : p.replace(/\/$/, '');
			const cPath = normalizePath(this.currentPath);
			const lPath = normalizePath(path);

			// Если мы на главной странице
			if (lPath === '/') {
				// Если у ссылки НЕТ якоря, то она активна только если хэш пустой
				if (!hash) {
					return cPath === '/' && !this.currentHash;
				}
				// Если у ссылки ЕСТЬ якорь, проверяем точное совпадение
				return cPath === '/' && hash === this.currentHash;
			}

			// Для всех остальных страниц
			if (hash) {
				return lPath === cPath && hash === this.currentHash;
			}
			return lPath === cPath && !this.currentHash;
		},

		isParentActive(path) {
			const normalizePath = (p) => p === '/' ? '/' : p.replace(/\/$/, '');
			const cPath = normalizePath(this.currentPath);
			const lPath = normalizePath(path);

			if (lPath === '/') return false;
			return cPath.startsWith(lPath + '/');
		},

		// === SCROLLSPY ===
		initScrollSpy() {
			// === ШАГ 1: Собираем все якоря из меню ===
			const menuLinks = document.querySelectorAll('.animated-nav a[href*="#"], .mobile-menu a[href*="#"]');
			const menuHashes = new Set();

			menuLinks.forEach(link => {
				const href = link.getAttribute('href');
				const hashIndex = href.indexOf('#');
				if (hashIndex !== -1) {
					const hash = href.slice(hashIndex); // '#courses', '#reviews' и т.д.
					menuHashes.add(hash);
				}
			});

			// Если в меню нет якорей, выходим
			if (menuHashes.size === 0) return;

			console.log('Меню содержит якоря:', Array.from(menuHashes));

			// === ШАГ 2: Находим только те секции, чьи id есть в меню ===
			const sections = [];
			menuHashes.forEach(hash => {
				const section = document.querySelector(hash);
				if (section) {
					sections.push(section);
				} else {
					console.warn(`Секция ${hash} найдена в меню, но отсутствует на странице`);
				}
			});

			if (sections.length === 0) {
				console.warn('Не найдено ни одной секции для ScrollSpy');
				return;
			}

			// === ШАГ 3: Отслеживаем, какие секции сейчас в viewport ===
			const visibleSections = new Set();

			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					const hash = '#' + entry.target.id;

					if (entry.isIntersecting) {
						visibleSections.add(hash);
					} else {
						visibleSections.delete(hash);
					}
				});

				// === ШАГ 4: Определяем активную секцию ===
				if (visibleSections.size > 0) {
					// Находим самую верхнюю видимую секцию
					const firstVisible = Array.from(visibleSections).sort((a, b) => {
						const aTop = document.querySelector(a).getBoundingClientRect().top;
						const bTop = document.querySelector(b).getBoundingClientRect().top;
						return aTop - bTop;
					})[0];

					// Обновляем хэш только если он изменился
					if (this.currentHash !== firstVisible) {
						history.replaceState(null, null, firstVisible);
						this.currentHash = firstVisible;
						console.log('ScrollSpy: активна секция', firstVisible);
					}
				} else {
					// === ШАГ 5: Ни одна секция не видна — очищаем хэш ===
					if (this.currentHash) {
						history.replaceState(null, null, window.location.pathname);
						this.currentHash = '';
						console.log('ScrollSpy: хэш очищен, активна главная страница');
					}
				}
			}, {
				// Секция считается "активной", когда она находится в верхних 20% экрана
				rootMargin: '-20% 0px -70% 0px',
				threshold: 0
			});

			// Начинаем следить только за нужными секциями
			sections.forEach(section => observer.observe(section));

			console.log(`ScrollSpy инициализирован для ${sections.length} секций`);
		}
	}));
});