<?php

// 1. Единая функция подключения скриптов и стилей
function psc_enqueue_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
    $entry_point = 'src/main.js';

    if (file_exists($manifest_path)) {
        // --- РЕЖИМ ПРОДАКШЕНА (после npm run build) ---
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest[$entry_point])) {
            // Подключаем JS
            wp_enqueue_script(
                'psc-script',
                $theme_uri . '/dist/' . $manifest[$entry_point]['file'],
                array(),
                wp_get_theme()->get('Version'),
                true
            );

            // Подключаем CSS (если он сгенерировался для этого entry)
            if (isset($manifest[$entry_point]['css'])) {
                wp_enqueue_style(
                    'psc-style',
                    $theme_uri . '/dist/' . $manifest[$entry_point]['css'][0],
                    array(),
                    wp_get_theme()->get('Version')
                );
            }
        }
    } else {
        // --- РЕЖИМ РАЗРАБОТКИ (запущен npm run dev) ---
        $vite_dev_url = 'http://psychological-support-center.local:5173';

        wp_enqueue_script('psc-script-dev', $vite_dev_url . '/src/main.js', array(), null, true);
        add_action('wp_head', function() use ($vite_dev_url, $entry_point) {
            echo '<link rel="stylesheet" href="' . $vite_dev_url . '/' . str_replace('.js', '.css', $entry_point) . '">' . "\n";
        }, 1); // Приоритет 1 = максимально рано в <head>
    }
}
add_action('wp_enqueue_scripts', 'psc_enqueue_assets');

// 2. Добавляем type="module" для Vite (обязательно для ES modules)
function psc_add_module_type_to_script($tag, $handle, $src) {
    // Применяем ко всем нашим скриптам
    if ($handle === 'psc-script-dev' || $handle === 'psc-script') {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'psc_add_module_type_to_script', 10, 3);

// 3. Регистрируем меню
add_action( 'after_setup_theme', 'my_custom_theme_menus' );
function my_custom_theme_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Главное меню в шапке', 'my-theme' ),
    ) );
}
