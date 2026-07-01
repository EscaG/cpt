<?php ?>

<section id="home_values" class="bg-[#F1FAF7] text-center fl-py-[20px/50px]">
	<div class="container">
		<?php get_template_part('template-parts/ui/section-title', null, [
			'label' => 'Наші цінності',
			'weight' => 'font-regular',
		]); ?>
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