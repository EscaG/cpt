<?php
// inc/woocommerce/loader.php

// 1. Защита от прямого доступа (ОБЯЗАТЕЛЬНО!)
defined('ABSPATH') || exit;

// 2. Подключаем наши файлы
// __DIR__ - это магическая константа PHP, она означает "текущая папка файла"
require_once __DIR__ . '/admin-product-columns.php';
require_once __DIR__ . '/product-variations.php';
require_once __DIR__ . '/custom-product-fields.php';
