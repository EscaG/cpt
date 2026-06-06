<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); // Обязательно! Сюда WordPress вставит ваши стили из functions.php ?>
</head>
<body <?php body_class(); ?>>

 <header class="w-full bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50  py-2">
     <div class="container">
         <div class="flex gap-2 h-16 md:h-20 items-center justify-between">
                <div style="max-width: 200px; min-width: 50px;">
                   <?php
                      if ( has_custom_logo() ) {
                         echo psc_get_clean_logo();
                      } else {
                          echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
                      }
                   ?>

                </div>

                <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'header-menu',      // Идентификатор, который мы задали в functions.php
                        'container'       => 'nav',              // Оборачиваем меню в тег <nav>
                        'container_class' => 'animated-nav',  // CSS-класс для тега <nav> (для стилизации)
                        'menu_class'      => 'flex items-center fl-gap-2/4 text-2xl',       // CSS-класс для списка <ul>
                        'fallback_cb'     => false,              // Не выводить стандартный список страниц, если меню пустое
                        'depth'           => 0,                  // 0 = неограниченная вложенность (подменю), 1 = только верхний уровень
                    ) );
                ?>

            </div>
        </div>
    </header>
