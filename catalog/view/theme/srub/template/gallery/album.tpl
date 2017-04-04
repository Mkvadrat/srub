<?php echo $header; ?>

	<?php echo $column_left; ?>
	<div class="content-main-projects"><?php echo $content_top; ?>
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

        <!-- start 3d-sliders -->
		<?php if ($albums) { ?>
        <section id="dg-container3" class="dg-container">
            <div class="dg-wrapper">
			<?php foreach ($albums as $album) { ?>
                <a href="<?php echo $album['href']; ?>">
                    <img src="<?php echo $album['thumb']; ?>" alt="<?php echo $album['name']; ?>">
                    <span><?php echo $album['name']; ?></span>
                </a>
			<?php } ?>
            </div>
            <nav>
                <span class="dg-prev" id="swipe-prev3">&lt;</span>
                <span class="dg-next" id="swipe-next3">&gt;</span>
            </nav>
        </section>
        <!-- end 3d-sliders -->
		<?php }else{ ?>
			<div class="serch-results-empty">
				<div class="buttons">
					<a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a>
				</div>
				<p><?php echo $text_empty; ?></p>
			</div>
      <?php } ?>

	<?php echo $content_bottom; ?>
    <?php echo $column_right; ?>
    </div>

<?php echo $footer; ?>
