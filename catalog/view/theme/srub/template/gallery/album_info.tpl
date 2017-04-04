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
				<h2><?php echo $heading_title; ?></h2>
			</div>

			<div class="inform-project">
                <div class="description">
                    <h3><?php echo $heading_title; ?></h3>
				<?php if($description){ ?>
					<?php echo $description; ?>
				<?php }?>
                </div>

				<ul>
					<li><a href="<?php echo $continue_album; ?>">Вернуться в предыдущее меню</a></li>
					<li><a href="<?php echo $home; ?>">Вернуться в главное меню</a></li>
				</ul>
			</div>

			<?php if (empty($images)) { ?>
				<div class="slider slider-for single-pic">
						<div>
								<a class="thumbnail colorbox" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $popup; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
						</div>
				</div>
			<?php }?>

			<?php $i=1; ?>
			<?php if ($images) { ?>
			<div class="slider slider-for">
				<?php foreach ($images as $image) { ?>
					<div>
							<a class="thumbnail colorbox" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"  onclick="return false;"><img class="img-target <?php if($i==1){echo 'active';}?>" id="img<?php echo $i; ?>" src="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
					</div>
					<?php $i++; ?>
				<?php }?>
			</div>
			<div class="slider slider-nav">
				<?php foreach ($images as $image) { ?>
				<div>
					<img src="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<!-- end content -->
	</div>

<?php echo $footer; ?>
