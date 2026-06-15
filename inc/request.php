<?php

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
		'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'), // title = заголовок, editor = описание, thumbnail = картинка
		'menu_icon'           => 'dashicons-admin-users',
		'rewrite'             => array('slug' => 'advantages'),
	);

	register_post_type('advantage', $args);
}
add_action('init', 'advantages_of_studying');
