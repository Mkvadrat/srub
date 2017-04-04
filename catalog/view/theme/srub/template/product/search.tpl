<?php echo $header; ?>

	<?php echo $column_left; ?>
	<div id="content" class="content-main-price-in"><?php echo $content_top; ?>
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
        <div class="price-contant">
            <div class="tittle-block">
                <h2>Поиск</h2>
            </div>

            <div class="search-results">
                <p><?php echo $text_search; ?></p>
            </div>

            <div class="box-search-in-cont">
				<div class="box-search">
					<input type="search" name="search" value="<?php echo $search; ?>" placeholder="Поиск">
					<input id="search_search" type="submit" value="">
				</div>
<script>
$('#search_search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#search_search').trigger('click');
	}
});
</script>	
            </div>
			
			<?php if ($products) { ?>
				<div class="search-cont">
					<ul>
					<?php foreach ($products as $product) { ?>
						<li>
							<a href="<?php echo $product['href']; ?>">
								<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
								<span><?php echo $product['name']; ?></span>
							</a>
						</li>
				<?php } ?>
					</ul>
				</div>

				<div class="pagination">
					<?php echo $pagination; ?>
					<p><?php echo $results; ?></p>
					
				</div>
			<?php } else { ?>
				<p class="not-found"><?php echo $text_empty; ?></p>
			<?php } ?>

            <a class="look-galery" href="<?php echo $project_srub; ?>">Cмотреть проекты срубов</a><a class="back-main" href="<?php echo $gallery; ?>">Смотреть галерею срубов</a>
        </div>
		
	<?php echo $content_bottom; ?>
    <?php echo $column_right; ?>
    </div>
    <!-- end content -->

<?php echo $footer; ?>