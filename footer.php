    <footer class="bg-[#F1FAF7] mt-8 font-body">
    	<div class="container">
    		<div class="flex flex-col md:flex-row py-7.5">
    			<!-- ЛОГО -->
    			<div class="flex flex-col flex-1 max-md:items-center mb-6">


    				<div class="mb-5" style="max-width: 200px; min-width: 50px;">
    					<?php
							if (has_custom_logo()) {
								echo cpt_get_clean_logo();
							} else {
								echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
							}
							?>
    				</div>
    				<p class="fl-text-[18px/24px] ">Складне стає зрозумілим</p>

    			</div>
    			<div class="flex flex-1 gap-4">
    				<div class="flex flex-1">
    					<?php
							wp_nav_menu(array(
								'theme_location'  => 'header-menu',
								'container'       => 'nav',
								'container_class' => 'footer-menu',
								'menu_class'      => 'flex flex-col',
								'fallback_cb'     => false,
								'depth'           => 0,
							));
							?>
    				</div>
    				<div class="flex-1">
    					<div class="mb-5">
    						<a class="fl-text-[16px/20px] py-1 inline-block" href="tel:+380996633214">+380996633214</a>
    						<a class="fl-text-[16px/20px] py-1 inline-block break-words" href="mailto:center.psychology.teh@gmail.com" >center.psychology.teh@gmail.com</a>
    					</div>
    					<ul class="flex gap-6">
    						<li style="max-width: 50px;">
    							<a target="_blank" href="https://www.instagram.com/center_forpsychology?igsh=aWh0Z3Jtcmd1amp3">
    								<?php echo get_inline_svg('instagram.svg', 'fl-w-[32px/50px]'); ?>
    							</a>
    						</li>
    						<li style="max-width: 50px;">
    							<a target="_blank" href="https://t.me/center_for_psychology">
    								<?php echo get_inline_svg('social.svg', 'fl-w-[32px/50px]'); ?>
    							</a>
    						</li>
    						<li style="max-width: 50px;">
    							<a target="_blank" href="https://www.youtube.com/@%D0%A6%D0%B5%D0%BD%D1%82%D1%80%D0%9F%D1%81%D0%B8%D1%85%D0%BE%D0%BB%D0%BE%D0%B3%D1%96%D1%87%D0%BD%D0%B8%D1%85%D0%A2%D0%B5%D1%85%D0%BD%D0%BE%D0%BB%D0%BE%D0%B3%D1%96%D0%B9">
    								<?php echo get_inline_svg('youtube.svg', 'fl-w-[32px/50px]'); ?>
    							</a>
    						</li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="rights border-t border-[#DDEEE8] py-5">
    		<p class="text-center">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    	</div>
    </footer>

    <?php wp_footer(); // Обязательно! Сюда WordPress вставит ваши скрипты из functions.php
		?>
    </body>

    </html>
