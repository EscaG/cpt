<?php

/**
 * Модуль "Програма курсу"
 *
 * - Мета-бокс в админке товара
 * - Сохранение данных
 * - Хелпер для получения модулей на фронтенде
 */

if (! defined('ABSPATH')) exit;

/* -------------------------------------------------
 * 1. Подключение JS и CSS ТОЛЬКО в админке товара
 * ------------------------------------------------- */
add_action('admin_enqueue_scripts', 'course_program_admin_assets');
function course_program_admin_assets($hook)
{
	global $post_type, $post;

	// Грузим только на странице редактирования товара
	$is_product_edit = ($hook === 'post.php' || $hook === 'post-new.php') && $post_type === 'product';

	if (! $is_product_edit) {
		return;
	}

	wp_enqueue_style(
		'course-program-admin',
		get_template_directory_uri() . '/assets/css/course-program-admin.css',
		array(),
		'1.0'
	);

	wp_enqueue_script(
		'course-program-admin',
		get_template_directory_uri() . '/assets/js/course-program-admin.js',
		array('jquery', 'jquery-ui-sortable'),
		'1.0',
		true
	);
}

/* -------------------------------------------------
 * 2. Регистрация мета-бокса
 * ------------------------------------------------- */
add_action('add_meta_boxes', 'course_program_add_meta_box');
function course_program_add_meta_box()
{
	add_meta_box(
		'course_program_box',
		'Програма курсу',
		'course_program_render_box',
		'product',
		'normal',
		'high'
	);
}

/* -------------------------------------------------
 * 3. Рендер мета-бокса (подключает шаблон)
 * ------------------------------------------------- */
function course_program_render_box($post)
{
	wp_nonce_field('course_program_save', 'course_program_nonce');

	$modules = course_program_get_modules($post->ID);

	if (empty($modules)) {
		$modules = array(array('title' => '', 'description' => ''));
	}

	course_program_include_template('course-program-box.php', array(
		'modules' => $modules,
	));
}

/* -------------------------------------------------
 * 4. Сохранение данных
 * ------------------------------------------------- */
add_action('save_post', 'course_program_save_meta', 10, 2);
function course_program_save_meta($post_id, $post)
{
	// Nonce
	if (
		! isset($_POST['course_program_nonce'])
		|| ! wp_verify_nonce($_POST['course_program_nonce'], 'course_program_save')
	) {
		return;
	}

	// Автосохранение
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	// Права
	if (! current_user_can('edit_post', $post_id)) return;

	// Обработка
	if (isset($_POST['course_program']) && is_array($_POST['course_program'])) {
		$clean = array();

		foreach ($_POST['course_program'] as $row) {
			$title       = isset($row['title'])       ? sanitize_text_field($row['title'])       : '';
			$description = isset($row['description']) ? sanitize_textarea_field($row['description']) : '';

			// Пропускаем полностью пустые строки
			if ($title === '' && $description === '') continue;

			$clean[] = array(
				'title'       => $title,
				'description' => $description,
			);
		}

		$clean = array_values($clean);

		if (! empty($clean)) {
			update_post_meta($post_id, '_course_program', $clean);
		} else {
			delete_post_meta($post_id, '_course_program');
		}
	} else {
		delete_post_meta($post_id, '_course_program');
	}
}

/* -------------------------------------------------
 * 5. ПУБЛИЧНЫЙ ХЕЛПЕР — используйте в своём шаблоне товара
 *
 * Пример:
 *   $modules = course_program_get_modules( $product_id );
 *   foreach ( $modules as $m ) { echo $m['title']; }
 * ------------------------------------------------- */
function course_program_get_modules($product_id)
{
	$modules = get_post_meta($product_id, '_course_program', true);
	return is_array($modules) ? $modules : array();
}

/* -------------------------------------------------
 * 6. Внутренняя функция подключения шаблонов
 * ------------------------------------------------- */
function course_program_include_template($template_name, $args = array())
{
	$path = get_template_directory() . '/template-parts/admin/woocommerce/' . $template_name;

	if (! file_exists($path)) {
		return;
	}

	if (! empty($args) && is_array($args)) {
		extract($args);
	}

	include $path;
}
