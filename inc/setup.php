<?php

// 1. Единая функция подключения скриптов и стилей
add_action('wp_enqueue_scripts', 'cpt_enqueue_assets');
function cpt_enqueue_assets()
{
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();
	$manifest_path = $theme_dir . '/dist/.vite/manifest.json';
	$js_entry  = 'src/assets/js/main.js';
	$css_entry = 'src/assets/css/app.css';

	if (file_exists($manifest_path)) {
		// --- РЕЖИМ ПРОДАКШЕНА ---
		$manifest = json_decode(file_get_contents($manifest_path), true);

		// JS
		if (isset($manifest[$js_entry])) {
			wp_enqueue_script(
				'cpt-script',
				$theme_uri . '/dist/' . $manifest[$js_entry]['file'],
				array(),
				wp_get_theme()->get('Version'),
				true
			);
		}

		// CSS (отдельный entry)
		if (isset($manifest[$css_entry])) {
			wp_enqueue_style(
				'cpt-style',
				$theme_uri . '/dist/' . $manifest[$css_entry]['file'],
				array(),
				wp_get_theme()->get('Version')
			);
		}
	} else {
		// --- РЕЖИМ РАЗРАБОТКИ ---
		$vite_dev_url = 'http://192.168.0.125:5173';

		wp_enqueue_script('cpt-script-dev', $vite_dev_url . '/' . $js_entry, array(), null, true);

		add_action('wp_head', function () use ($vite_dev_url, $css_entry) {
			echo '<link rel="stylesheet" href="' . $vite_dev_url . '/' . $css_entry . '">' . "\n";
		}, 1);
	}
}

// 2. Добавляем type="module" для Vite (обязательно для ES modules)
add_filter('script_loader_tag', 'cpt_add_module_type_to_script', 10, 3);
function cpt_add_module_type_to_script($tag, $handle, $src)
{
	// Применяем ко всем нашим скриптам
	if ($handle === 'cpt-script-dev' || $handle === 'cpt-script') {
		$tag = '<script type="module" src="' . esc_url($src) . '"></script>';
	}
	return $tag;
}

// 3. Регистрируем меню
add_action('after_setup_theme', 'my_custom_theme_menus');
function my_custom_theme_menus()
{
	register_nav_menus(array(
		'header-menu' => __('Главное меню в шапке', 'my-theme'),
	));
}

add_action('after_setup_theme', 'mytheme_setup');
function mytheme_setup()
{
	// Добавляем поддержку кастомного логотипа
	add_theme_support('custom-logo', array(
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array('site-title', 'site-description'),
	));
}

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup()
{
	// Включаем поддержку главных изображений (Featured Images)
	add_theme_support('post-thumbnails');

	// Опционально: указываем, для каких типов записей включаем
	// add_theme_support('post-thumbnails', array('post', 'page', 'advantage'));
}
