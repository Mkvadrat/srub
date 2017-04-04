	<div class="content-main">
	<!-- start content -->
	<div class="see-all">
		<a href="<?php echo $all_object; ?>">Смотреть все проекты <span>></span></a>
		<h5>Проекты</h5>
	</div>

	<!-- start first 3d-slider -->
	<section id="dg-container" class="dg-container">
		<div class="dg-wrapper">
		 <?php foreach ($categories as $category) { ?>
			<a href="<?php echo $category['href']; ?>">
				<img src="<?php echo $category['image']; ?>" alt="image02">
				<span><?php echo $category['name']; ?></span>
			</a>
		<?php } ?>
		</div>
		<nav>
			<span class="dg-prev" id="swipe-prev">&lt;</span>
			<span class="dg-next" id="swipe-next">&gt;</span>
		</nav>
	</section>
	<!-- end first 3d-slider -->
	</div>
