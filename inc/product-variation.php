<?php

add_filter('manage_product_posts_columns', 'custom_remove_product_columns', 999);

function custom_remove_product_columns($columns)
{
	// Удаляем ненужные колонки с помощью unset()
	// Раскомментируйте (уберите //) те строки, которые хотите скрыть:

	// unset( $columns['thumb'] );        // Изображение товара
	// unset( $columns['name'] );         // Название товара (лучше не трогать)
	unset($columns['sku']);          // Артикул (SKU)
	unset($columns['is_in_stock']);
	// unset($columns['price']);        // Цена
	// unset($columns['product_cat']);  // Категории
	unset($columns['product_tag']);  // Метки (Теги)
	unset($columns['featured']);     // В избранном (звездочка)
	// unset($columns['product_type']); // Тип товара (простой, вариативный и т.д.)
	// unset($columns['comments']);     // Отзывы / Комментарии
	// unset( $columns['date'] );      // Дата публикации
	unset($columns['taxonomy_product_brand']);

	return $columns;
}

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


// Добавляем поле "Длительность доступа" в админку вариации
add_action('woocommerce_variation_options_pricing', 'add_duration_field_to_variation', 10, 3);
function add_duration_field_to_variation($loop, $variation_data, $variation)
{
	woocommerce_wp_text_input(
		array(
			'id'            => "variable_access_duration{$loop}",
			'name'          => "variable_access_duration[{$loop}]",
			'value'         => get_post_meta($variation->ID, '_access_duration_days', true),
			'label'         => __('Тривалість доступу (дні)', 'woocommerce'),
			'desc_tip'      => 'true',
			'description'   => __('Вкажіть кількість днів доступу (наприклад, 30 або 150). Залишіть пустим для довічного доступу.', 'woocommerce'),
			'type'          => 'number',
			'custom_attributes' => array(
				'step' => '1',
				'min'  => '1'
			)
		)
	);
}

// Сохраняем поле при сохранении вариации
add_action('woocommerce_save_product_variation', 'save_duration_field_in_variation', 10, 2);
function save_duration_field_in_variation($variation_id, $i)
{
	if (isset($_POST['variable_access_duration'][$i])) {
		$value = absint($_POST['variable_access_duration'][$i]);
		update_post_meta($variation_id, '_access_duration_days', $value);
	}
}

// ============================================
// 1. Добавляем чекбокс "Это курс" в админку товара
// ============================================
add_action('woocommerce_product_options_general_product_data', 'add_is_course_checkbox');
function add_is_course_checkbox()
{
	woocommerce_wp_checkbox(
		array(
			'id' => '_is_course',
			'label' => __('Курс з варіантами доступу', 'woocommerce'),
			'description' => __('Автоматично створити варіації: 1 місяць та Повний курс', 'woocommerce')
		)
	);
}

// ============================================
// 2. Сохраняем чекбокс и создаем вариации
// ============================================
add_action('woocommerce_process_product_meta', 'save_is_course_checkbox_and_create_variations');
function save_is_course_checkbox_and_create_variations($post_id)
{
	// Сохраняем чекбокс
	$is_course = isset($_POST['_is_course']) ? 'yes' : 'no';
	update_post_meta($post_id, '_is_course', $is_course);

	// Автоматически активируем "Виртуальный" товар
	update_post_meta($post_id, '_virtual', 'yes');

	// Если чекбокс отмечен - создаем вариации
	if ($is_course === 'yes') {
		// Проверяем, есть ли уже вариации
		$product = wc_get_product($post_id);
		if ($product && $product->is_type('variable')) {
			$existing_variations = $product->get_children();
			if (!empty($existing_variations)) {
				return; // Вариации уже есть
			}
		}

		// Создаем вариации
		create_course_variations($post_id);

		// ПРИНУДИТЕЛЬНАЯ перезагрузка страницы товара
		// Это имитирует поведение при ошибке - страница перезагружается
		// и WooCommerce заново загружает товар с вариациями
		wp_redirect(admin_url('post.php?post=' . $post_id . '&action=edit&course_variations_created=1'));
		exit;
	}
}

// ============================================
// 3. Показываем уведомление об успешном создании
// ============================================
add_action('admin_notices', 'show_course_variations_notice');
function show_course_variations_notice()
{
	if (isset($_GET['course_variations_created']) && get_post_type($_GET['post']) === 'product') {
		echo '<div class="notice notice-success is-dismissible"><p>Вариации курса успешно созданы!</p></div>';
	}
}

// ============================================
// 4. Функция создания вариаций для курса
// ============================================
function create_course_variations($post_id)
{
	// Устанавливаем тип товара "Вариативный"
	wp_set_object_terms($post_id, 'variable', 'product_type');

	// Слаг вашего атрибута (с подчёркиванием!)
	$attribute_slug = 'access-type';
	$attribute_taxonomy = 'pa_' . $attribute_slug;
	$attribute_label = 'Тип доступу';

	// Создаем атрибут если его нет
	if (!taxonomy_exists($attribute_taxonomy)) {
		// Регистрируем таксономию
		register_taxonomy(
			$attribute_taxonomy,
			array('product'),
			array(
				'hierarchical' => false,
				'show_ui' => false,
				'query_var' => true,
				'rewrite' => false,
			)
		);

		// Регистрируем атрибут в WooCommerce
		global $wpdb;
		$wpdb->insert(
			$wpdb->prefix . 'woocommerce_attribute_taxonomies',
			array(
				'attribute_name' => $attribute_slug,
				'attribute_label' => $attribute_label,
				'attribute_type' => 'select',
				'attribute_orderby' => 'menu_order',
				'attribute_public' => 0
			)
		);

		// Очищаем кэш атрибутов
		delete_transient('wc_attribute_taxonomies');
	}

	// ВАЖНО: Укажите ваши слаги значений, которые вы создали вручную
	// Формат: 'название_в_админке' => 'слаг_термина'
	$variation_data = array(
		array(
			'label' => '1 місяць',              // Название для отображения
			'slug' => 'one_month',               // ← ВАШ СЛАГ для "1 месяц"
			'duration' => 30,
			'price' => ''
		),
		array(
			'label' => 'Повний курс',
			'slug' => 'full_course',           // ← ВАШ СЛАГ для "Полный курс"
			'duration' => '',
			'price' => ''
		)
	);

	// Создаем термины если их нет и получаем ID
	$term_ids = array();
	foreach ($variation_data as $data) {
		$term = get_term_by('slug', $data['slug'], $attribute_taxonomy);

		if (!$term) {
			// Создаем термин если его нет
			$new_term = wp_insert_term(
				$data['label'],
				$attribute_taxonomy,
				array('slug' => $data['slug'])
			);

			if (!is_wp_error($new_term)) {
				$term_ids[] = $new_term['term_id'];
			}
		} else {
			$term_ids[] = $term->term_id;
		}
	}

	if (empty($term_ids)) {
		error_log('Не удалось создать или получить термины для атрибута ' . $attribute_taxonomy);
		return;
	}

	// Привязываем значения атрибута к товару
	wp_set_object_terms($post_id, $term_ids, $attribute_taxonomy);

	// Привязываем атрибут к товару
	$product_attributes = array();
	$product_attributes[$attribute_taxonomy] = array(
		'name' => $attribute_taxonomy,
		'value' => '',
		'position' => 0,
		'is_visible' => 1,
		'is_variation' => 1,
		'is_taxonomy' => 1
	);
	update_post_meta($post_id, '_product_attributes', $product_attributes);

	// Создаем вариации
	foreach ($variation_data as $index => $data) {
		$variation_id = wp_insert_post(array(
			'post_title' => 'Variation #' . ($index + 1) . ' of ' . $post_id,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
			'post_type' => 'product_variation',
			'post_parent' => $post_id,
			'menu_order' => $index
		));

		if ($variation_id && !is_wp_error($variation_id)) {
			// ВАЖНО: используем именно слаг термина!
			update_post_meta($variation_id, 'attribute_' . $attribute_taxonomy, $data['slug']);
			update_post_meta($variation_id, '_access_duration_days', $data['duration']);

			if (!empty($data['price'])) {
				update_post_meta($variation_id, '_price', $data['price']);
				update_post_meta($variation_id, '_regular_price', $data['price']);
			}

			update_post_meta($variation_id, '_status', 'publish');
			update_post_meta($variation_id, '_virtual', 'yes');
		}
	}

	wc_delete_product_transients($post_id);
}
