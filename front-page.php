<?php get_header(); ?>

<main class="font-body">
	<!-- Вступ -->
	<?php get_template_part('parts/home/introduction'); ?>
	<!-- Про нас -->
	<?php get_template_part('parts/home/about'); ?>
	<!-- Наші цінності -->
	<?php get_template_part('parts/home/values'); ?>
	<!-- Переваги навчання в Центрі -->
	<?php get_template_part('parts/home/advantages'); ?>
	<!-- Календар подій -->
	<?php get_template_part('parts/home/calendar'); ?>
	<!-- Навчальні програми -->
	<?php get_template_part('parts/home/trainings'); ?>
</main>

<?php get_footer(); ?>