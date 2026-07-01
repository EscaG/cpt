<?php

// Регистрация типа записи "Переваги навчання в Центрі"
function advantages_of_studying()
{
	$labels = array(
		'name'               => 'Переваги',
		'singular_name'      => 'Перевага',
		'add_new'            => 'Додати нову',
		'add_new_item'       => 'Додати нову перевагу',
		'edit_item'          => 'Редагувати перевагу',
		'new_item'           => 'Нова перевага',
		'view_item'          => 'Подивитись перевагу',
		'search_items'       => 'Знайти перевагу',
		'not_found'          => 'Перевагу не знайдено',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'has_archive'         => true,
		// 'show_in_rest'        => true, // Включает поддержку современного редактора Gutenberg
		'supports'            => array('title', 'editor', 'thumbnail'), // title = заголовок, editor = описание, thumbnail = картинка
		'menu_icon'           => 'dashicons-admin-users',
		'rewrite'             => array('slug' => 'advantages'),
	);

	register_post_type('advantage', $args);
}
add_action('init', 'advantages_of_studying');

//  Регистрация типа записи "Отзывы" (Скриншоты)
function register_reviews_cpt()
{
	register_post_type('review', [
		'labels' => [
			'name'          => 'Відгуки',
			'singular_name' => 'Відгук',
			'menu_name'     => 'Відгуки',
			'add_new_item'  => 'Додати заголовок',
		],
		'public'       => true,
		'has_archive'  => false,
		// 'show_in_rest' => true,
		'supports'     => ['title', 'thumbnail'], // Только заголовок и картинка
		'menu_icon'    => 'dashicons-format-image',
	]);
}
add_action('init', 'register_reviews_cpt');

// 1. Регистрация типа записи "Отзывы" (Скриншоты)
// function register_reviews_cpt()
// {
// 	register_post_type('review', [
// 		'labels' => [
// 			'name'               => 'Отзывы',
// 			'singular_name'      => 'Отзыв',
// 			'add_new'            => 'Добавить скриншот',
// 			'add_new_item'       => 'Добавить новый скриншот отзыва',
// 			'edit_item'          => 'Редактировать отзыв',
// 			'new_item'           => 'Новый отзыв',
// 			'view_item'          => 'Посмотреть отзыв',
// 			'search_items'       => 'Искать отзыв',
// 			'not_found'          => 'Отзывов не найдено',
// 			'not_found_in_trash' => 'В корзине отзывов не найдено',
// 			'menu_name'          => 'Отзывы',
// 		],
// 		'public'              => true,
// 		'has_archive'         => false,
// 		'show_in_rest'        => true, // Включаем REST API (на будущее)
// 		'supports'            => ['title', 'thumbnail'], // Только заголовок и картинка!
// 		'exclude_from_search' => true,
// 		'publicly_queryable'  => false,
// 		'menu_icon'           => 'dashicons-format-image',
// 	]);
// }
// add_action('init', 'register_reviews_cpt');
