<?php echo $header; ?>

	<?php echo $column_left; ?>
	<div class="content-main-contacts"><?php echo $content_top; ?>
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
        <div class="contacts-contant">
            <div class="tittle-block">
                <h2>Контакты</h2>
            </div>

            <div class="map">
                <h3>Мы на карте</h3>
				<div id="map" style="width:550px; height:420px"></div>
				<script src="http://api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
                <?php if($config_geocode){ ?>
                    <script type="text/javascript">
                        var myMap;
                        ymaps.ready(init);
                        function init()
                        {
                            ymaps.geocode('<?php echo $config_geocode; ?>', {
                                results: 1
                            }).then
                            (
                                function (res)
                                {
                                    var firstGeoObject = res.geoObjects.get(0),
                                        myMap = new ymaps.Map
                                        ("map",
                                            {
                                                center: firstGeoObject.geometry.getCoordinates(),
                                                zoom: 15
                                            }
                                        );
                                    var myPlacemark = new ymaps.Placemark
                                    (
                                        firstGeoObject.geometry.getCoordinates(),
                                        {
                                            iconContent: ''
                                        },
                                        {
                                            preset: 'twirl#blueStretchyIcon'
                                        }
                                    );
                                    myMap.geoObjects.add(myPlacemark);
                                    myMap.controls.add(new ymaps.control.ZoomControl()).add(new ymaps.control.ScaleLine()).add('typeSelector');
                                },
                                function (err)
                                {
                                    alert(err.message);
                                }
                            );
                        }
                    </script>
                <?php } ?>
                <!--<iframe src="https://api-maps.yandex.ru/frame/v1/-/CZg7uQ7G" width="550" height="420" frameborder="0"></iframe>-->
            </div>

            <?php echo $contact_inf; ?>
        </div>
        <!-- end content -->
	<?php echo $content_bottom; ?>
    <?php echo $column_right; ?>
    </div>
<?php echo $footer; ?>
