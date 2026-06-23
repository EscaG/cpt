<?php

// Очистка лишних атрибутов у лого
function cpt_get_clean_logo()
{
	$custom_logo_id = get_theme_mod('custom_logo');

	// Если лого не задано, выводим название сайта текстом
	if (! $custom_logo_id) {
		return '<span class="site-title">' . get_bloginfo('name') . '</span>';
	}

	// Получаем URL оригинального (полноразмерного) изображения
	$image = wp_get_attachment_image_src($custom_logo_id, 'full');

	if ($image) {
		$image_url = $image[0];
		// Получаем ALT текст, если он есть, иначе используем название сайта
		$alt_text = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
		if (! $alt_text) {
			$alt_text = get_bloginfo('name');
		}

		// Возвращаем ЧИСТЫЙ HTML без srcset, sizes, height и style
		return sprintf(
			'<a href="%s" class="custom-logo-link" rel="home"><img src="%s" alt="%s" class="custom-logo" width="200"></a>',
			esc_url(home_url('/')),
			esc_url($image_url),
			esc_attr($alt_text)
		);
	}

	return get_bloginfo('name');
}

if (!function_exists('get_inline_svg')) {
	function get_inline_svg($filename, $additional_classes = '')
	{
		$theme_dir = get_template_directory();

		// 1. Сначала ищем в dist (для продакшена после npm run build)
		$path_dist = $theme_dir . '/dist/assets/img/icons/' . $filename;

		// 2. Если нет, ищем в public (для локальной разработки в LocalWP)
		$path_public = $theme_dir . '/assets/img/icons/' . $filename;

		$path = file_exists($path_dist) ? $path_dist : $path_public;

		if (file_exists($path)) {
			$svg = file_get_contents($path);

			// Удаляем жесткие width/height для управления через Tailwind (w-6 h-6)
			$svg = preg_replace('/(<svg[^>]*?)\s+width="[^"]*"\s+height="[^"]*"/', '$1', $svg);

			// Добавляем базовые классы. fill-current позволяет менять цвет через text-*
			$svg = preg_replace(
				'/<svg/',
				'<svg class="' . esc_attr($additional_classes) . '"',
				$svg,
				1
			);

			return $svg;
		}

		// Отладка
		return '<!-- SVG not found: ' . esc_html($filename) . ' -->';
	}
}

// add_action('wp_head', 'my_theme_add_favicon');
// function my_theme_add_favicon() {
//     $theme_uri = get_template_directory_uri();
//
//     // Для современных браузеров и SVG
//     echo '<link rel="icon" href="' . $theme_uri . '/assets/images/favicon.svg" type="image/svg+xml">' . "\n";
//     // Фоллбэк для старых браузеров
//     echo '<link rel="alternate icon" href="' . $theme_uri . '/assets/images/favicon.ico" type="image/x-icon">' . "\n";
//     // Для Apple устройств (iPhone/iPad)
//     echo '<link rel="apple-touch-icon" href="' . $theme_uri . '/assets/images/apple-touch-icon.png">' . "\n";
//     // Для Android / PWA
//     echo '<link rel="manifest" href="' . $theme_uri . '/assets/images/site.webmanifest">' . "\n";
// }
