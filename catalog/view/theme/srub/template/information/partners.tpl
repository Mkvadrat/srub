<?php echo $header; ?>
	
	<?php echo $column_left; ?>
    <div class="content-main-in-page"><?php echo $content_top; ?>
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
        <div class="in-page-contant">
            <div class="tittle-block">
                <h2><?php echo $heading_title; ?></h2>
            </div>

			<?php echo $description; ?>

            <a href="<?php echo $project_srub; ?>">Смотреть проекты срубов</a><a href="<?php echo $gallery; ?>">Смотреть галерею срубов</a>

        </div>
        <!-- end content -->
		
	<?php echo $content_bottom; ?>
    <?php echo $column_right; ?>
    </div>
	
<?php echo $footer; ?> 