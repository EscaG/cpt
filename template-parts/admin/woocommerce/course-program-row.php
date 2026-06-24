<?php

/**
 * Одна строка модуля
 * Ожидаемые переменные: $index (int|string), $module (array)
 */
if (! defined('ABSPATH')) exit;

$title       = isset($module['title'])       ? $module['title']       : '';
$description = isset($module['description']) ? $module['description'] : '';
?>

<div class="course-program-row">
	<div class="course-program-row-head">
		<span class="course-program-drag" title="Перетащити">⋮⋮</span>
		<strong class="course-program-title-preview">
			<?php echo esc_html($title) ?: '(без названия)'; ?>
		</strong>
		<button type="button" class="button course-program-remove" title="Видалити блок">✕</button>
	</div>

	<div class="course-program-row-body">
		<label>
			<span>Назва блоку</span>
			<input type="text"
				name="course_program[<?php echo esc_attr($index); ?>][title]"
				value="<?php echo esc_attr($title); ?>"
				class="widefat course-program-title-input"
				placeholder="Например: Введение в курс">
		</label>

		<label>
			<span>Короткий опис</span>
			<textarea name="course_program[<?php echo esc_attr($index); ?>][description]"
				class="widefat"
				rows="3"
				placeholder="О чём этот модуль..."><?php echo esc_textarea($description); ?></textarea>
		</label>
	</div>
</div>