<?php get_header(); ?>

<main class="site-main pt-8 md:pt-16 pb-20">
	<!-- Вступ -->
	<?php get_template_part('template-parts/front-page/introduction'); ?>
	<!-- Про нас -->
	<?php get_template_part('template-parts/front-page/about'); ?>
	<!-- Наші цінності -->
	<?php get_template_part('template-parts/front-page/values'); ?>
	<!-- Переваги навчання в Центрі -->
	<?php get_template_part('template-parts/front-page/advantages'); ?>
	<!-- Календар подій -->
	<?php get_template_part('template-parts/front-page/calendar'); ?>
	<!-- Навчальні програми -->
	<?php get_template_part('template-parts/front-page/trainings'); ?>
	<!-- Відгуки -->
	<?php get_template_part('template-parts/front-page/reviews'); ?>
</main>

<?php get_footer(); ?>