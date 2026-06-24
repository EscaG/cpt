<?php

/**
 * Мета-бокс программы курса
 * Ожидаемые переменные: $modules (array)
 */
if (! defined('ABSPATH')) exit;
?>

<div class="course-program-wrap">
	<div class="course-program-list" id="course-program-list">
		<?php foreach ($modules as $i => $module) : ?>
			<?php
			course_program_include_template('course-program-row.php', array(
				'index'  => $i,
				'module' => $module,
			));
			?>
		<?php endforeach; ?>
	</div>

	<p style="margin-top:12px;">
		<button type="button" class="button button-primary" id="course-program-add">
			+ Додати блок
		</button>
	</p>

	<!-- Скрытый шаблон для клонирования через JS -->
	<script type="text/html" id="course-program-template">
		<?php
		course_program_include_template('course-program-row.php', array(
			'index'  => '{{INDEX}}',
			'module' => array('title' => '', 'description' => ''),
		));
		?>
	</script>
</div>