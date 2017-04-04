<?php echo $header; ?>

	

	<?php echo $column_left; ?>

	<div class="content-main-price-in"><?php echo $content_top; ?>

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

                <h2>Наши цены</h2>

            </div>



            <div class="description-price">

                <ul>

				<?php foreach($albums as $album){ ?>

                    <li>

                        <h5><?php echo $album["name"]?></h5>

                        <div class="download-price">

							<?php echo $album["short_description"]; ?>

							

							<?php foreach($album['downloads'] as $download){ ?>

							<?php if($download['price_id'] == $album["price_id"]){ ?>

								<a class="download" href="<?php echo $download['href']; ?>"><?php echo $download['name']; ?></a><br/>

							<?php } ?>

							<?php } ?>

                        </div>



                        <img src="<?php echo $album["thumb"]; ?>" alt="">



                        <div class="look-project">

                            <a href="<?php echo $album["href"]; ?>">посмотреть эскизно-архитектурный проект</a>

                            <p><?php echo $album["category_text"]; ?></p>

                        </div>

                    </li>

				<?php } ?>

                </ul>

				
			<div class="pagination">
				<?php echo $pagination; ?>
			</div>
            </div>

        </div>

		

	<?php echo $content_bottom; ?>

    <?php echo $column_right; ?>

    </div>

    <!-- end content -->



<?php echo $footer; ?>