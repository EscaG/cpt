<?php get_header(); ?>

<main class="font-body">
	<section id="home_introduction" class="fl-pt-[50px/100px]">
		<div class="container">
			<div class="flex flex-col md:flex-row 2xl:fl-gap-[10px/240px] md:fl-gap-[10px/100px]">
				<div class="flex-3">
					<h1 class="font-heading fl-text-[22px/55px] font-semibold fl-mb-[20px/30px]">Центр Психологічних Технологій</h1>
					<p class="fl-text-[16px/24px] fl-mb-[30px/100px]">Складне стає зрозумілим</p>
					<div class="wide-element bg-[#DDEEE8] fl-py-[16px/30px] rounded-r-full font-body fl-text-[16px/28px] fl-mb-[30px/50px]">
						<p>Психологія для професійного розвитку</p>
						<p>Психологія для бізнесу</p>
					</div>
					<div class="flex gap-4">
						<a href="<?php echo esc_url(home_url('/courses')); ?>" class="link-button green-btn">
							Наші послуги
							<span class="fl-ml-[10px/20px]" style="max-width: 30px; display: inline-block;">
								<?php echo get_inline_svg('arrow-right.svg', ' fl-w-[18px/30px] icon-in-button inline-block'); ?>
							</span>
						</a>
						<a href="<?php echo esc_url(home_url('/courses')); ?>" class="link-button white-btn">
							Зв’язатися <span class="hidden sm:inline">з нами</span>
						</a>
					</div>
				</div>
				<div class="hidden md:block flex-2">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/intro.png" alt="intro" class="w-full h-auto">
				</div>
			</div>
		</div>
	</section>
	<section id="home_about">
		<div class="container">
			<h2 class="hidden md:block font-heading fl-text-[20px/36px] font-medium fl-mb-[20px/30px] text-center">Про нас</h2>
			<div class="flex fl-gap-[4/20] flex-col-reverse md:flex-row">
				<div class="flex-1 fl-text-[16px/24px] ">
					<p class="fl-mb-[20px/30px]"><span class="font-medium">Центр Психологічних Технологій</span> – це простір, де психологія перестає бути абстрактною і стає зрозумілою, структурованою та прикладною.
						Ми навчаємо бачити психологічні процеси, працювати з ними системно та застосовувати психологічні інструменти у практиці й бізнесі.</p>
					<p>Наша робота ґрунтується на поєднанні глибини психологічних підходів і чітких технологій їх використання.</p>
				</div>
				<h2 class="md:hidden font-heading fl-text-[20px/36px] font-medium text-center">Про нас</h2>
				<div class="flex flex-1 gap-2">
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_1.png" alt="intro" class="w-full h-auto">
					</div>
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_2.png" alt="intro" class="w-full h-auto">
					</div>
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_3.png" alt="intro" class="w-full h-auto">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="home_values" class="bg-[#F1FAF7] text-center fl-py-[20px/50px]">
		<div class="container">
			<h2 class="font-heading fl-text-[20px/36px]">Наші цінності</h2>
			<ul class="flex flex-col md:flex-row md:fl-gap-[10px/80px] xl:fl-gap-[50px/130px]">
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_gear.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Знання мають працювати</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Працюємо з тими знаннями, які дають результат.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Усі методи та підходи, що ми передаємо, мають чітке функціональне призначення та реальний вплив.</p>
				</li>
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_bar.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Системний підхід</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Бачимо людину, команду й організацію як цілісну систему.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Це дозволяє знаходити причини, а не латати наслідки, і будувати рішення, які працюють довгостроково</p>
				</li>
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_up.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Розвиток</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Підтримуємо не швидкі рішення, а стійке зростання.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Розвиток як процес, що ґрунтується на усвідомленні, дисципліні та готовності змінюватися</p>
				</li>


			</ul>
		</div>
	</section>
</main>

<?php get_footer(); ?>