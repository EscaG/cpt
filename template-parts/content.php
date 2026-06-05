<?php
// Шаблон одной карточки поста в списке
?>
<article class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow flex flex-col">
    <h2 class="text-xl font-semibold mb-3">
        <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800">
            <?php the_title(); ?>
        </a>
    </h2>
    <div class="text-sm text-gray-500 mb-4">
        <?php echo get_the_date('d.m.Y'); ?>
    </div>
    <div class="prose prose-sm text-gray-600 mb-4 flex-grow">
        <?php the_excerpt(); ?>
    </div>
    <a href="<?php the_permalink(); ?>" class="inline-block mt-auto text-blue-600 font-medium hover:underline">
        Читать далее →
    </a>
</article>
