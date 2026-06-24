<?php

/**
 * Компонент: кнопка «Назад»
 *
 * Ожидаемые переменные (передаются через $args):
 *  - $label    string  Текст кнопки (по умолчанию: 'Назад')
 *  - $fallback string  URL, если реферера нет (по умолчанию: главная)
 *  - $js_back  bool    Если true — при отсутствии реферера используется history.back()
 */

$label    = $args['label']    ?? 'Назад';
$fallback = $args['fallback'] ?? '';
$js_back  = $args['js_back']  ?? false;

$referer = wp_get_referer();
if (! $referer) {
	$url = $js_back ? 'javascript:history.back()' : ($fallback ?: home_url('/'));
} else {
	$url = $referer;
}
?>

<a
	href="<?php echo esc_url($url); ?>"
	class="group inline-flex items-center gap-2 rounded-xl px-2 py-2.5 text-sm font-medium  "
	aria-label="<?php echo esc_attr($label); ?>">
	<svg
		width=16 height=16
		xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
		stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
		class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1"
		aria-hidden="true">
		<path d="M19 12H5" />
		<path d="M12 19l-7-7 7-7" />
	</svg>
	<span><?php echo esc_html($label); ?></span>
</a>