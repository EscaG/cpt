(function ($) {
	'use strict';

	$(function () {

		var $list = $('#course-program-list');
		var $template = $('#course-program-template').html();

		// --- 1. Добавление строки ---
		$('#course-program-add').on('click', function () {
			// Считаем текущее количество строк — это будет новый индекс
			var newIndex = $list.find('.course-program-row').length;

			// Заменяем плейсхолдер {{INDEX}} на реальный индекс
			var newRow = $template.replace(/\{\{INDEX\}\}/g, newIndex);

			// Вставляем и подсвечиваем
			var $row = $(newRow).hide().appendTo($list).fadeIn(200);
			updateRowNumbers();
		});

		// --- 2. Удаление строки ---
		$list.on('click', '.course-program-remove', function () {
			var $row = $(this).closest('.course-program-row');

			// Не даём удалить последнюю строку (опционально)
			if ($list.find('.course-program-row').length <= 1) {
				// Очищаем поля вместо удаления
				$row.find('input, textarea').val('');
				updatePreview($row);
				return;
			}

			$row.fadeOut(150, function () {
				$(this).remove();
				reindexRows();
			});
		});

		// --- 3. Drag & Drop (сортировка) ---
		$list.sortable({
			handle: '.course-program-drag',
			items: '.course-program-row',
			axis: 'y',
			tolerance: 'pointer',
			update: function () {
				reindexRows();
			}
		});

		// --- 4. Обновление превью заголовка при вводе ---
		$list.on('input', '.course-program-title-input', function () {
			updatePreview($(this).closest('.course-program-row'));
		});

		// --- Вспомогательные функции ---

		// Пересчёт name-атрибутов после удаления/сортировки
		function reindexRows() {
			$list.find('.course-program-row').each(function (i) {
				var $row = $(this);
				$row.find('[name^="course_program["]').each(function () {
					var name = $(this).attr('name');
					// course_program[OLD][title] -> course_program[NEW][title]
					var newName = name.replace(/course_program\[\d+\]/, 'course_program[' + i + ']');
					$(this).attr('name', newName);
				});
			});
			updateRowNumbers();
		}

		// Обновление номера в заголовке строки
		function updateRowNumbers() {
			$list.find('.course-program-row').each(function (i) {
				$(this).find('.course-program-title-preview').each(function () {
					var title = $(this).text();
					if (!title || title === '(без названия)') {
						$(this).text('Модуль ' + (i + 1));
					}
				});
			});
		}

		// Обновление превью заголовка
		function updatePreview($row) {
			var val = $row.find('.course-program-title-input').val();
			$row.find('.course-program-title-preview').text(val || '(без названия)');
		}

		// Инициализация превью при загрузке
		$list.find('.course-program-row').each(function () {
			updatePreview($(this));
		});
	});

})(jQuery);