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

            <h5>Новости компании</h5>

        </div>



        <!-- start news block -->



        <div class="news-block">

            <ul>

			<?php foreach ($all_partners as $partners) { ?>

                <li>

                    <img src="<?php echo $partners['image']; ?>" alt="">



                    <h5><?php echo $partners['title']; ?></h5>

                    <i><?php echo $partners['description']; ?></i>

                    <p class="date">

                        <a href="<?php echo $partners['view']; ?>">Читать далее</a>

                    </p>

                </li>

			<?php } ?>

            </ul>

			
        <div class="pagination">
			<?php echo $pagination; ?>
        </div>
			

            <a class="back" href="<?php echo $continue; ?>">Вернуться в главное меню</a>

		</div>

	<?php echo $content_bottom; ?>

    <?php echo $column_right; ?>

	</div>



        <!-- end news block -->

<?php echo $footer; ?> 