   <div class="content-main">

   <div class="see-all">

		<a href="<?php echo $all_gallery; ?>">Смотреть все работы в галерее <span>></span></a>

		<h5>Галерея работ</h5>

	</div>



	<!-- start second 3d-slider -->

	<section id="dg-container2" class="dg-container">

		<div class="dg-wrapper">

		<?php foreach ($albums as $album) { ?>

			<a href="<?php echo $album['href']; ?>">

				<img src="<?php echo $album['thumb'] ?>" alt="<?php echo $album['name'] ?>">

				<span><?php echo $album['name'] ?></span>

			</a>

		<?php } ?>

		</div>

		<nav>

			<span class="dg-prev" id="swipe-prev2">&lt;</span>

			<span class="dg-next" id="swipe-next2">&gt;</span>

		</nav>

	</section>

	</div>

	<!-- end second 3d-slider -->
