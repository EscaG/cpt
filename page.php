<?php get_header(); ?>

<main class="container mx-auto px-4 py-8 min-h-screen">
    <?php

    $page_slug = basename(get_permalink());

    get_template_part('template-parts/page', $page_slug);
    ?>
</main>

<?php get_footer(); ?>
