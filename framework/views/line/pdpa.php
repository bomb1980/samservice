<?php

use yii\helpers\Url;

$this->title  = 'LINE Rich menu ' . Yii::$app->params['prg_ctrl']['pagetitle'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>
<META http-equiv="expires" content="0">

<!-- Include Font Awesome. -->
<link href="<?php echo Url::base(true); ?>/vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Url::base(true); ?>/vendor/font-awesome/css/v4-shims.min.css" rel="stylesheet" type="text/css" />

<!-- Include Froala Editor styles -->
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/froala_editor.min.css" />
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/froala_style.min.css" />

<!-- Include Froala Editor Plugins styles -->
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/emoticons.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/file.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/image_manager.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/image.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/css/plugins/video.css">

<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/uploadify/uploadifive.css" />

<!-- Include Froala Editor -->
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/froala_editor.min.js"></script>

<!-- Include Froala Editor Plugins -->
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/align.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/char_counter.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/code_view.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/colors.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/emoticons.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/entities.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/file.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/font_family.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/font_size.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/image.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/image_manager.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/inline_style.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/link.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/lists.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/quote.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/save.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/table.min.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/plugins/video.min.js"></script>

<script src="<?php echo Url::base(true); ?>/vendor/uploadify/jquery.uploadifive.js"></script>

<!-- Include the language file. -->
<script src='<?php echo Url::base(true); ?>/vendor/froala/wysiwyg-editor/js/languages/th.js'></script>

<style>
  div.fr-wrapper>div>a {
    /* display: none !important; */
    /* position: fixed; */
    /* z-index: -99999 !important; */
    font-size: 0px !important;
    padding: 0px !important;
    height: 0px !important;
  }

  .block1 {
    max-width: 350px;
    max-height: 390px;
    overflow: auto;
    display: block;
    overflow-y: scroll;
  }

  .block2 {
    display: inline-block;
    vertical-align: top;
    overflow: hidden;
    border-right: 1px solid #a4a4a4;
  }
</style>

<div class="page">

  <?php
  $btnVisible = false;
  if ($user_role == 2) { //ถ้าหน่วยงานตรง และมีสิทธิ์เป็น 2
    $btnVisible = true;
  }

  if ($user_role == 1) {  //แอดมินสูงสุดของโมดูล
    $btnVisible = true;
  }

  $content = "";
  $curpage = "สร้าง";
  if ($data != null) {
    $items = (array)$data[0];
    $content = $items['text'];
    $curpage = "แก้ไข";
  }

  /*
  $array = array(
    'userId' => 'U37d3a5f0191f7ccc298979b769971f24',
    'richMenuId' => 'richmenu-58205875913c5b914201f84bf4db7f3f'
  );

  $jsonDataEncoded = json_encode($array, JSON_UNESCAPED_SLASHES);
  $json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_PRETTY_PRINT);
  echo $json_pretty;
  exit;
*/

  $arrids = array(
    'U37d3a5f0191f7ccc298979b769971f24',
    'U37d3a5f0191f7ccc298979b769971f24',
    'U37d3a5f0191f7ccc298979b769971f24'
  );
  $array = array(
    'richMenuId' => 'richmenu-58205875913c5b914201f84bf4db7f3f',
    'userIds' => $arrids
  );
  /*
  $jsonDataEncoded = json_encode($array, JSON_UNESCAPED_SLASHES);
  $json_pretty = json_encode(json_decode($jsonDataEncoded), JSON_PRETTY_PRINT);
  echo $json_pretty;
  exit; */

  ?>

  <div class="page-header">
    <h1 class="page-title">LINE PDPA</h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl("/line/listpdpa")  ?>">รายการ</a></li>
        <li class="breadcrumb-item atcitve"><?php echo $curpage; ?></li>
      </ol>
    </div>
  </div>

  <div class="page-content">


    <div class="panel">
      <div class="panel-body container-fluid">

        <div class="form-group row pl-5 required" style="border-bottom: 1px solid #ebebeb;">
          <div class="col-md-8">
            <h3>ข้อความพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล</h3>
          </div>
        </div>
        <div class="content-wrap">

          <div id="op-group21" style="border-bottom: 1px solid #ebebeb; margin-top: 1.429rem;">

            <div class="form-group row pl-5 required">
              <label class="col-md-2 col-form-label control-label">ข้อความ</label>
              <div class="col-md-10">
                <textarea class="form-control" id="pdpa_text" name="pdpa_text"><?php echo $content; ?></textarea>
              </div>
            </div>


            <script>
              $(function() {
                $('#pdpa_text').froalaEditor({
                  language: 'th',

                  toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertTable', '|', 'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
                  heightMin: 200,
                  toolbarStickyOffset: 50,
                  toolbarSticky: false,
                  width: '100%',
                })


              });
            </script>

          </div>

          <div class="form-group row pl-5 pt-10">
            <div class="col-md-8 form-inline">

              <?php
              if ($data != null) {
                if (count($data) != 0) {
              ?>
                  <div class="col-md-4 form-inline">

                    <label class="radio-inline">
                      <input name="pdpa_type" id="rdo_edit" value="edit" type="radio" checked />แก้ไขข้อความ
                    </label>
                    <label class="radio-inline">
                      <input name="pdpa_type" id="rdo_newversion" value="newver" type="radio" />อัพเดตเวอร์ชั่น
                    </label>

                  </div>

                  <div class="custom-control pr-20">
                    <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_edit();">ปรับปรุง PDPA</button>
                  </div>

                <?php
                } else {
                ?>
                  <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_save();">สร้าง PDPA</button>
                <?php
                }
              } else {
                ?>
                <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_save();">สร้าง PDPA</button>
              <?php
              }

              ?>


            </div>
          </div>

          <!-- The Modal -->
          <div class="modal" id="uidModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="cursor: move;">
                  <h4 class="modal-title">รายการเมนู</h4>
                  <button type="button" class="close" data-dismiss="modal">
                    <i class="icon fa-close" aria-hidden="true"></i>
                  </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="uidModalBody">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <input type="hidden" id="keyid" value="">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>
          <!-- End Dialog -->


        </div>
      </div>
    </div>

  </div>


</div>

</div>


<script type="text/javascript">
  jQuery(document).ready(function($) {


    $("#btnClear").click(function() {
      $("#txtSearch").val("");
      checkFields(1);
    });

    $('#selDepartment').selectpicker({
      iconBase: 'fa',
      tickIcon: 'fa-check'
    });
    $('#selDepartment').on('changed.bs.select', function(e, clickedIndex) {
      if (clickedIndex !== 0) {
        return;
      }
      if (this.value === '0') {
        return $(this).selectpicker('selectAll');
      }
      $(this).selectpicker('deselectAll');
    });

    $("#yiiPager").find('>li >a').addClass("page-link");
    $("div.summary").remove();
    $("#list-grid").removeClass("grid-view");
    $('#selDepartment option').attr("selected", "selected");
    $('#selDepartment').selectpicker('refresh');
  });

  var dataTable;
  var dataTable2;
  var dataTable3;

  $(document).ready(function() {

    $("#uidModal").draggable({
      handle: ".modal-header",
      cursor: "move"
    });


    $("#uidModal").on('show.bs.modal', function() {
      var id = $("#keyid").val();

      $.ajax({
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("modal/richmenu"); ?>",
        method: "POST",
        data: {
          id: id,
          YII_CSRF_TOKEN: '<?php echo Yii::$app->request->csrfToken; ?>',
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        },
        success: function(data) {
          $("#uidModalBody").html(data);
          //alert(data);
          $('.table.is-indent thead').hide();
        }
      });


    });
  });


  function checkFields(type_id) {
    if (type_id == 1) {
      var tbel = "#productTable1";
    } else if (type_id == 2) {
      var tbel = "#productTable2";
    }
    $(".employee-grid-error").html("");
    if (typeof dataTable != 'undefined') {
      dataTable.destroy();
    }

    var search = $("#txtSearch").val();

    dataTable = $(tbel).DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json",
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/listback"); ?>",
        "data": {
          'search': search,
          'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          'type_id': type_id,
        },
        type: "post",
        dataType: "json",
        error: function() {
          $(".employee-grid-error").html("");
          $(tbel).append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $(tbel + "_processing").css("display", "none");
        }
      },
      searching: false,
      ordering: false,
      "autoWidth": false,
      "bLengthChange": false,
      "iDisplayLength": 10,
      "initComplete": function(settings, json) {
        $("#btnSearch").removeAttr("disabled");
        $("#btnSearch").removeClass("disabled");
      },
      "rowCallback": function(row, data) {
        /*var li = $(document.createElement('li'));
        for (var i = 0; i < data.length; i++) {
        	li.append(data[i]);
        }
        li.appendTo('#new-list');
        $("#new-list").css("min-height", '');*/
      },
      "columnDefs": [{
        "targets": [1],
        "visible": false
      }],
      "preDrawCallback": function(settings) {
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list').empty();
      },
      "drawCallback": function(settings) {

      },
      createdRow: function(row, data, index) {
        var pageUrl = '<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/view") ?>/' + data[1];
        var newLink = '<a href="' + pageUrl + '" target="_blank" style="text-decoration: none;" >' + data[2] + '</a>';
        //$($('td', row).eq(1)).html(newLink);
      }
    });
    $(tbel + '_paginate').css("padding-bottom", "10px");

    var someVar = 'ไม่มีรายการเมนู';

    dataTable.on('draw.dt', function() {
      var $empty = $(tbel).find('.dataTables_empty');
      if ($empty) $empty.html(someVar)
    })

  }


  function ajax_save() {
    $("#btnadd").prop("disabled", true);

    /*
        var pdpa_type = $('input[name="pdpa_type"]:checked').val();
        if (pdpa_type === null || pdpa_type === undefined) {
          alert("Please select Detention");
          $('html, body').animate({
            scrollTop: $("#rdo_edit").offset().top - 100
          }, 1500);
          $("#rdo_edit").focus();
          $("#btnadd").prop("disabled", false);
          return;
        }
    */
    var content = $('#pdpa_text').froalaEditor('html.get');
    if (content == "") {

      $('html, body').animate({
        scrollTop: $("#pdpa_text").offset().top - 100
      }, 1500);
      $("#pdpa_text").focus();

      $("#btnadd").prop("disabled", false);
      alert('กรุณาเพิ่มข้อมูล PDPA');
      return;
    }


    var result = confirm("ต้องการสร้างข้อความข้อตกลง PDPA ?");
    if (!result) {
      $("#btnadd").prop("disabled", false);
      return;
    }


    $.ajax({
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/line/savepdpa"); ?>",
        method: "POST",
        dataType: "json",
        data: {
          content: content,
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        },
      })
      .done(function(data) {

        if (data.status == 'success') {
          $("#btnadd").prop("disabled", false);
          alert('เพิ่มข้อความข้อตกลง PDPA เรียบร้อย');
          window.location.href = '' + data.msg + '';
        } else {
          alert(data.msg);
          $("#btnadd").prop("disabled", false);
        }

      })
      .fail(function(jqXHR, status, error) {
        // Triggered if response status code is NOT 200 (OK)
        //alert(jqXHR.responseText);

      })
      .always(function() {
        $("#btnadd").prop("disabled", false);
      });


  }
</script>

<?php
if ($data != null) {
  if (count($data) != 0) {
?>

    <script type="text/javascript">
      function ajax_edit() {
        $("#btnadd").prop("disabled", true);

        var content = $('#pdpa_text').froalaEditor('html.get');
        if (content == "") {
          $('html, body').animate({
            scrollTop: $("#pdpa_text").offset().top - 100
          }, 1500);
          $("#pdpa_text").focus();

          $("#btnadd").prop("disabled", false);
          alert('กรุณาเพิ่มข้อมูล PDPA');
          return;
        }

        var pdpa_type = $('input[name="pdpa_type"]:checked').val();
        if (pdpa_type === null || pdpa_type === undefined) {
          alert("กรุณาเลือกว่าจะแก้ไขข้อความหรืออัพเดตเวอร์ชั่น");
          $('html, body').animate({
            scrollTop: $("#rdo_edit").offset().top - 100
          }, 1500);
          $("#rdo_edit").focus();
          $("#btnadd").prop("disabled", false);
          return;
        }

        var result = confirm("ต้องการแก้ไขข้อความข้อตกลง PDPA ?");
        if (!result) {
          $("#btnadd").prop("disabled", false);
          return;
        }

        $.ajax({
          url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("line/editpdpa"); ?>",
          method: "POST",
          dataType: "json",
          data: {
            id: <?php echo $id; ?>,
            content: content,
            pdpa_type :pdpa_type,
            '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          },
          success: function(data) {
            if (data.status == 'success') {
              $("#btnadd").prop("disabled", false);
              alert('แก้ไขข้อความข้อตกลง PDPA เรียบร้อย');
              window.location.href = '' + data.msg + '';
            } else {
              alert(data.msg);
              $("#btnadd").prop("disabled", false);
            }

          }
        });

      }
    </script>

<?php
  }
}

?>