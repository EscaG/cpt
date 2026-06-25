<?php ?>

<section class="home_introduction">
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