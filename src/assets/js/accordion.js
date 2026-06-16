document.addEventListener('alpine:init', () => {
	Alpine.data('accordion', () => ({
		openMonths: {},
		firstMonthId: null,

		init() {
			// Первый месяц будет открыт по умолчанию
			this.firstMonthId = this.$el.querySelector('[data-month-id]')?.dataset.monthId;
			if (this.firstMonthId) {
				this.openMonths[this.firstMonthId] = true;
			}
		},

		toggleMonth(monthId) {
			this.openMonths[monthId] = !this.openMonths[monthId];
		},

		isMonthOpen(monthId) {
			return !!this.openMonths[monthId];
		}
	}));
});