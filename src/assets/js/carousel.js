document.addEventListener('alpine:init', () => {
	Alpine.data('reviewsCarousel', (totalSlides) => ({
		realCount: totalSlides,
		currentIndex: 0,
		translateX: 0,
		isDragging: false,
		startX: 0,
		dragOffset: 0,
		autoplayTimer: null,
		canScroll: false,
		clonesCount: 0,

		init() {
			const track = this.$refs.track;
			if (!track || !track.children.length) return;

			const realSlides = Array.from(track.children);
			this.clonesCount = Math.min(4, this.realCount);

			for (let i = 0; i < this.clonesCount; i++) {
				track.appendChild(realSlides[i].cloneNode(true));
				track.prepend(realSlides[this.realCount - 1 - i].cloneNode(true));
			}

			this.currentIndex = this.clonesCount;

			this.checkScrollability();
			this.updateTranslate(false);

			window.addEventListener('resize', () => {
				this.checkScrollability();
				this.updateTranslate(false);
			});

			if (this.canScroll) {
				this.startAutoplay();
				this.$root.addEventListener('mouseenter', () => this.stopAutoplay());
				this.$root.addEventListener('mouseleave', () => this.startAutoplay());
			}
		},

		get slideWidth() {
			const child = this.$refs.track?.children[0];
			return child ? child.offsetWidth + 16 : 0;
		},

		// Оставляем только этот геттер, он работает с числами, а не с DOM
		get realIndex() {
			if (this.realCount === 0) return 0;
			let idx = this.currentIndex - this.clonesCount;
			return ((idx % this.realCount) + this.realCount) % this.realCount;
		},

		updateTranslate(animate = true) {
			if (!this.canScroll) {
				this.translateX = -(this.clonesCount * this.slideWidth);
				return;
			}
			this.translateX = -(this.currentIndex * this.slideWidth);
		},

		checkScrollability() {
			const containerWidth = this.$root.querySelector('.overflow-hidden').offsetWidth;
			const visibleCount = Math.floor(containerWidth / this.slideWidth);

			const isMobile = window.innerWidth < 640;
			this.canScroll = this.realCount > visibleCount || (isMobile && this.realCount > 1);

			if (!this.canScroll) {
				this.stopAutoplay();
			}
		},

		next() {
			if (!this.canScroll) return;
			this.currentIndex++;
			this.updateTranslate(true);
		},

		prev() {
			if (!this.canScroll) return;
			this.currentIndex--;
			this.updateTranslate(true);
		},

		goTo(index) {
			if (!this.canScroll) return;
			this.currentIndex = this.clonesCount + index;
			this.updateTranslate(true);
			this.resetAutoplay();
		},

		handleTransitionEnd(e) {
			if (e.propertyName !== 'transform') return;

			if (this.currentIndex >= this.realCount + this.clonesCount) {
				this.currentIndex = this.clonesCount;
				this.updateTranslate(false);
			}
			else if (this.currentIndex < this.clonesCount) {
				this.currentIndex = this.clonesCount + this.realCount - 1;
				this.updateTranslate(false);
			}
		},

		startDrag(e) {
			if (!this.canScroll) return;
			this.isDragging = true;
			this.startX = this.getPositionX(e);
			this.stopAutoplay();
		},

		onDrag(e) {
			if (!this.isDragging) return;
			if (e.type === 'mousemove') e.preventDefault();

			this.currentX = this.getPositionX(e);
			this.dragOffset = this.currentX - this.startX;
			this.translateX = -(this.currentIndex * this.slideWidth) + this.dragOffset;
		},

		endDrag() {
			if (!this.isDragging) return;
			this.isDragging = false;

			const threshold = this.slideWidth / 4;
			if (this.dragOffset < -threshold) this.next();
			else if (this.dragOffset > threshold) this.prev();
			else this.updateTranslate(true);

			this.dragOffset = 0;
			this.startAutoplay();
		},

		getPositionX(e) {
			return e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
		},

		startAutoplay() {
			if (!this.canScroll || this.autoplayTimer) return;
			this.autoplayTimer = setInterval(() => this.next(), 4000);
		},

		stopAutoplay() {
			clearInterval(this.autoplayTimer);
			this.autoplayTimer = null;
		},

		resetAutoplay() {
			this.stopAutoplay();
			this.startAutoplay();
		}
	}));
});

