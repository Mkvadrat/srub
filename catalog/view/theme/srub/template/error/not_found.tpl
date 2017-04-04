<?php echo $header; ?>

    <div class="content-main-price-in">
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
                <a href="<?php echo $all_object; ?>">Смотреть все проекты ></a>

                <h2>проекты срубов</h2>
            </div>

            <div class="cont-404">

                <img src="catalog/view/theme/srub/images/404.png" alt="">

                <p>Данная Страница не найдена</p>

                <a href="<?php echo $gallery; ?>">Посмотреть проекты срубов</a><a href="<?php echo $continue; ?>">Вернуться в главное меню</a>

            </div>

        </div>

    </div>
    <!-- end content -->
	
<?php echo $footer; ?>