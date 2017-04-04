	<div class="content-main">
	<div class="see-all">
		<a href="<?php echo $all_news_link; ?>">Смотреть все новости компании <span>></span></a>
		<h5>Новости компании</h5>
	</div>

	<!-- start news block -->

	<div class="news-block">
		<ul>
		<?php $i = 0; ?>
		<?php foreach ($all_news as $news) { ?>			
		<?php $i++; ?>
		<?php  if($i >4) break; ?>
			<li>
				<img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">

				<h5><?php echo $news['title']; ?></h5>
				
				<?php echo $news['description']; ?>
				
				<p class="date">
					<?php echo $news['date_added']; ?>
					<a href="<?php echo $news['view']; ?>">Читать далее</a>
				</p>
			</li>
		<?php } ?>
		</ul>
	</div>
	</div>