<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); // Обязательно! Сюда WordPress вставит ваши стили из functions.php ?>
</head>
<body <?php body_class(); ?>>

 <header class="w-full bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
     <div class="container">
         <div class="flex h-16 md:h-20 items-center justify-between">
                <div class="flex">
                    <a href="<?php echo home_url(); ?>" class="text-xl font-bold">
                        <?php bloginfo('name'); ?>
                    </a>
                </div>

                <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'header-menu',      // Идентификатор, который мы задали в functions.php
                        'container'       => 'nav',              // Оборачиваем меню в тег <nav>
                        'container_class' => 'main-navigation',  // CSS-класс для тега <nav> (для стилизации)
                        'menu_class'      => 'flex items-center gap-8 w-auto',       // CSS-класс для списка <ul>
                        'fallback_cb'     => false,              // Не выводить стандартный список страниц, если меню пустое
                        'depth'           => 0,                  // 0 = неограниченная вложенность (подменю), 1 = только верхний уровень
                    ) );
                ?>

            </div>
        </div>
    </header>
