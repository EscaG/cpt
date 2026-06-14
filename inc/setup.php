<?php

// 1. Единая функция подключения скриптов и стилей
add_action('wp_enqueue_scripts', 'cpt_enqueue_assets');
function cpt_enqueue_assets() {
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

        add_action('wp_head', function() use ($vite_dev_url, $css_entry) {
            echo '<link rel="stylesheet" href="' . $vite_dev_url . '/' . $css_entry . '">' . "\n";
        }, 1);
    }
}


// 2. Добавляем type="module" для Vite (обязательно для ES modules)
add_filter('script_loader_tag', 'cpt_add_module_type_to_script', 10, 3);
function cpt_add_module_type_to_script($tag, $handle, $src) {
    // Применяем ко всем нашим скриптам
    if ($handle === 'cpt-script-dev' || $handle === 'cpt-script') {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}


// 3. Регистрируем меню
add_action( 'after_setup_theme', 'my_custom_theme_menus' );
function my_custom_theme_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Главное меню в шапке', 'my-theme' ),
    ) );
}

add_action( 'after_setup_theme', 'mytheme_setup' );
function mytheme_setup() {
    // Добавляем поддержку кастомного логотипа
    add_theme_support( 'custom-logo', array(
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}

add_action('wp_head', 'my_theme_add_favicon');
function my_theme_add_favicon() {
    $theme_uri = get_template_directory_uri();

    // Для современных браузеров и SVG
    echo '<link rel="icon" href="' . $theme_uri . '/assets/images/favicon.svg" type="image/svg+xml">' . "\n";
    // Фоллбэк для старых браузеров
    echo '<link rel="alternate icon" href="' . $theme_uri . '/assets/images/favicon.ico" type="image/x-icon">' . "\n";
    // Для Apple устройств (iPhone/iPad)
    echo '<link rel="apple-touch-icon" href="' . $theme_uri . '/assets/images/apple-touch-icon.png">' . "\n";
    // Для Android / PWA
    echo '<link rel="manifest" href="' . $theme_uri . '/assets/images/site.webmanifest">' . "\n";
}

// Очистка лишних атрибутов у лого
function cpt_get_clean_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );

    // Если лого не задано, выводим название сайта текстом
    if ( ! $custom_logo_id ) {
        return '<span class="site-title">' . get_bloginfo( 'name' ) . '</span>';
    }

    // Получаем URL оригинального (полноразмерного) изображения
    $image = wp_get_attachment_image_src( $custom_logo_id, 'full' );

    if ( $image ) {
        $image_url = $image[0];
        // Получаем ALT текст, если он есть, иначе используем название сайта
        $alt_text = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
        if ( ! $alt_text ) {
            $alt_text = get_bloginfo( 'name' );
        }

        // Возвращаем ЧИСТЫЙ HTML без srcset, sizes, height и style
        return sprintf(
            '<a href="%s" class="custom-logo-link" rel="home"><img src="%s" alt="%s" class="custom-logo" width="200"></a>',
            esc_url( home_url( '/' ) ),
            esc_url( $image_url ),
            esc_attr( $alt_text )
        );
    }

    return get_bloginfo( 'name' );
}

if (!function_exists('get_inline_svg')) {
    function get_inline_svg($filename, $additional_classes = '') {
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
