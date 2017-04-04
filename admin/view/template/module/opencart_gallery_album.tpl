<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-opencart-gallery-album" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-opencart-gallery-album" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="opencart_gallery_album_status" id="input-status" class="form-control">
                <?php if ($opencart_gallery_album_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>          
          <table id="module" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-right">#</td>
                <td class="text-left"><?php echo $entry_limit; ?></td>
                <td class="text-left"><?php echo $entry_as; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $module_row = 1; ?>
              <?php foreach ($opencart_gallery_album_modules as $opencart_gallery_album_module) { ?>
              <tr id="module-row<?php echo $opencart_gallery_album_module['key']; ?>">
                <td class="text-right"><?php echo $module_row; ?></td>
                <td class="text-left"><input type="text" name="opencart_gallery_album_module[<?php echo $opencart_gallery_album_module['key']; ?>][limit]" value="<?php echo $opencart_gallery_album_module['limit']; ?>" placeholder="<?php echo $entry_limit; ?>" class="form-control" /></td>
                <td>
                  <select name="opencart_gallery_album_module[<?php echo $opencart_gallery_album_module['key']; ?>][as]" class="form-control">
                    <option value="1" <?php if ($opencart_gallery_album_module['as'] == 1) { ?>selected="selected"<?php } ?>>Small</option>
                    <option value="2" <?php if ($opencart_gallery_album_module['as'] == 2) { ?>selected="selected"<?php } ?>>Medium</option>
                    <option value="3" <?php if ($opencart_gallery_album_module['as'] == 3) { ?>selected="selected"<?php } ?>>Large</option>
                  </select>
                </td>
                <td class="text-left"><button type="button" onclick="$('#module-row<?php echo $opencart_gallery_album_module['key']; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $module_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_module_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
 
  <script type="text/javascript"><!--
function addModule() {  
  var token = Math.random().toString(36).substr(2);
  
  html  = '<tr id="module-row' + token + '">';
  html += '  <td class="text-right">' + ($('tbody tr').length + 1) + '</td>';
  html += '  <td class="text-left"><input type="text" name="opencart_gallery_album_module[' + token + '][limit]" value="5" placeholder="<?php echo $entry_limit; ?>" class="form-control" /></td>';
  html += '  <td class="text-left">';
  html += '  <select name="opencart_gallery_album_module[' + token + '][as]" class="form-control">';
  html += '  <option value="1" >Small</option><option value="2" >Medium</option><option value="3" >Large</option>';
  html += '  </select></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#module-row' + token + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#module tbody').append(html);
}
//--></script></div>
<?php echo $footer; ?>