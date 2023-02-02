<?php

use yii\helpers\Url;

$this->title  = 'จัดการสิทธิ์ผู้ใช้งาน' . Yii::$app->params['prg_ctrl']['pagetitle'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>

<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/tables/datatable.css">

<script src="<?php echo Url::base(true) ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>


<style>
  .page-content-table .table>tbody>tr>td {
    cursor: default;
  }

  ul#yiiPager>li>a {}

  label:hover {
    background: #f2f5ff;
    border-radius: 5px;
    cursor: pointer;
  }


  label {
    margin-left: 32px !important;
  }

  table#Rightlist>tbody>tr>td {
    border: 1px solid #ccc;
  }

  .ui-dialog-titlebar-close {
    display: none;
  }
</style>

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

<!-- Page -->
<div class="page">

  <div class="page-header">
    <h1 class="page-title">จัดการสิทธิ์ผู้ใช้งาน</h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">แอดมิน</li>
      </ol>
    </div>
  </div>

  <div class="page-content container-fluid">

    <?php
    //var_dump(lkup_user::listuser());
    ?>
    <!-- Panel Basic -->
    <div class="panel">

      <div class="panel-body">


        <div class="page-content tab-content nav-tabs-animate">
          <div class="tab-pane animation-fade active show" id="forum-newest" role="tabpanel">
            <div class="container box">

              <div class="row">
                <div class="dataTables_length form-group has-feedback" id="Sorder" style="position: relative; float: left; padding: 0px 0px; margin-bottom: 5px;">

                  <div class="input-group">
                    <input type="text" name="FSearch1" id="FSearch1" class="form-control" placeholder="Login หรือ ชื่อ-นามสกุล" maxlength="20" style="width: 200px" />
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary waves-effect waves-classic" onclick="checkFields();" title="ค้นหา"><i class="icon wb-search" aria-hidden="true"></i></button>
                      <button type="button" class="btn btn-primary waves-effect waves-classic" onclick="sync_data();" title="ปรับปรุงข้อมูล"><i class="icon md-refresh-sync" aria-hidden="true"></i></button>


                    </span>

                  </div>
                </div>
              </div>
              <div class="sync_progress text-center"></div>

              <div class="row">
                <div class="table-responsive">

                  <table id="Table1" class="table table-hover dataTable table-striped w-full">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>รหัสผู้ใช้</th>
                        <th>ชื่อ Login</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>รหัสหน่วยงาน</th>
                        <th>อีเมล</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>ยกเลิกสิทธิ์</th>
                        <th>จัดการ</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- Modal -->
    <div class="modal fade modal-info" id="mdEditRole" aria-hidden="true" aria-labelledby="mdEditRole" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple modal-center">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="icon fa-close" style="color: #000;" aria-hidden="true"></i>
            </button>
            <h4 class="modal-title">แก้ไขสิทธิ์การใช้งาน</h4>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

    <!-- Sync Dialog -->

    <script type="text/javascript">
      function sync_data() {

        var result = confirm("ระบบการซิงค์ข้อมูลอาจใช้เวลานาน ต้องการทำงานต่อหรือไม่ ?");
        if (!result) {
          return;
        }

        $.ajax({
          url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("partial/sync_ldap"); ?>",
          method: "POST",
          cache: false,
          data: {
            '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
            'rand': '<?php echo time(); ?>',
          },
          success: function(data) {
            $(".sync_progress").html(data);
          }
        });

        $('div.sync_progress').dialog({
          closeOnEscape: false,
          modal: true,
          resizable: false,
          title: "ซิงค์ข้อมูลใน LDAP",
          open: function() {
            var win = $(window);

            $(this).parent().css({
              position: 'absolute',
              left: (win.width() - $(this).parent().outerWidth()) / 2,
              top: (win.height() - $(this).parent().outerHeight()) / 2
            });
            $('.ui-dialog').css({
              'z-index': 20000 // Could be any value but less than 1000.
            });
            $('.sync_progress').css('overflow', 'hidden');

          },
          close: function() {
            $(".sync_progress").html('');
            $('.ui-dialog-titlebar-close').css("display", "none");
            checkFields();
          },
          minWidth: 600,
          minHeight: 400,

        });
      }
      jQuery(document).ready(function($) {
        $(window).resize(function() {
          //$(".sync_progress").dialog("option", "position", "center");
        });

      });
    </script>
    <!-- Sync Dialog -->


  </div>
</div>
<script type="text/javascript">
  $("#mdEditRole").on("show.bs.modal", function(e) {

    var _button = $(e.relatedTarget);
    var user_id = $(_button).data("user_id");
    var ssobranch_code = $(_button).data("ssobranch_code");

    var _row = _button.parents("tr");

    $.ajax({
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("modal/listuserrole"); ?>",
      method: "POST",
      data: {
        'user_id': user_id,
        'ssobranch_code': ssobranch_code,
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
      },
      success: function(data) {
        $(".modal-body").html(data);
        //alert(data);
        $('.table.is-indent thead').hide();
      }
    });

  });


  jQuery(document).ready(function($) {



    checkFields();


  });

  var dataTable;

  function checkFields() {

    $.fn.dataTable.ext.legacy.ajax = false;
    $(".employee-grid-error").html("");
    if (typeof dataTable != 'undefined') {
      dataTable.destroy();
    }
    dataTable = $('#Table1').DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/listuser"); ?>",
        "data": {
          "FSearch": $("#FSearch1").val(),
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        },
        type: "post", // method  , by default get
        dataType: "json",
        error: function() { // error handling
          $(".employee-grid-error").html("");
          $("#Table1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $("#Table1_processing").css("display", "none");
        }
      },
      searching: false,
      ordering: false,
      "autoWidth": false,
      "columnDefs": [{
        "className": "dt-left",
        "targets": "_all"
      }, ],
      "initComplete": function(settings, json) {
        $("time.timeago").timeago();
      },
      dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "drawCallback": function(settings) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch_work_status'));
        elems.forEach(function(el) {
          var init = new Switchery(el, {
            secondaryColor: '#ff4c52'
          });
          el.onchange = function() {
            var status = 0;
            if ($(this).is(':checked')) {
              status = 1;
            } else {
              status = 0;
            }

            $.ajax({
              url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/updateuserworkstatus"); ?>",
              method: "POST",
              data: {
                id: $(this).data("id"),
                old_status: $(this).data("status"),
                status: status,
                '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
              },
              success: function(data) {}
            });
          };
        });
        $('.grid-error').html('');
        pageinfo = dataTable.page.info();
        //console.log(pageinfo.start);
      }

    });
    $('select[name=Table1_length]').addClass("form-control");
    $('select[name=Table1_length]').css("width", "70px");
    //$("#Table1_length").after("<div class='dataTables_length'><input type='text' name='FSearch1' id='Search1' value='' class='form-control' placeholder='ชื่อ หรือ นามสกุล' maxlength='20' /></div>");

  }

  function ajax_update(el, id) {

    //console.log($("#"+el.id).prev() ); 
    var dataprev = $("#" + el.id).prev().val();
    var previtem = $("#" + el.id).prev().prev().data('item');

    if (previtem == "name") {
      if (dataprev == "") {
        $("#" + el.id).prop("disabled", false);
        alert('กรุณาป้อนข้อมูลหัวข้อ');
        return;
      }
      if (dataprev.length < 6) {
        $("#" + el.id).prop("disabled", false);
        alert('ข้อมูลหัวข้อต้องไม่น้อยกว่า 6 ตัวอักษร');
        return;
      }
    } else if (previtem == "url") {
      if (dataprev == "") {
        $("#" + el.id).prop("disabled", false);
        alert('กรุณาป้อนข้อมูลลิงค์');
        return;
      }
      if (dataprev.length < 12) {
        $("#" + el.id).prop("disabled", false);
        alert('ข้อมูลลิงค์ต้องไม่น้อยกว่า 12 ตัวอักษร');
        return;
      }
    }

    $("#" + el.id).prop("disabled", true);
    var result = confirm("ต้องการแก้ไขเมนู ?");
    if (!result) {
      $("#" + el.id).removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/UpdateAppValue"); ?>",
      data: {
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        'dataprev': dataprev,
        'dataitem': previtem,
        'id': id,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          $("#" + el.id).prop("disabled", false);
          alert('แก้ไขข้อมูลเรียบร้อย');
          //window.location.href='<?php echo $_SERVER['REQUEST_URI']; ?>';  

          $("#" + el.id).prev().hide();
          $("#" + el.id).hide();
          $("#" + el.id).prev().prev().html(dataprev);
          $("#" + el.id).prev().prev().show();
          click = 0;
        } else {
          alert(data.msg);
          $("#" + el.id).prop("disabled", false);
        }
      }
    });
  }

  function ajax_adddata(el, subject, url_link) {

    //console.log($(el).data("master"));
    ///console.log($(el).data("ordno_lv2"));

    $("#" + el.id).prop("disabled", true);
    var result = confirm("ต้องการเพิ่มเมนู ?");
    if (!result) {
      $("#" + el.id).removeAttr('disabled');
      return;
    }

    var subject = $("#" + subject.id).val();
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

    var url_link = $("#" + url_link.id).val();
    if (url_link == "") {
      $("#" + el.id).prop("disabled", false);
      alert('กรุณาป้อนข้อมูลลิงค์');
      return;
    }
    if (url_link.length < 12) {
      $("#" + el.id).prop("disabled", false);
      alert('ข้อมูลลิงค์ต้องไม่น้อยกว่า 12 ตัวอักษร');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/AddnewApp"); ?>",
      data: {
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        'master': $(el).data("master"),
        'ordno_lv2': $(el).data("ordno_lv2"),
        'subject': subject,
        'url_link': url_link,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('เพิ่มข้อมูลเรียบร้อย');
          window.location.href = '<?php echo $_SERVER['REQUEST_URI']; ?>';
        } else {
          alert(data.msg);
          $("#" + el.id).prop("disabled", false);
        }
      }
    });

  }

  function ajax_updata(id) {
    var result = confirm("ต้องการลบแอฟ ?");
    if (!result) {
      return;
    }

    $.ajax({
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/UpdateAppStatus"); ?>",
      method: "POST",
      data: {
        id: id,
        status: 0,
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
      },
      success: function(data) {
        alert('ลบข้อมูลแอฟเรียบร้อย');
        window.location.href = '<?php echo $_SERVER['REQUEST_URI']; ?>';
      }
    });

  }

  function ajax_deldata(id) {
    $("#btnadd").prop("disabled", true);
    var result = confirm("ต้องการลบเนื้อหา ?");
    if (!result) {
      $("#btnadd").removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("content/Delete_content"); ?>",
      data: {
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        'content_id': id,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('ลบข้อมูลเรียบร้อย');
          window.location.href = '<?php echo $_SERVER['REQUEST_URI']; ?>';
        } else {
          alert(data.msg);
          $("#btnadd").removeAttr('disabled');
        }
      }
    });

  }

  function ajax_undo(el) {

    $(el).prev().hide();
    $(el).prev().prev().hide();
    $(el).prev().prev().prev().show();
    //$(el).prev().prev().prev().hide();
    $(el).hide();
    click = 0;
    //endEdit(el.id);
  }

  var defaultText = 'Click me and enter some text';

  function endEdit(e) {
    var input = $(e.target),
      label = input && input.prev();
    btn = input && input.next();

    label.text(input.val() === '' ? defaultText : input.val());
    input.hide();
    btn.hide();
    label.show();
  }

  var click = 0;
  $('.clickedit').hide()
    //.focusout(endEdit)
    .focusout(function(e) {
      if (!$(e.target).is(":button")) {
        //endEdit(e);
      }
    })
    .keyup(function(e) {
      if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        endEdit(e);
        return false;
      } else {
        return true;
      }
    })
    .prev().click(function() {
      if (click > 0) return;
      defaultText = $(this).text();
      width = $(this).innerWidth();
      $(this).next().val(defaultText);
      $(this).next().width(width + 5);
      $(this).next().show().focus();
      $(this).next().next().show();
      $(this).next().next().next().show();
      $(this).hide();
      click += 1;
      console.log(click);
    });
</script>
<!-- End Page -->