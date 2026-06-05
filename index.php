<?php get_header(); ?>

<main class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8"><?php is_home() ? 'Блог' : 'Архив'; ?></h1>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <!-- Подключаем нашу карточку -->
                <?php get_template_part('template-parts/content', get_post_format()); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p>Ничего не найдено.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
