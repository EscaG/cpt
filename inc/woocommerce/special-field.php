<?php

/**
 * Регистрация кастомной таксономии "Особенности товара"
 */
add_action('init', 'register_product_features_taxonomy');
function register_product_features_taxonomy()
{

	$labels = array(
		'name'                       => 'Особливості',
		'singular_name'              => 'Особливість',
		'menu_name'                  => 'Особливість',
		'all_items'                  => 'Всі',
		'edit_item'                  => 'Редагувати особливість',
		'view_item'                  => 'Подивитись особливість',
		'update_item'                => 'Обновити особливість',
		'add_new_item'               => 'Додати нову особливість',
		'new_item_name'              => 'Назва нової особливості',
		'search_items'               => 'Шукати особливість',
		'popular_items'              => 'Популярні особливості',
		'separate_items_with_commas' => 'Поділяйте особливості комами',
		'add_or_remove_items'        => 'Додати або видалити особливості',
		'choose_from_most_used'      => 'Вибрати із часто використовуваних',
		'not_found'                  => 'Особливостей не знайдено',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false, // таксономия не имеет своих страниц
		'hierarchical'       => true, // false = как теги (без вложенности)
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		// 'show_in_rest'       => true,  // поддержка Gutenberg
		'show_tagcloud'      => false,
		'query_var'          => true,
		'rewrite'            => false, // без ЧПУ, так как публичных страниц нет
		'capabilities'       => array('manage_terms' => 'manage_categories'),
	);

	// Регистрируем таксономию и привязываем к товарам WooCommerce
	register_taxonomy('product_feature', array('product'), $args);
}
