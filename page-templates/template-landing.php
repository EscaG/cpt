<?php
/**
 * Template Name: Лендинг без сайдбара
 * Description: Полноэкранный шаблон для промо-страниц
 */

get_header();
?>

<main class="w-full">
    <!-- Здесь ваша уникальная верстка лендинга на Tailwind -->
    <section class="bg-blue-600 text-white py-20 text-center">
        <h1 class="text-5xl font-bold">Специальное предложение!</h1>
    </section>

    <?php
    // Можно вывести контент из админки, если нужно
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
?>
