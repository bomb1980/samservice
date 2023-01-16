<?php
$this->pageTitle  = 'เพิ่มเนื้อหา ' . Yii::app()->params['prg_ctrl']['pagetitle'];
$themesurl = Yii::app()->params['prg_ctrl']['url']['themes'];
//echo Yii::app()->FileHelper::getExtensionsByMimeType($mimeType, $${magicFile = null})->genstring();
//echo FileHelper::getExtensionsByMimeType("video/jpeg");

//$path = Yii::getPathOfAlias('webroot.images');

//$files = CFileHelper::getExtensionByMimeType("D:/Server/www/ihc/uploads/attachment/7Q1Udxl1j1/1556610137619 (1).jpg"); 
//echo pathinfo('D:/Server/www/ihc/uploads/attachment/Wfn14Bxbp0/ภาษาไทยทั้งหมด.zip', PATHINFO_FILENAME);
//echo pathinfo('D:/Server/www/ihc/uploads/attachment/Wfn14Bxbp0/ภาษาไทยทั้งหมด.zip', PATHINFO_BASENAME);


?>
<!-- Include Datatable. -->
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowreorder-bs4/dataTables.rowReorder.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/tables/datatable.css">

<!-- Include Font Awesome. -->
<link href="<?php echo Yii::app()->baseUrl ?>/vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl ?>/vendor/font-awesome/css/v4-shims.min.css" rel="stylesheet" type="text/css" />

<!-- Include Froala Editor styles -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/froala_editor.min.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/froala_style.min.css" />

<!-- Include Froala Editor Plugins styles -->
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/emoticons.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/file.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/image_manager.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/image.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/css/plugins/video.css">

<!-- Include Froala Editor -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/froala_editor.min.js"></script>

<!-- Include Froala Editor Plugins -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/align.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/char_counter.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/code_view.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/colors.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/emoticons.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/entities.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/file.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/font_family.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/font_size.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/image.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/image_manager.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/inline_style.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/link.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/lists.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/quote.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/save.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/table.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/plugins/video.min.js"></script>

<!-- Include the language file. -->
<script src='<?php echo Yii::app()->baseUrl ?>/vendor/froala/wysiwyg-editor/js/languages/th.js'></script>

<!-- Include Datatable. -->
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.print.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowreorder/dataTables.rowReorder.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowreorder-bs4/rowReorder.bootstrap4.js"></script>

<style>
  /*a[href*="froala"]{
	  	display: none !important;
		} */

  div.fr-wrapper>div>a {
    /* display: none !important; */
    /* position: fixed; */
    /* z-index: -99999 !important; */
    font-size: 0px !important;
    padding: 0px !important;
    height: 0px !important;
  }

  div#edit_dropzone {
    border: 1px solid #C7C7C7;
    padding: 20px;
    text-align: center;
    box-shadow: inset 0px 0px 12px rgba(0, 0, 0, 0.12);
    -webkit-box-shadow: inset 0px 0px 12px rgba(0, 0, 0, 0.12);
    -moz-box-box-shadow: inset 0px 0px 12px rgba(0, 0, 0, 0.12);
    border-radius: 3px;
  }

  div#edit_dropzone i {
    display: block;
    font-size: small;
    margin-bottom: 5px;
    color: #CACACA;
    text-shadow: 1px 1px 1px #fff;
  }

  .example-dropdown {
    width: 100%;
  }

  @media only screen and (min-width : 768px) {}

  .ui-state-highlight
   {
    padding:20px;
    background-color:#ffffcc;
    border:1px dotted #ccc;
    cursor:move;
    margin-top:12px;
   }
   [id^="sub"] {
    cursor:move;
    height: auto;
    overflow: hidden;
  }
</style>

<!-- End Froala -->


<!--Multiple Ajax Upload -->
<link href="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/style.css" rel="stylesheet" type="text/css">

<!-- <script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.iframe-transport.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
  <script src="js/cors/jquery.xdr-transport.js"></script>
  <![endif]-->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/fileupload/js/jquery.fileupload-validate.js"></script>
<script language="javascript">
  $(function() {
    'use strict';
    var fi = $('#fileupload'); //file input 
    //var process_url = '<?php echo dirname($_SERVER["PHP_SELF"]) ?>/upload.php'; //PHP script
    var process_url = '<?php echo Yii::app()->baseUrl ?>/fileupload/Upload_file';
    var progressBar = $('<div/>').addClass('uploadprogress').append($('<div/>').addClass('uploadprogress-bar')); //progress bar
    var uploadButton = $('<button/>').addClass('button btn-blue upload btn').text('Upload'); //upload button

    uploadButton.on('click', function() {
      var $this = $(this),
        data = $this.data();
      data.submit().always(function() {
        $this.parent().find('.uploadprogress').show();
        $this.parent().find('.remove').remove();
        $this.remove();
      });
    });


    //initialize blueimp fileupload plugin
    fi.fileupload({
      url: process_url,
      dataType: 'json',
      autoUpload: false,
      acceptFileTypes: /(\.|\/)(gif|jpe?g|png|mp4|mp3|pdf|ppt|pptx|doc|docx|xls|xlsx|zip|rar|7z)$/i,
      //maxFileSize: 1048576, //1MB
      maxFileSize: 20971520, //20MB
      // Enable image resizing, except for Android and Opera,
      // which actually support image resizing, but fail to
      // send Blob objects via XHR requests:
      disableImageResize: /Android(?!.*Chrome)|Opera/
        .test(window.navigator.userAgent),
      previewMaxWidth: 50,
      previewMaxHeight: 50,
      previewCrop: true,
      dropZone: $('#dropzone'),
      formData: {
        YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>',
        filecode: '<?php echo $filecode; ?>'
      }
    });

    fi.on('fileuploadsubmit', function(e, data) {
      $(".upload").prop('disabled', true);
      data.formData = {
        YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>',
        filecode: $('#hdfilecode').val(),
      };
    });

    fi.on('fileuploadadd', function(e, data) {
      data.context = $('<div/>').addClass('file-wrapper').appendTo('#files');
      $.each(data.files, function(index, file) {
        var node = $('<div/>').addClass('file-row');
        var removeBtn = $('<button/>').addClass('button btn-red remove btn').text('Remove');
        removeBtn.on('click', function(e, data) {
          $(this).parent().parent().remove();
        });

        var file_txt = $('<div/>').addClass('file-row-text').append('<span>' + file.name + ' (' + format_size(file.size) + ')' + '</span>');

        file_txt.append(removeBtn);
        file_txt.prependTo(node).append(uploadButton.clone(true).data(data));
        progressBar.clone().appendTo(file_txt);
        if (!index) {
          node.prepend(file.preview);
        }

        node.appendTo(data.context);
      });
    });

    fi.on('fileuploadprocessalways', function(e, data) {
      var index = data.index,
        file = data.files[index],
        node = $(data.context.children()[index]);
      if (file.preview) {
        node.prepend(file.preview);
      }
      if (file.error) {
        node.append($('<span class="text-danger"/>').text(file.error));
      }
      if (index + 1 === data.files.length) {
        data.context.find('button.upload').prop('disabled', !!data.files.error);
      }
    });

    fi.on('fileuploadprogress', function(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      if (data.context) {
        data.context.each(function() {
          $(this).find('.uploadprogress').attr('aria-valuenow', progress).children().first().css('width', progress + '%').text(progress + '%');
        });
      }
    });

    fi.on('fileuploaddone', function(e, data) {
      $.each(data.result.files, function(index, file) {
        if (file.url) {
          var link = $('<a>').attr('target', '_blank').prop('href', file.url);
          $(data.context.children()[index]).addClass('file-uploaded');
          $(data.context.children()[index]).find('canvas').wrap(link);
          $(data.context.children()[index]).find('.file-remove').hide();
          var done = $('<span class="text-success"/>').text('Uploaded!');
          $(data.context.children()[index]).append(done);
        } else if (file.error) {
          var error = $('<span class="text-danger"/>').text(file.error);
          $(data.context.children()[index]).append(error);
        }
      });
    });

    fi.on('fileuploadfail', function(e, data) {
      $('#error_output').html(data.jqXHR.responseText);
      $('.uploadprogress-bar').text("0%");
      $('.uploadprogress-bar').css("background-color", '#EA6363');
    });

    //Edit mode
    var fie = $('#edit_fileupload'); //file input 
    //var process_url = '<?php echo dirname($_SERVER["PHP_SELF"]) ?>/upload.php'; //PHP script
    var process_url = '<?php echo Yii::app()->baseUrl ?>/fileupload/Upload_file';
    var progressBar = $('<div/>').addClass('uploadprogress').append($('<div/>').addClass('uploadprogress-bar')); //progress bar
    var uploadButton = $('<button/>').addClass('button btn-blue upload btn').text('Upload'); //upload button

    uploadButton.on('click', function() {
      var $this = $(this),
        data = $this.data();
      data.submit().always(function() {
        $this.parent().find('.uploadprogress').show();
        $this.parent().find('.remove').remove();
        $this.remove();
      });
    });


    //initialize blueimp fileupload plugin
    fie.fileupload({
      url: process_url,
      dataType: 'json',
      autoUpload: false,
      acceptFileTypes: /(\.|\/)(gif|jpe?g|png|mp4|mp3|pdf|ppt|pptx|doc|docx|xls|xlsx|zip|rar|7z)$/i,
      //maxFileSize: 1048576, //1MB
      maxFileSize: 20971520, //20MB
      // Enable image resizing, except for Android and Opera,
      // which actually support image resizing, but fail to
      // send Blob objects via XHR requests:
      disableImageResize: /Android(?!.*Chrome)|Opera/
        .test(window.navigator.userAgent),
      previewMaxWidth: 50,
      previewMaxHeight: 50,
      previewCrop: true,
      dropZone: $('#edit_dropzone'),
      formData: {
        YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>',
        filecode: '<?php echo $filecode; ?>'
      }
    });

    fie.on('fileuploadsubmit', function(e, data) {
      //consoleconsole.log(uploadButton);
      $(".upload").prop('disabled', true);
      data.formData = {
        YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>',
        filecode: $('#fefilecode').val(),
      };
    });

    fie.on('fileuploadadd', function(e, data) {
      data.context = $('<div/>').addClass('file-wrapper').appendTo('#edit_files');
      $.each(data.files, function(index, file) {
        var node = $('<div/>').addClass('file-row');
        var removeBtn = $('<button/>').addClass('button btn-red remove btn').text('Remove');
        removeBtn.on('click', function(e, data) {
          $(this).parent().parent().remove();
        });

        var file_txt = $('<div/>').addClass('file-row-text').append('<span>' + file.name + ' (' + format_size(file.size) + ')' + '</span>');

        file_txt.append(removeBtn);
        file_txt.prependTo(node).append(uploadButton.clone(true).data(data));
        progressBar.clone().appendTo(file_txt);
        if (!index) {
          node.prepend(file.preview);
        }

        node.appendTo(data.context);
      });
    });

    fie.on('fileuploadprocessalways', function(e, data) {
      var index = data.index,
        file = data.files[index],
        node = $(data.context.children()[index]);
      if (file.preview) {
        node.prepend(file.preview);
      }
      if (file.error) {
        node.append($('<span class="text-danger"/>').text(file.error));
      }
      if (index + 1 === data.files.length) {
        data.context.find('button.upload').prop('disabled', !!data.files.error);
      }
    });

    fie.on('fileuploadprogress', function(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      if (data.context) {
        data.context.each(function() {
          $(this).find('.uploadprogress').attr('aria-valuenow', progress).children().first().css('width', progress + '%').text(progress + '%');
        });
      }
    });

    fie.on('fileuploaddone', function(e, data) {
      $.each(data.result.files, function(index, file) {
        if (file.url) {
          var link = $('<a>').attr('target', '_blank').prop('href', file.url);
          $(data.context.children()[index]).addClass('file-uploaded');
          $(data.context.children()[index]).find('canvas').wrap(link);
          $(data.context.children()[index]).find('.file-remove').hide();
          var done = $('<span class="text-success"/>').text('Uploaded!');
          $(data.context.children()[index]).append(done);
        } else if (file.error) {
          var error = $('<span class="text-danger"/>').text(file.error);
          $(data.context.children()[index]).append(error);
        }
      });
    });

    fie.on('fileuploadfail', function(e, data) {
      $('#edit_error_output').html(data.jqXHR.responseText);
      $('.uploadprogress-bar').text("0%");
      $('.uploadprogress-bar').css("background-color", '#EA6363');
    });

    //End Edit mode

    function format_size(bytes) {
      if (typeof bytes !== 'number') {
        return '';
      }
      if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
      }
      if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
      }
      return (bytes / 1000).toFixed(2) + ' KB';
    }
  });
</script>
<!-- End Multiple Ajax Upload -->

<!-- Page -->
<div class="page">

  <div class="page-header">
    <h1 class="page-title"><?php echo $cate_name ?></h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::app()->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="<?php echo Yii::app()->createAbsoluteUrl("/branch/viewdata") . '/' . $id; ?>"><?php echo $cate_name ?></a></li>
        <li class="breadcrumb-item atcitve">เพิ่มเนื้อหา</li>
      </ol>
    </div>
  </div>

  <div class="page-content container-fluid">

    <!-- Panel Basic -->
    <div class="panel">


      <div class="panel-body">



        <div class="row col pb-5">
          <div class="form-inline">
            <div class="panel-heading">
              <h3 class="panel-title p-10">ชื่อเมนู : </h3>
            </div>
            <div class="col">
            <?php
              $menuname = "เมนู";
              $id_setting = null;
              if (count($settings) != 0) {
                foreach ($settings as $item) {
                  if ($item['name'] == "menuname") {
                    $menuname = $item['value'];
                    $id_setting = $item['id'];
                    continue;
                  }
                }
              }
            ?>
              <div id="menuid<?php echo $id; ?>" style="display: table;padding: 5px 0px;">
                <div style="float: left;margin-right: 5px;display: table-cell;">
                  <input type="text" class="form-control" id="setting_tabname" name="setting_tabname" value="<?php echo $menuname;?>" maxlength="50">
                  <input type="hidden" id="esetting_tabname" value="<?php echo $menuname;?>">
                </div>
                <div style="display: table-cell; vertical-align:middle;">
                  <a href="javascript:void(0)" onclick="ajax_update_tabname('<?php echo $id_setting ?>', setting_tabname);" class="" style="margin-left: 15px;text-decoration: none;" title="แก้ไข"> 
                    <i class="icon fa-save fa-1x" aria-hidden="true" style="font-size: 18px;"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row row-lg">

          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pr-0">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-info panel-line">
                  <div class="panel-heading">
                    <h3 class="panel-title p-10">ประเภทหัวข้อ</h3>
                  </div>


                  <div id="divlv3" class="panel-body d-flex justify-content-center p-5">
                    <div class="example-dropdown">

                    </div>

                  </div>

                  <!-- Add Label Form -->
                  <div class="modal modal-info fade" id="addLabelForm" aria-hidden="true" aria-labelledby="addLabelForm" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="cursor: move;">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="icon fa-close" aria-hidden="true"></i>
                          </button>
                          <h4 class="modal-title">เพิ่มประเภท</h4>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <h4 class="example-title">กลุ่มไฟล์</h4>
                              <textarea id="subject" name="subject"></textarea>

                            </div>

                            <div class="form-group">
                              <h4 class="example-title">สิทธิ์การแสดงเนื้อหา</h4>
                              <select class="form-control selectpicker" id="selpermission" name="selpermission">
                                <option value="1" data-icon="md-lock-outline">เฉพาะฉัน</option>
                                <option value="2" data-icon="md-accounts-outline">เฉพาะกลุ่มงาน</option>
                                <option value="3" selected="selected" data-icon="fa-globe">ทั้งหมด</option>
                              </select>
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <button id="btn2" class="btn btn-primary" data-master="<?php echo $id; ?>" data-ordno_lv3="1" onclick="ajax_addsubject(this, subject);"><i class="fa fa-floppy-o"></i> บันทึก</button>
                          <a class="btn btn-sm btn-white" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Add Label Form -->

                  <!-- Edit Label Form -->
                  <div class="modal modal-info fade" id="editLabelForm" aria-hidden="true" aria-labelledby="editLabelForm" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="cursor: move;">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="icon fa-close" aria-hidden="true"></i>
                          </button>
                          <h4 class="modal-title">แก้ไขหัวข้อ</h4>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <h4 class="example-title">กลุ่มไฟล์</h4>
                              <textarea id="esubject" name="esubject"></textarea>

                            </div>

                            <div class="form-group">
                              <h4 class="example-title">สิทธิ์การแสดงเนื้อหา</h4>
                              <select class="form-control selectpicker" id="eselpermission" name="eselpermission">
                                <option value="1" data-icon="md-lock-outline">เฉพาะฉัน</option>
                                <option value="2" data-icon="md-accounts-outline">เฉพาะกลุ่มงาน</option>
                                <option value="3" data-icon="fa-globe">ทั้งหมด</option>
                              </select>
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <input id="hdeid" type="hidden" value="">
                          <input id="ihdisubject" type="hidden" value="">

                          <button id="btne" class="btn btn-primary" data-master="<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-ordno_lv3="1" onclick="ajax_editsubject(this, esubject);"><i class="fa fa-floppy-o"></i> บันทึก</button>
                          <a class="btn btn-sm btn-white" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Edit Label Form -->

                  <!-- Modal Edit file list -->
                  <div class="modal fade modal-info" id="mdEditRole" aria-hidden="true" aria-labelledby="mdEditRole" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-simple modal-center">
                      <div class="modal-content">
                        <div class="modal-header" style="cursor: move;">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="icon fa-close" style="color: #000;" aria-hidden="true"></i>
                          </button>
                          <h4 class="modal-title">แก้ไขไฟล์ดาวน์โหลด</h4>
                        </div>
                        <div class="modal-body">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div class="row row-lg">
                              <div class="col-md-12 pt-10">
                                <h4 class="example-title">ชื่อไฟล์อัพโหลด</h4>
                                <div class="comments-add media">
                                  <form>
                                    <textarea id="edit_subject" name="edit_subject"></textarea>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <div class="row row-lg">
                              <div class="col-md-12 mt-10">
                                <h4 class="example-title">ไฟล์แนบ/ลิงค์</h4>
                                <input type="hidden" id="fefilecode" value="">
                                <div id="listfile"></div>

                                <div class="upload-wrapper">
                                  <div id="edit_error_output"></div>
                                  <!-- file drop zone -->
                                  <div id="edit_dropzone">
                                    <i>Drop files here</i>
                                    <!-- upload button -->
                                    <span class="button btn-blue input-file">
                                      Browse Files <input id="edit_fileupload" type="file" name="files[]" multiple>
                                    </span>
                                  </div>
                                  <!-- The container for the uploaded files -->
                                  <div id="edit_files" class="files"></div>
                                </div>

                              </div>
                            </div>

                            <div class="row row-lg">
                              <div class="col-md-12 mt-10">
                                <h4 class="example-title">หรือลิงค์ภายนอก</h4>

                              </div>
                            </div>

                            <div class="row col pb-5 edit_input_fields_wrap">

                              <div class="col-xs-auto d-flex align-items-center justify-content-center">
                                <i class="icon fa-link mr-auto" aria-hidden="true"></i>
                              </div>
                              <div class="col">
                                <input type="text" class="form-control ml-auto" id="edit_externallink" name="edit_externallink[]" placeholder="ลิงค์ภายนอก">
                              </div>

                            </div>
                            <div class="row col pb-5">
                              <div class="col-xs-auto d-flex align-items-center justify-content-center">
                                <i class="icon fa-plus-circle mr-auto edit_add_field_button" style="cursor:pointer;" aria-hidden="true"></i>
                              </div>
                              <div class="col">
                                เพิ่มลิงค์ภายนอก
                              </div>
                            </div>


                          </div>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" id="hdmaster_id">
                          <input type="hidden" id="hdlist_id">
                          <button id="btnelist" class="btn btn-primary" onclick="ajax_editdata();"><i class="fa fa-floppy-o"></i> บันทึก</button>
                          <button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Edit file list -->
                  <script>
                    $("#mdEditRole").on("show.bs.modal", function(e) {

                      var _button = $(e.relatedTarget);
                      var list_id = $(_button).data("id");

                      $('#fefilecode').val($(_button).data("filecode"));
                      $('#hdlist_id').val(list_id);
                      $('#hdmaster_id').val($(_button).data("master"));

                      $('#edit_subject').froalaEditor('html.set', $('#hdlistsubject' + list_id).text());

                      var _row = _button.parents("tr");

                      $.ajax({
                        url: "<?php echo Yii::app()->createAbsoluteUrl("modal/editbranchcollection"); ?>",
                        method: "POST",
                        data: {
                          'list_id': list_id,
                          'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
                        },
                        success: function(data) {
                          $("#listfile").html(data);
                          //alert(data);
                          $('.table.is-indent thead').hide();
                        }
                      });

                    });

                    function ajax_delete_attachment(id) {
                      var result = confirm("ต้องการลบไฟล์แนบ ?");
                      if (!result) {
                        return;
                      }

                      $.ajax({
                          // Request method.
                          method: "POST",
                          dataType: "json",
                          url: '<?php echo Yii::app()->baseUrl ?>/content/delete_attachment',
                          data: {
                            fileid: id,
                            YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>',
							type :"คอลเลคชั่นหน่วยงาน",
							object_id:<?php echo $id;?>,
                          },
                          success: function(data) {

                          }
                        })
                        .done(function(data) {
                          if (data.status == 'success') {
                            console.log('file was deleted');

                            $('#fileid' + id).fadeOut(1000, function() {
                              $(this).remove();
                            });
                          } else {
                            console.log('could not access the path');
                          }
                        })
                        .fail(function(err) {
                          console.log('file delete problem: ' + JSON.stringify(err));
                        });

                    }
                  </script>


                </div>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pl-0 pr-0">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-success panel-line">
                <div class="panel-heading">
                  <h3 id="htype" class="panel-title p-10">รายการ</h3>
                </div>
                <div id="divlist" class="panel-body">

                  <table id="productTable1" class="table-hover dataTable table-striped w-full">
                    <thead>
                     
                    </thead>
                    <tbody>

                    </tbody>
                  </table>

                  <div class="dropdown-divider"></div>

                  <div class="row row-lg">
                    <div class="col-md-12">
                      <h4 class="example-title">ชื่อไฟล์อัพโหลด</h4>
                      <div class="comments-add media">
                        <form>
                          <textarea id="edit" name="content"></textarea>
                        </form>
                      </div>
                    </div>
                    <script>
                      $(function() {
                        $('#edit, #subject, #esubject, #edit_subject').froalaEditor({
                            language: 'th',
                            imageUploadURL: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/Upload_image',
                            imageUploadParams: {
                              id: 'my_editor',
                              YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'
                            },

                            fileUploadURL: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/Upload_file',
                            fileUploadParams: {
                              id: 'my_editor'
                            },

                            imageManagerLoadURL: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/getlist',
                            imageManagerDeleteURL: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/delete_file',
                            imageManagerDeleteMethod: "POST",

                            imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'], // remove imageManager
                            toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'lineHeight', '|', '-', 'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
                            heightMin: 70,
                            toolbarStickyOffset: 50,
                            toolbarSticky: false,
                            width: '100%',
                          })

                          // Catch image removal from the editor.
                          .on('froalaEditor.image.removed', function(e, editor, $img) {
                            $.ajax({
                                // Request method.
                                method: "POST",

                                // Request URL.
                                url: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/delete_file',

                                // Request params.
                                data: {
                                  src: $img.attr('src'),
                                  YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'
                                }
                              })
                              .done(function(data) {
                                if (data == '"Success"') {
                                  console.log('image was deleted');
                                } else {
                                  console.log('could not access the path');
                                }
                              })
                              .fail(function(err) {
                                console.log('image delete problem: ' + JSON.stringify(err));
                              })
                          })

                          // Catch image removal from the editor.
                          .on('froalaEditor.file.unlink', function(e, editor, link) {

                            $.ajax({
                                // Request method.
                                method: "POST",

                                // Request URL.
                                url: '<?php echo Yii::app()->baseUrl . '/' . $this->uniqueid ?>/delete_file',

                                // Request params.
                                data: {
                                  src: link.getAttribute('href'),
                                  YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'
                                }
                              })
                              .done(function(data) {
                                if (data == '"Success"') {
                                  console.log('file was deleted');
                                } else {
                                  console.log('could not access the path');
                                }
                              })
                              .fail(function(err) {
                                console.log('file delete problem: ' + JSON.stringify(err));
                              })
                          })
                      });
                    </script>


                  </div>

                  <div class="row row-lg">
                    <div class="col-md-9 mt-10">
                      <h4 class="example-title">ไฟล์แนบ</h4>

                      <div class="upload-wrapper">
                        <div id="error_output"></div>
                        <!-- file drop zone -->
                        <div id="dropzone">
                          <i>Drop files here</i>
                          <!-- upload button -->
                          <span class="button btn-blue input-file">
                            Browse Files <input id="fileupload" type="file" name="files[]" multiple>
                          </span>
                        </div>
                        <!-- The container for the uploaded files -->
                        <div id="files" class="files"></div>
                      </div>

                    </div>
                  </div>

                  <div class="row row-lg">
                    <div class="col-md-12 mt-10">
                      <h4 class="example-title">หรือลิงค์ภายนอก</h4>

                    </div>
                  </div>

                  <div class="row col pb-5 input_fields_wrap">

                    <div class="col-xs-auto d-flex align-items-center justify-content-center">
                      <i class="icon fa-link mr-auto" aria-hidden="true"></i>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control ml-auto" id="externallink" name="externallink[]" placeholder="ลิงค์ภายนอก">
                    </div>

                  </div>
                  <div class="row col pb-5">
                    <div class="col-xs-auto d-flex align-items-center justify-content-center">
                      <i class="icon fa-plus-circle mr-auto add_field_button" style="cursor:pointer;" aria-hidden="true"></i>
                    </div>
                    <div class="col">
                      เพิ่มลิงค์ภายนอก
                    </div>
                  </div>

                  <div class="row row-lg">
                    <div class="form-group form-material row">
                      <div class="col-md-9 offset-md-3">
                        <input type="hidden" id="hdobj_id">
                        <input type="hidden" id="hdfilecode" value="<?php echo $filecode; ?>">
                        <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onClick="ajax_savedata();">บันทึกข้อมูล</button>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>



        </div>


      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {

    /* Add external link */
    var max_fields = 5; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e) { //on add input button click
      e.preventDefault();
      if (x < max_fields) { //max input box allowed
        x++; //text box increment
        $(wrapper).clone().insertAfter("div.input_fields_wrap:last").append('<a href="#" class="remove_field col-xs-auto d-flex align-items-center justify-content-center"><i class="icon wb-close" aria-hidden="true"></i></a>');
        $("div.input_fields_wrap:last input").val("");
        //$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
      }
    });
    $(document).on("click", '.remove_field', function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    });

    $(edit_wrapper).on("click", ".remove_field", function(e) { //user click on remove text
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    });
    /* End Add external link */


    /* Edit external link */
    var max_fields = 5; //maximum input boxes allowed
    var edit_wrapper = $(".edit_input_fields_wrap"); //Fields wrapper
    var edit_add_button = $(".edit_add_field_button"); //Add button ID

    var ex = 1; //initlal text box count
    $(edit_add_button).click(function(e) { //on add input button click
      e.preventDefault();
      if (ex < max_fields) { //max input box allowed
        ex++; //text box increment
        $(edit_wrapper).clone().insertAfter("div.edit_input_fields_wrap:last").append('<a href="#" class="edit_remove_field col-xs-auto d-flex align-items-center justify-content-center"><i class="icon wb-close" aria-hidden="true"></i></a>');
        $("div.edit_input_fields_wrap:last input").val("");
        //$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
      }
    });

    $(document).on("click", '.edit_remove_field', function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      ex--;
    });

    $(edit_wrapper).on("click", ".edit_remove_field", function(e) { //user click on remove text
      e.preventDefault();
      $(this).parent('div').remove();
      ex--;
    });
    /* End Edit external link */

    $("#selcontent_category_id").select2({
      language: "th"
    });
    $('Button[id=btnadd]').click(function() {


    });

    $('#addLabelForm').on('hide.bs.modal', function() {
      $('#subject').froalaEditor('html.set', '');
      $("#subject").val("");
      $("#btn2").removeAttr('disabled');

    });
    $('#editLabelForm').on('hide.bs.modal', function() {
      $('#esubject').froalaEditor('html.set', '');
      $("#esubject").val("");
      $('select#eselpermission').val(1);
      $('select#eselpermission').selectpicker('refresh');
      $("#btne").removeAttr('disabled');

    });

    $('#mdEditRole').on('hide.bs.modal', function() {
      $('#edit_subject').froalaEditor('html.set', '');
      $("#edit_subject").val("");
      $("#btnelist").removeAttr('disabled');
      $('.edit_input_fields_wrap').not(":first").remove();
      $('div.file-wrapper').remove();
      $('div#edit_error_output').html('');
    });

    $("#addLabelForm").draggable({
      handle: ".modal-header",
      cursor: "move"
    });
    $("#editLabelForm").draggable({
      handle: ".modal-header",
      cursor: "move"
    });
    $("#mdEditRole").draggable({
      handle: ".modal-header",
      cursor: "move"
    });


    getdatalv3(<?php echo $id; ?>);

    setTimeout(function() {
      var countel = $('#divlv3').find('.dropdown-menu a').length;
      $('#divlv3').find('.dropdown-menu > .dropdown-item').each(function(i, el) {

        if (i == 0) {
          //console.log(el.id);
          if (countel > 1) {
            //$("#"+el.id).click();
            $("#" + el.id).find("a").click();
          }

        }

      });
    }, 1000);

  });

  function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
  }

  function genfilecode() {
    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("partial/genfilecode"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
      },
      dataType: "json",
      success: function(data) {
        if (data.filecode != '') {
          $('#hdfilecode').val(data.filecode);
        } else {

        }
      }
    });
  }


  function ajax_update_tabname(id, input) {

    var result = confirm("ต้องการแก้ไขชื่อเมนู ?");
    if (!result) {

      return;
    }

    //var subject = $("#"+subject.id).val(); 
    var oldetabname = $('#e' + input.id).val();

    var tabname = $('#' + input.id).val();
    if (tabname == "") {
      alert('ชื่อเมนูต้องไม่เป็นค่าว่าง กรุณาตรวจสอบ');
      return false;
    }
    if (tabname.length < 6) {
      alert('ชื่อเมนูต้องไม่น้อยกว่า 6 ตัวอักษร');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/updatetabname"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'id': id,
        'obj_id':<?php echo $id; ?>,
        'tabname': tabname,
        'oldetabname': oldetabname,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          alert('แก้ไขชื่อเมนูเรียบร้อย');
        } else {
          alert(data.msg);
        }
      }
    });

}

  function ajax_savedata() {
    //เพิ่มรายการดาวน์โหลด
    var arrlink = [];
    var externallink = '';
    $('input[name^="externallink"]').each(function() {
      externallink = externallink + '&externallink[]=' + $(this).val();
      if (isUrlValid($(this).val())) {
        arrlink.push($(this).val());
      } else {

      }

    });

    if (arrlink.length == 0) {

    }
    $("#btnadd").prop("disabled", true);

    var content = $('#edit').froalaEditor('html.get');
    if (content == "") {
      $("#btnadd").prop("disabled", false);
      alert('กรุณาป้อนข้อมูลเนื้อหา');
      return;
    }

    if ($("#hdobj_id").val() === undefined || $("#hdobj_id").val() === null || $("#hdobj_id").val() === '') {
      $("#btnadd").prop("disabled", false);
      alert('กรุณาคลิกเลือกประเภทไฟล์ในเมนูซ้าย');
      return;
    }

    var result = confirm("ต้องการเพิ่มข้อมูลเนื้อหา ?");
    if (!result) {
      $("#btnadd").prop("disabled", false);
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/savecollection"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'filecode': $('#hdfilecode').val(),
        'content': content,
        'obj_id': $("#hdobj_id").val(),
        'externallink': arrlink,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          $("#btnadd").prop("disabled", false);
          genfilecode();
          checkFields($("#hdobj_id").val());
          initnewlist();
          alert('บันทึกข้อมูลเรียบร้อย');

        } else {
          alert(data.msg);
          $("#btnadd").removeAttr('disabled');
        }
      }
    });
  }

  function ajax_editdata() {

    //แก้ไขรายการดาวน์โหลด
    var arrlink = [];
    var externallink = '';
    $('input[name^="edit_externallink"]').each(function() {
      externallink = externallink + '&edit_externallink[]=' + $(this).val();
      if (isUrlValid($(this).val())) {
        arrlink.push($(this).val());
      } else {

      }

    });

    if (arrlink.length == 0) {

    }
    $("#btnelist").prop("disabled", true);

    var content = $('#edit_subject').froalaEditor('html.get');
    if (content == "") {
      $("#btnelist").prop("disabled", false);
      alert('กรุณาป้อนข้อมูลเนื้อหา');
      return;
    }


    var result = confirm("ต้องการแก้ไขข้อมูลเนื้อหา ?");
    if (!result) {
      $("#btnelist").prop("disabled", false);
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/editlistcollection"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'filecode': $('#fefilecode').val(),
        'content': content,
        'obj_id': $('#hdlist_id').val(),
        'externallink': arrlink,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          $("#btnelist").prop("disabled", false);

          $('div.edit_input_fields_wrap').not(':first').remove();
          $('div.edit_input_fields_wrap:first input').val("");
          $('div.file-wrapper').remove();
          $('#mdEditRole').modal('hide');
          alert('บันทึกการแก้ไขข้อมูลเรียบร้อย');
          //getdatalv3($('#hdmaster_id').val());
          checkFields($('#hdmaster_id').val());
        } else {
          alert(data.msg);
          $("#btnelist").removeAttr('disabled');
        }
      }
    });
  }

  function ajax_addsubject(el, subject) {

    //console.log($(el).data("master"));
    ///console.log($(el).data("ordno_lv2"));

    $("#" + el.id).prop("disabled", true);
    var result = confirm("ต้องการเพิ่มหัวข้อ ?");
    if (!result) {
      $("#" + el.id).removeAttr('disabled');
      return;
    }

    //var subject = $("#"+subject.id).val(); 
    var subject = $('#' + subject.id).froalaEditor('html.get');
    if (subject == "") {
      $("#" + el.id).prop("disabled", false);
      alert('กรุณาป้อนข้อมูลหัวข้อ');
      return;
    }
    if (subject.length < 6) {
      $("#" + el.id).prop("disabled", false);
      alert('ข้อมูลหัวข้อต้องไม่น้อยกว่า 6 ตัวอักษร');
      return;
    }

    var permission = $("#selpermission").val();


    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/addgroupcollection"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'master': $(el).data("master"),
        'permission': permission,
        'subject': subject,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          alert('เพิ่มข้อมูลเรียบร้อย');
          getdatalv3($(el).data("master"));
          $('#addLabelForm').modal('hide');
        } else {
          alert(data.msg);
          $("#" + el.id).prop("disabled", false);
        }
      }
    });

  }

  function ajax_editsubject(el, subject) {

    //console.log($(el).data("master"));
    ///console.log($(el).data("ordno_lv2"));

    $("#" + el.id).prop("disabled", true);
    var result = confirm("ต้องการแก้ไขหัวข้อ ?");
    if (!result) {
      $("#" + el.id).removeAttr('disabled');
      return;
    }

    //var subject = $("#"+subject.id).val(); 
    var subject = $('#' + subject.id).froalaEditor('html.get');
    if (subject == "") {
      $("#" + el.id).prop("disabled", false);
      alert('กรุณาป้อนข้อมูลหัวข้อ');
      return;
    }
    if (subject.length < 6) {
      $("#" + el.id).prop("disabled", false);
      alert('ข้อมูลหัวข้อต้องไม่น้อยกว่า 6 ตัวอักษร');
      return;
    }

    var permission = $("#eselpermission").val();


    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/Editgroupcollection"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'id': $("#hdeid").val(),
        'permission': permission,
        'subject': subject,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          alert('แก้ไขข้อมูลเรียบร้อย');

          //getdatalv3($(el).data("master"));          
          //$("#sub"+ $(el).data("id")).find("a").click();
          $("#sub" + $(el).data("id")).find("a").text($(subject).text());
          //$("#btne").attr("data-edit", encodeURIComponent(subject));

          $('#hdsubject' + $("#hdeid").val()).text(subject);
          $('#esubject').froalaEditor('html.set', "");
          ihdisubject = $('#ihdisubject').val();
          $('#' + ihdisubject).attr("data-read_permission_status", permission);

          $('#editLabelForm').modal('hide');

        } else {
          alert(data.msg);
          $("#" + el.id).prop("disabled", false);
        }
      }
    });

  }

  function getdatalv3(obj_id) {
    $('#divlv3').find('.dropdown-menu a').each(function() {
      var $row = $(this).attr('id');
      if ($row != obj_id) {
        $("#sub" + $row).css("background-color", "");
      } else {
        $("#sub" + obj_id).css("background-color", "#E6E9FD");
      }
    });

    $('.example-dropdown').html("<img src='<?php echo Yii::app()->baseUrl ?>/images/common/loading264.gif' height='30' width='30' /> <br/> Loading...");
    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl('partial/getbranchcollection'); ?>",
      data: {
        obj_id: obj_id,
        YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken; ?>'
      },
      success: function(da) {
        $('.example-dropdown').html("<img src='<?php echo Yii::app()->baseUrl ?>/images/common/loading264.gif' height='30' width='30' /> <br/> Loading...");
        $(".example-dropdown").html(da);
      }
    });

  }

  function getchild(obj_id, el) {
    $('#divlv3').find('.dropdown-menu > .dropdown-item').each(function() {
      var $row = $(this).attr('id');
      if ($row != "sub" + obj_id) {
        $("#" + $row).css("background-color", "");
      } else {
        $("#" + $row).css("background-color", "#E6E9FD");
      }
    });

    $('#htype').html(el.innerText);
    initnewlist();
    checkFields(obj_id);

  }

  function initnewlist() {
    $('div.input_fields_wrap').not(':first').remove();
    $('div.input_fields_wrap:first input').val("");
    $('div.file-wrapper').remove();
    $('#edit').froalaEditor('html.set', "");
  }

  function delchild(el) {

    var result = confirm("ต้องการลบรายการดาวน์โหลด ?");
    if (!result) {
      return;
    }

    content = $(el).parent().parent().prev().text();

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::app()->createAbsoluteUrl("branch/Delcollection"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
        'obj_id': $(el).data("id"),
        'content': content,
      },
      dataType: "json",
      success: function(data) {
        if (data.status == 'success') {
          alert('ลบข้อมูลเรียบร้อย');
          checkFields($(el).data("master"));
        } else {
          alert(data.msg);
        }
      }
    });

  }

  function popupeditsubject(_id, el) {

    //var s = decodeURIComponent($(el).data("edit")).replace(/\+/g, ' '); 
    //permission = decodeURIComponent($(el).data("read_permission_status")); 

    $('#esubject').froalaEditor('html.set', $('#hdsubject' + _id).text());
    permission = $('#' + el.id).attr("data-read_permission_status");
    $("#eselpermission select").val(permission);
    $('#eselpermission').val(permission);
    $('.selectpicker').selectpicker('refresh');
    $("#btne").attr("data-id", _id);
    $("#hdeid").val(_id);
    $("#ihdisubject").val(el.id);
    $('#editLabelForm').modal('show');
  }

  var dataTable;
  var pageinfo;
  function checkFields(group) {
    $("#hdobj_id").val(group);
    $(".grid-error").html("");
    if (typeof dataTable != 'undefined') {
      dataTable.destroy();
    }
    dataTable = $('#productTable1').DataTable({
      responsive: true,
      stateSave: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::app()->createAbsoluteUrl("branch/list_branch_collection"); ?>",
        "data": {
          "FSearch": $("#FSearch1").val(),
          'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
          'id': group,
        },
        type: "post", // method  , by default get
        dataType: "json",
        error: function() { // error handling
          $(".employee-grid-error").html("");
          $("#productTable1").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $("#productTable1_processing").css("display", "none");
        }
      },
      searching: false,
      ordering: false,
      "autoWidth": false,
      "columnDefs": [{
          className: 'reorder',
          "width": "5%",
          "targets": 0,
          visible: false
        },
        {
          className: 'reorder',
          "width": "5%",
          "targets": 1,
          visible:false
        },
        {  
          className: 'reorder',        
          "width": "85%",
          "targets": 2
        },
        {         
          "width": "5%",
          "targets": 3
        },
        //{ targets: [0,1], visible: false }
      ],
      columns: [
        {
          data: 'ordno'
        },
        {
          data: 'id'
        },
        {
          data: 'subject'
        },
        {
          data: 'btn'
        },
      ],
      rowReorder: true,
      rowReorder: {
        //selector: 'tr',
        selector: 'td:first-child, td:nth-child(1)'
      },
      "bLengthChange": true,
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
      "iDisplayLength": 10,
      "initComplete": function(settings, json) {

      },
      "rowCallback": function(row, data) {
        row.childNodes[0].style.textAlign = "left"; 
      },
      "preDrawCallback": function(settings) {

      },
      drawCallback: function(settings) {
        //$("#productTable1_info").parent().toggle(settings.fnRecordsDisplay() > 0);
        //console.log(settings.fnRecordsDisplay());
        if (settings.fnRecordsDisplay() == 0) {
          $('#productTable1').hide();
          $('#productTable1_wrapper').hide();
        } else {
          $('#productTable1').show();
          $('#productTable1_wrapper').show();
          $('.grid-error').html('');
        }
				pageinfo = dataTable.page.info();
        //console.log(pageinfo);
				//console.log(pageinfo.start);

      },


    });

    $('#productTable1_paginate').css("padding-bottom", "10px");
    

    if (!dataTable.data().count()) {
      //$('#productTable1').hide();
      //$('#productTable1_wrapper').hide();
    }

/*
    dataTable.on('row-reorder', function(e, diff, edit) {

      //var result = 'แถวก่อนย้ายตำแหน่ง: ' + edit.triggerRow.data().id + '\n';
      var result ="";
      for (var i = 0, ien = diff.length; i < ien; i++) {
        var rowData = dataTable.row(diff[i].node).data().id;

        result += 'ไอดีข้อมูล' + rowData + ' ตำแหน่งปัจจุบัน ' +
          diff[i].newPosition + '\n (ตำแหน่งใหม่ ' + diff[i].oldPosition + ')\n\n';
          console.log(result);
         
        $.ajax({
          url:"<?php echo Yii::app()->createAbsoluteUrl("content/UpdateCustomlistOrder"); ?>",
          method:"POST",
          data:{
            id_array:id_array, 
            ordno_array:ordno_array,
            dataid:dataid,
            ordno_lv_1:ordno_lv_1,
            oldPosition:ordno_lv_2,
            newPosition:"ordno_lv2",
            'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',,
          },
          success:function(data){
            
          }
        });

      }

    });
*/

      

    dataTable.on('row-reorder.dt', function (e, details, edit) {

      var id_array = new Array();
      var pos_array = new Array();

      if (details.length > 0) {
        for (var i = 0; i < details.length; i++) {

            //console.log(details[i].node.cells[1]);
         
          var id = details[i].node.cells[0].childNodes[0].data
          var newPosition = details[i].newPosition;
          var oldPosition = details[i].oldPosition;
          //console.log(id + ' new position:' + (pageinfo.start + newPosition + 1) );
          //console.log(id + ' old position:' + (oldPosition+1) );
           
          var currentRow = $(this).closest("tr");
          var id = dataTable.row(oldPosition).data().id; 
           
          id_array.push(id); 
          pos_array.push( (pageinfo.start + newPosition + 1) )

        }

        $.ajax({
          url:"<?php echo Yii::app()->createAbsoluteUrl("branch/UpdateCollectionlistOrder"); ?>",
          method:"POST",
          data:{
            id:id, 
            id_array: id_array, 
            pos_array: pos_array,
            newPosition: (newPosition+1),
            oldPosition: (oldPosition+1),
            'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
          },
          success:function(data){
            
          }
        });
      }

    });


  }
</script>
<!-- End Page -->