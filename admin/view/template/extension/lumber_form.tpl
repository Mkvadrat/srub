<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="album_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>

				  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_gallery_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="album_description[<?php echo $language['language_id']; ?>][name_gallery]" value="<?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['name_gallery'] : ''; ?>" placeholder="<?php echo $entry_gallery_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>

				  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_category_text; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="album_description[<?php echo $language['language_id']; ?>][category_text]" value="<?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['category_text'] : ''; ?>" placeholder="<?php echo $entry_category_text; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>

				  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-short-description<?php echo $language['language_id']; ?>"><?php echo $entry_short_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="album_description[<?php echo $language['language_id']; ?>][short_description]" placeholder="<?php echo $entry_short_description; ?>" id="input-short-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['short_description'] : ''; ?></textarea>
					</div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="album_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="album_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="album_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($album_description[$language['language_id']]) ? $album_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $album_store)) { ?>
                        <input type="checkbox" name="album_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="album_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $album_store)) { ?>
                        <input type="checkbox" name="album_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="album_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-download"><span data-toggle="tooltip" title="<?php echo $help_download; ?>"><?php echo $entry_download; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="input-download" class="form-control" />
                  <div id="album-download" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($album_downloads as $album_download) { ?>
                    <div id="album-download<?php echo $album_download['download_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $album_download['name']; ?>
                      <input type="hidden" name="album_download[]" value="<?php echo $album_download['download_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-image">
              <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td></td>
                      <td class="text-left"><?php echo $entry_image; ?></td>
                      <td class="text-left"><?php echo $entry_title; ?></td>
                      <td class="text-right"><?php echo $entry_sort_order; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="imagemanager_id">
                    <?php $image_row = 0; ?>
                    <?php foreach ($album_images as $album_image) { ?>
                    <tr id="image-row<?php echo $image_row; ?>">
                      <td class="text-center imagemanager"><i class="fa fa-bars"></i></td>
                      <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $album_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="album_image[<?php echo $image_row; ?>][image]" value="<?php echo $album_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                      <td class="left"><textarea name="album_image[<?php echo $image_row; ?>][name]" cols="40" rows="3" /><?php echo $album_image['name']; ?></textarea></td>
                      <td class="text-right"><input type="text" name="album_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $album_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                      <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $image_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
  height: 300
});
<?php } ?>

<?php foreach ($languages as $language) { ?>
$('#input-short-description<?php echo $language['language_id']; ?>').summernote({
  height: 300
});
<?php } ?>
//--></script>

  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>

 <script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImages(files, path, item) {
  html  = '<tr class="separator" id="image-row' + image_row + '">';
  html += '  <td class="text-center imagemanager"><i class="fa fa-bars"></i></td>';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img style="width:100px;height:100px;" src="' + files + '" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="album_image[' + image_row + '][image]" value="' + path + '" id="input-image' + image_row + '" /></td>';
   html += '  <td class="left"><textarea name="album_image[' + image_row + '][name]" cols="40" rows="3" /></textarea></td>';
  html += '  <td class="text-right"><input type="text" name="album_image[' + image_row + '][sort_order]" value="' + item + '" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#images tbody').append(html);

  image_row++;
}

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
  html += '  <td class="text-center imagemanager"><i class="fa fa-bars"></i></td>';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="album_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
   html += '  <td class="left"><textarea name="album_image[' + image_row + '][name]" cols="40" rows="3" /></textarea></td>';
  html += '  <td class="text-right"><input type="text" name="album_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#images tbody').append(html);

  image_row++;
}

// Downloads
$('input[name=\'download\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['download_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'download\']').val('');

		$('#album-download' + item['value']).remove();

		$('#album-download').append('<div id="album-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="album_download[]" value="' + item['value'] + '" /></div>');
	}
});

$('#album-download').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
</div>

<script type="text/javascript"><!--
  $(document).ready(function() {
    $('#imagemanager_id').sortable({
      axis: 'y',
      forcePlaceholderSize: true,
      placeholder: 'group_move_placeholder',
      stop: function(event, ui)
      {
        $('#imagemanager_id input[name$="[sort_order]"]').each(function(i) {
          $(this).val(i);
        });
      }
    });

    $("#imagemanager_id").mousedown(function() {
      $(".imagemanager").addClass("grabbing");
    });

    $("#imagemanager_id").mouseup(function() {
      $(".imagemanager").removeClass("grabbing");
    });
  });
//--></script>
<?php echo $footer; ?>
