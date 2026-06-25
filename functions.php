<?php

// Проверка на прямой доступ (безопасность)
if (! defined('ABSPATH')) {
	exit;
}

// Функция для безопасного подключения файлов
function mytheme_require_file($file)
{
	$path = get_template_directory() . '/inc/' . $file . '.php';
	if (file_exists($path)) {
		require_once $path;
	}
}

// Подключаем основные модули
mytheme_require_file('setup');
mytheme_require_file('images');
mytheme_require_file('request');

// Подключаем кастомный функционал WooCommerce, только если плагин активен
if (class_exists('WooCommerce')) {
	require_once get_template_directory() . '/inc/woocommerce/loader.php';
	// Если это плагин, используйте plugin_dir_path(__FILE__) вместо get_template_directory()
}

mytheme_require_file('calendar-admin');
mytheme_require_file('alpine-helpers');
mytheme_require_file('menu');
