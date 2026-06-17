<?php

/**
 * ============================================================
 * 1. РЕГИСТРАЦИЯ CPT "event" (ваш существующий код)
 * ============================================================
 */
function register_event_cpt()
{
	register_post_type('event', [
		'labels' => [
			'name'          => 'Події',
			'singular_name' => 'Подія',
			'add_new'       => 'Додати нове',
			'add_new_item'  => 'Додати нову подію',
			'edit_item'     => 'Редагувати подію',
		],
		'public'      => true,
		'has_archive' => true,
		'supports'    => ['title', 'editor', 'excerpt'],
		'menu_icon'   => 'dashicons-calendar-alt',
		// 'show_in_rest' => true, // Для поддержки Gutenberg
	]);
}
add_action('init', 'register_event_cpt');

/**
 * ============================================================
 * 2. ДОБАВЛЕНИЕ КОЛОНКИ "Дата події" в список записей
 * ============================================================
 */
add_filter('manage_event_posts_columns', 'add_event_date_column');
function add_event_date_column($columns)
{
	$new_columns = [];
	foreach ($columns as $key => $value) {
		$new_columns[$key] = $value;
		if ($key === 'title') {
			$new_columns['event_date'] = 'Дата події';
		}
	}
	return $new_columns;
}

/**
 * ============================================================
 * 3. ЗАПОЛНЕНИЕ КОЛОНКИ ЗНАЧЕНИЕМ ИЗ ACF
 * ============================================================
 */
add_action('manage_event_posts_custom_column', 'populate_event_date_column', 10, 2);
function populate_event_date_column($column, $post_id)
{
	if ($column !== 'event_date') {
		return;
	}

	// ⚠️ ЗАМЕНИТЕ 'event_date' на реальное имя вашего ACF-поля
	$date_value = get_field('event_date', $post_id);

	if (!$date_value) {
		echo '<span style="color:#999;">—</span>';
		return;
	}

	// ACF Date Picker сохраняет в БД в формате 'Ymd' (например, 20260616)
	if (is_string($date_value) && strlen($date_value) === 8 && ctype_digit($date_value)) {
		$dt = DateTime::createFromFormat('Ymd', $date_value);
		echo $dt ? esc_html($dt->format('d.m.Y')) : esc_html($date_value);
	} else {
		echo esc_html($date_value);
	}
}

/**
 * ============================================================
 * 4. СОРТИРОВКА ПО КОЛОНКЕ "Дата події"
 * ============================================================
 */
add_filter('manage_edit-event_sortable_columns', 'make_event_date_sortable');
function make_event_date_sortable($columns)
{
	$columns['event_date'] = 'event_date_sort';
	return $columns;
}

add_action('pre_get_posts', 'sort_event_date_column_query');
function sort_event_date_column_query($query)
{
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	if ($query->get('orderby') === 'event_date_sort') {
		// ⚠️ ЗАМЕНИТЕ 'event_date' на реальное имя вашего ACF-поля
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value');
	}
}

/**
 * ============================================================
 * 5. ФИЛЬТР ПО ДИАПАЗОНУ ДАТ (два инпута "від" і "до")
 * ============================================================
 */
add_action('restrict_manage_posts', 'render_event_date_filter');
function render_event_date_filter($post_type)
{
	if ($post_type !== 'event') {
		return;
	}

	$from = isset($_GET['event_date_from']) ? sanitize_text_field($_GET['event_date_from']) : '';
	$to   = isset($_GET['event_date_to']) ? sanitize_text_field($_GET['event_date_to']) : '';
?>
	<label style="margin-left:10px;">
		Дата з:
		<input type="date" name="event_date_from" value="<?= esc_attr($from) ?>" style="vertical-align:middle;">
	</label>
	<label>
		по:
		<input type="date" name="event_date_to" value="<?= esc_attr($to) ?>" style="vertical-align:middle;">
	</label>
<?php
}

add_action('parse_query', 'filter_events_by_date_range');
function filter_events_by_date_range($query)
{
	global $pagenow;

	if (!is_admin() || $pagenow !== 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'event') {
		return;
	}

	$meta_query = [];

	// ⚠️ ЗАМЕНИТЕ 'event_date' на реальное имя вашего ACF-поля
	$meta_key = 'event_date';

	if (!empty($_GET['event_date_from'])) {
		// Приводим дату из формата YYYY-MM-DD (из HTML date input) к формату ACF Ymd
		$from_dt = DateTime::createFromFormat('Y-m-d', sanitize_text_field($_GET['event_date_from']));
		if ($from_dt) {
			$meta_query[] = [
				'key'     => $meta_key,
				'value'   => $from_dt->format('Ymd'),
				'compare' => '>=',
			];
		}
	}

	if (!empty($_GET['event_date_to'])) {
		$to_dt = DateTime::createFromFormat('Y-m-d', sanitize_text_field($_GET['event_date_to']));
		if ($to_dt) {
			$meta_query[] = [
				'key'     => $meta_key,
				'value'   => $to_dt->format('Ymd'),
				'compare' => '<=',
			];
		}
	}

	if (!empty($meta_query)) {
		$meta_query['relation'] = 'AND';
		$query->set('meta_query', $meta_query);
		$query->set('orderby', 'meta_value');
		$query->set('meta_key', $meta_key);
		$query->set('order', 'ASC');
	}
}

/**
 * ============================================================
 * 6. ВЫПАДАЮЩИЙ СПИСОК МЕСЯЦЕВ ПО ДАТЕ СОБЫТИЯ (ACF)
 * ============================================================
 */
add_action('restrict_manage_posts', 'render_event_month_filter');
function render_event_month_filter($post_type)
{
	if ($post_type !== 'event') {
		return;
	}

	global $wpdb;

	// ⚠️ ЗАМЕНИТЕ 'event_date' на реальное имя вашего ACF-поля
	$meta_key = 'event_date';

	// Получаем все уникальные даты из ACF-поля для этого CPT
	$dates = $wpdb->get_col($wpdb->prepare(
		"SELECT DISTINCT pm.meta_value 
         FROM {$wpdb->postmeta} pm
         INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
         WHERE pm.meta_key = %s 
         AND p.post_type = 'event' 
         AND p.post_status = 'publish'
         AND pm.meta_value != ''
         ORDER BY pm.meta_value DESC",
		$meta_key
	));

	if (empty($dates)) {
		return;
	}

	// Группируем по месяцам
	$months = [];
	foreach ($dates as $date) {
		// ACF хранит дату в формате Ymd (20260616)
		if (strlen($date) === 8 && ctype_digit($date)) {
			$year = substr($date, 0, 4);
			$month = substr($date, 4, 2);
			$key = $year . '-' . $month;
			if (!isset($months[$key])) {
				$months[$key] = [
					'year' => $year,
					'month' => $month,
				];
			}
		}
	}

	// Сортируем по убыванию (новые сверху)
	krsort($months);

	$selected = isset($_GET['event_month']) ? sanitize_text_field($_GET['event_month']) : '';

?>
	<select name="event_month" style="vertical-align:middle;">
		<option value="">Всі місяці</option>
		<?php foreach ($months as $key => $data): ?>
			<?php
			$month_names = [
				'01' => 'Січень',
				'02' => 'Лютий',
				'03' => 'Березень',
				'04' => 'Квітень',
				'05' => 'Травень',
				'06' => 'Червень',
				'07' => 'Липень',
				'08' => 'Серпень',
				'09' => 'Вересень',
				'10' => 'Жовтень',
				'11' => 'Листопад',
				'12' => 'Грудень',
			];
			$month_name = $month_names[$data['month']] ?? $data['month'];
			$label = $month_name . ' ' . $data['year'];
			?>
			<option value="<?= esc_attr($key) ?>" <?= selected($selected, $key, false) ?>>
				<?= esc_html($label) ?>
			</option>
		<?php endforeach; ?>
	</select>
<?php
}

/**
 * ============================================================
 * 7. ПРИМЕНЕНИЕ ФИЛЬТРА ПО ВЫБРАННОМУ МЕСЯЦУ
 * ============================================================
 */
add_action('parse_query', 'filter_events_by_month');
function filter_events_by_month($query)
{
	global $pagenow;

	if (!is_admin() || $pagenow !== 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'event') {
		return;
	}

	if (empty($_GET['event_month'])) {
		return;
	}

	$selected_month = sanitize_text_field($_GET['event_month']); // формат: YYYY-MM

	if (!preg_match('/^\d{4}-\d{2}$/', $selected_month)) {
		return;
	}

	list($year, $month) = explode('-', $selected_month);

	// Формируем диапазон дат для выбранного месяца
	$start_date = $year . $month . '01'; // начало месяца
	$end_date = $year . $month . '31';   // конец месяца (31 достаточно, MySQL сам обрежет)

	// ⚠️ ЗАМЕНИТЕ 'event_date' на реальное имя вашего ACF-поля
	$meta_key = 'event_date';

	$meta_query = [
		[
			'key'     => $meta_key,
			'value'   => [$start_date, $end_date],
			'compare' => 'BETWEEN',
			'type'    => 'CHAR',
		],
	];

	$query->set('meta_query', $meta_query);
	$query->set('meta_key', $meta_key);
	$query->set('orderby', 'meta_value');
	$query->set('order', 'ASC');
}
