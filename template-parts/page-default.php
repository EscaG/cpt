<?php
    while (have_posts()) : the_post();
?>
<article class="prose lg:prose-xl mx-auto">
    <h1 class="text-4xl font-bold mb-6"><?php the_title(); ?></h1>
    <div class="text-gray-700">
        <?php the_content(); ?>
    </div>
</article>
<?php
    endwhile;
?>
