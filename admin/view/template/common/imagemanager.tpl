<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
		<h4 class="modal-title"><?php echo $heading_title; ?></h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top: -18px;">
			<i class="fa fa-times-circle-o"></i>
		</button>
    </div>
    <div class="modal-body">
		<div id="elfinder"></div>
    </div>
	<div class="modal-footer">
	</div>
  </div>
</div>

<!-- ADD ELFINDER LANGUAGE -->
<script type="text/javascript" src="view/javascript/imagemanager/elFinder/js/i18n/elfinder.<?php echo $language; ?>.js"></script>

<script>
$(document).ready(function() {
	$('#elfinder').elfinder({
		url: 'index.php?route=common/imagemanager/init&token=' + getURLVar('token'),
		width: '100%',
		lang: '<?php echo $language;?>',
		resizable: false,
		dragUploadAllow: true,
		destroyOnClose: false,
		commandsOptions: {
		  getfile: {
			multiple : true,
		  }
		},
		getFileCallback : function(files, fm) {
			if(count(files) > 1){
				$.each(files, function(item, file) {
					if ((file.read && file.hash)) {
						console.log(file.url);
						//parent.addImages(file.url, fm.path(file.hash), item);
						//$('#modal-image').modal('hide');
						$.ajax({
							url: 'index.php?route=common/imagemanager/getTmb&thumb=' + encodeURIComponent(fm.path(file.hash)) + '&token=' + getURLVar('token'),
							dataType: 'json',
							async: false,
							success: function(data) {
								/*html  = '  <tr id="image-row' + image_row + '">';
								html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail" data-original-title="" title=""><img src="' + data.thumb + '" alt="" title="" data-placeholder=""><input type="hidden" name="product_image[' + image_row + '][image]" value="' + fm.path(file.hash) + '" id="input-image' + image_row + '"></a></td>';
								html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" placeholder="Sort Order" class="form-control"></td>';
								html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
								html += '  </tr>';
								$('table#images tbody').append(html);

								image_row++;

								$('#modal-image').modal('hide');*/

								parent.addImages(data.thumb, fm.path(file.hash), item);

								$('#modal-image').modal('hide');
							}
						});
					}
				});
			}else{
				$.each(files, function(index, file) {
					if ((file.read && file.hash)) {
						$.ajax({
							url: 'index.php?route=common/imagemanager/getTmb&thumb=' + encodeURIComponent(fm.path(file.hash)) + '&token=' + getURLVar('token'),
							dataType: 'json',
							success: function(data) {
								<?php if ($thumb) { ?>
									$('#<?php echo $thumb; ?>').find('img').attr('src', data.thumb);
								<?php } ?>
								<?php if ($target) { ?>
									$('#<?php echo $target; ?>').attr('value', fm.path(file.hash));
								<?php } ?>

								$('#modal-image').modal('hide');
							}
						});
					}
				});
			}
		},
		uiOptions : {
			toolbar : [
				['back', 'forward'],
				['reload'],
				['home', 'up'],
				['mkdir', 'upload'],
				['open', 'download', 'getfile'],
				['info'],
				['quicklook'],
				['copy', 'cut', 'paste'],
				['rm'],
				['duplicate', 'rename', 'edit', 'resize'],
				['extract', 'archive'],
				['search'],
				['view'],
				['help']
			]
		},
		contextmenu : {
			cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'paste', '|', 'info']
		}
	});

	function count(object) {
	  var count = 0;
	  for(var prs in object){
			   if(object.hasOwnProperty(prs)) count++;
	  }
	  return count;
	}
});
</script>
