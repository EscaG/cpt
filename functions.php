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
mytheme_require_file('product-variation');
mytheme_require_file('calendar-admin');
mytheme_require_file('alpine-helpers');
