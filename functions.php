<?php

// 1. Единая функция подключения скриптов и стилей
function psc_enqueue_assets() {
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
                'psc-script',
                $theme_uri . '/dist/' . $manifest[$js_entry]['file'],
                array(),
                wp_get_theme()->get('Version'),
                true
            );
        }

        // CSS (отдельный entry)
        if (isset($manifest[$css_entry])) {
            wp_enqueue_style(
                'psc-style',
                $theme_uri . '/dist/' . $manifest[$css_entry]['file'],
                array(),
                wp_get_theme()->get('Version')
            );
        }
    } else {
        // --- РЕЖИМ РАЗРАБОТКИ ---
        $vite_dev_url = 'http://192.168.0.125:5173';

        wp_enqueue_script('psc-script-dev', $vite_dev_url . '/' . $js_entry, array(), null, true);

        add_action('wp_head', function() use ($vite_dev_url, $css_entry) {
            echo '<link rel="stylesheet" href="' . $vite_dev_url . '/' . $css_entry . '">' . "\n";
        }, 1);
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

function mytheme_setup() {
    // Добавляем поддержку кастомного логотипа
    add_theme_support( 'custom-logo', array(
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'mytheme_setup' );

// add_filter( 'get_custom_logo', 'psc_clean_logo_attributes', 20 );
//
// function psc_clean_logo_attributes( $html ) {
//     // Регулярное выражение удаляет атрибуты width, height и style из тега img
//     $html = preg_replace( '/\s+(width|height|style|srcset|sizes)="[^"]*"/', '', $html );
//     return $html;
// }

function psc_get_clean_logo() {
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
