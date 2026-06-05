<?php
/**
 * Шаблон страницы 404 (Страница не найдена)
 */

get_header();
?>

<main>
    <div class="text-center" style="padding:50px;">

        <!-- Иконка в жестком контейнере -->
        <div class="mb-6 flex items-center justify-center w-50 h-50 mx-auto bg-amber-100 rounded-full flex-shrink-0">
            <svg class="w-50 h-50 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 96px; height: 96px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h1 class="text-7xl md:text-8xl font-black text-gray-900 tracking-tighter leading-none mb-4">404</h1>
        <h2 class="text-xl font-bold text-gray-800 mb-2">Страница не найдена</h2>
        <p class="text-gray-500 mb-8 max-w-sm mx-auto">
            Возможно, она была удалена или вы ввели неверный адрес.
        </p>

        <!-- Кнопка с инлайн-стилями для SVG на всякий случай -->
        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="flex items-center gap-6 justify-center px-6 py-3 text-sm font-semibold bg-gray-900 rounded-lg shadow-md hover:bg-gray-800 transition-all duration-200 no-underline">

            <svg class="flex-shrink-0 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; min-width: 16px; min-height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>

            <span>Вернуться на главную</span>
        </a>

    </div>
</main>

<?php
get_footer();
?>
