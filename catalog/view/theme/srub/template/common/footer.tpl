  <!-- start footer -->

    <footer>
        <div class="footer-wrapper">
            <a class="to-top" href="#" onclick="return up()">^</a>

            <ul class="top-line-menu">
                <!--<li><a href="<?php echo $about_company; ?>">О компании</a></li>
                <li><a href="<?php echo $operating_procedure; ?>">Порядок работы</a></li>
                <li><a href="<?php echo $important_to_know; ?>">Важно знать!</a></li>
                <li><a href="<?php echo $gallery; ?>">Галерея работ</a></li>
                <li><a href="<?php echo $ads; ?>">Объявления</a></li>
                <li><a href="<?php echo $news; ?>">Новости компании</a></li>
                <li><a href="<?php echo $our_price; ?>">Наши цены</a></li>
                <li><a href="<?php echo $contact; ?>">Контакты</a></li>-->
				
				<li><a href="<?php echo $about_company; ?>">О компании</a></li>
                <li><a href="<?php echo $operating_procedure; ?>">Порядок работы</a></li>
                <li><a href="<?php echo $important_to_know; ?>">Важно знать!</a></li>
                <li><a href="<?php echo $ads; ?>">Объявления</a></li>
                <li><a href="<?php echo $news; ?>">Новости</a></li>
                <li><a href="<?php echo $contact; ?>">Контакты</a></li>
				<li><a href="<?php echo $gallery; ?>">Галерея</a></li>
				<li><a href="<?php echo $project_srub; ?>">Проекты</a></li>
				<li><a href="<?php echo $our_price; ?>">Цены</a></li>

                <li id="search_footer" class="box-search">
					<input type="search" name="search" value="<?php echo $search; ?>" placeholder="Поиск">
					<input type="submit" value="">
                </li>
<script>
	/* Search */
	$('#search_footer input[name=\'search\']').parent().find('input[type=\'submit\']').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('header input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search_footer input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('header input[name=\'search\']').parent().find('input[type=\'submit\']').trigger('click');
		}
	});
</script>	
            </ul>

            <div class="footer-first-column">
                <!--<ul class="middle-line-menu">
                    <li><a href="">проекты<br>срубов</a></li>
                    <li><a href="">каркасное строительство<br>деревянных домов</a></li>
                </ul>-->

                <a href="kubansrub.ru">
                    <img class="logo-in-footer" src="catalog/view/theme/srub/images/logo-in-footer.png" alt="">
                </a>

                <p>Головное представительство</p>

                <p>ООО “КУБАНЬСТРОЙДОМ”</p>

                <p>kubansrub.ru</p>
            </div>

            <div class="footer-second-column">
                <!--<ul class="middle-line-menu">
                    <li><a href="">срубы из оцилиндрованного<br>бревна</a></li>
                    <li><a href="">отделочные пиломатериалы<br>Камерной сушки</a></li>
                </ul>-->

                <p>Социальные сети:</p>

                <ul class="socials-in-footer">
                    <li><a href="http://vk.com/srubkrym"><img src="catalog/view/theme/srub/images/vk.jpg" alt=""></a></li>
                    <li><a href="https://www.facebook.com/srubkrym"><img src="catalog/view/theme/srub/images/fb.jpg" alt=""></a></li>
                    <li><a href="https://twitter.com/srubkrym"><img src="catalog/view/theme/srub/images/tw.jpg" alt=""></a></li>
                    <li><a href="http://www.ok.ru/srubkrym"><img src="catalog/view/theme/srub/images/odn.jpg" alt=""></a></li>
                </ul>
            </div>

            <div class="footer-third-column">
                <!--<ul class="middle-line-menu">
                    <li><a href="">срубы из клеенного и<br>профилированного бруса</a></li>
                    <li><a href="<?php echo $partners; ?>">Наши<br>Партнеры</a></li>
                </ul>-->

                <p><?php echo $adress; ?></p>
            </div>

            <div class="footer-fourth-column">
                <!--<ul class="middle-line-menu">
                    <li><a href="">дикий сруб<br>ручной рубки</a></li>
                    <li><a href="<?php echo $ads; ?>">Объявления</a></li>
                </ul>-->

                <p class="phone"><?php echo $phone; ?></p>

                <p>skype: <?php echo $skype; ?></p>

                <p>email: <?php echo $email; ?></p>
            </div>
        </div>

        <div class="copy-line">
            <div class="wrapper">
                <a href="http://mkvadrat.com/">Сайт разработан в <img src="catalog/view/theme/srub/images/m2-logo.jpg" alt=""></a>

                <p>Сруб Крым, все права защищены Copyright © 2007-2016</p>
            </div>
        </div>
    </footer>
</body>
</html>