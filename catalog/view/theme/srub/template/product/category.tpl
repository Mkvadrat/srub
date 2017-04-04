<?php echo $header; ?>

	<?php echo $column_left; ?>
	<div class="content-main-news"><?php echo $content_top; ?>
		<div class="bread-crumbs">
	<?php
					$count = count($breadcrumbs);
					$i=1;
				foreach ($breadcrumbs as $breadcrumb) {
					if($i!=$count){
	?>
					<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a><?php echo ' ' . $breadcrumb['separator']; ?>
	<?php
					}else{
						echo '<i class="active"> '.$breadcrumb['text'] . '</i>';
					}
					$i++;
				}
	?>
		</div>

		<!-- start content -->
		<div class="see-all">
			<h5><?php echo $heading_title; ?></h5>
		</div>

		<!-- start news block -->
		<div class="news-block">
		<?php if ($products) { ?>
			<ul>
				<?php foreach ($products as $product) { ?>
				<li>
					<img src="<?php echo $product['thumb'] ?>" alt="">
					<h5><?php echo $product['name'] ?></h5>
					<i><?php echo $product['description'] ?></i>
					<p class="date">
						<a href="<?php echo $product['href']; ?>">Читать далее</a>
					</p>
					</li>
				<?php } ?>
			</ul>

			<div class="pagination">
				<?php echo $pagination; ?>
				<p><?php echo $results; ?></p>
			</div>
		<?php }else{ ?>
			<div class="serch-results-empty">
				<div class="buttons">
					<a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a>
				</div>
				<p><?php echo $text_empty; ?></p>
			</div>
		<?php } ?>

			<a class="back" href="<?php echo $continue; ?>">Вернуться в главное меню</a>

		<?php echo $content_bottom; ?></div>
		<?php echo $column_right; ?>
        <!-- end news block -->
    </div>
	<!-- end content -->
<?php echo $footer; ?>
