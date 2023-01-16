<?php

use yii\helpers\Url;

$this->title  = 'LINE Rich menu ' . Yii::$app->params['prg_ctrl']['pagetitle'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>
<META http-equiv="expires" content="0">

<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/tables/datatable.css">

<script type="text/javascript" src="<?php echo Url::base(true); ?>/vendor/tab/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Url::base(true); ?>/vendor/dotdotdot/dotdotdot.js"></script>

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

<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>

<style>
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

  $subject = "";
  $message = "";
  $section = "";
  $curpage = "สร้าง";
  if ($data != null) {
    $items = (array)$data[0];
    $subject = $items['subject'];
    $message = $items['message'];
    $section = $items['section_type'];
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
    <h1 class="page-title">LINE Report</h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl("/line/list")  ?>">รายการ</a></li>
        <li class="breadcrumb-item atcitve"><?php echo $curpage; ?></li>
      </ol>
    </div>
  </div>

  <div class="page-content">


    <div class="panel">
      <div class="panel-body container-fluid">

        <div class="form-group row pl-5 required" style="border-bottom: 1px solid #ebebeb;">
          <div class="col-md-8">
            <h3>รายงานการ login การเข้าใช้งานแต่ละวันของผู้ประกันตนตามมาตรา</h3>
          </div>
        </div>
        <div class="content-wrap">

          <div class="col-lg-auto" style="margin: 0 auto;max-width: 1200px;">
            <div class="form-inline">
              <h4 class="example-title">ค้นหา</h4>
            </div>
            <div class="form-inline">
              <div class="form-group form-material">
                <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="หัวข้อ หรือข้อความ " style="display: none;" autocomplete="off">
              </div>
              <div class="form-group form-material">
								<input type="text" class="form-control" id="starts" name="starts" placeholder="วันที่เริ่มต้น" autocomplete="off">
							</div>
							<div class="form-group form-material">
								<input type="text" class="form-control" id="ends" name="ends" placeholder="วันที่สิ้นสุด" autocomplete="off">
							</div>
              <div class="form-group form-material">
                <button type="submit" onclick="checkFields(1);" class="btn btn-primary waves-effect waves-classic" name="btnSearch" id="btnSearch" title="ค้นหา"><i class="fa fa-search" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-primary waves-effect waves-classic ml-5" name="btnClear" id="btnClear" title="เคลียร์"><i class="fa fa-refresh" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>

          <table id="productTable1" class="table table-striped table-hover table-bordered tableUpdated">
            <thead>
              <tr>
                <th style="width: 5%;">#</th>
                <th>ID</th>
                <th scope="col">วัน</th>
                <th scope="col">มาตรา 33</th>
                <th scope="col">มาตรา 38</th>
                <th scope="col">มาตรา 39</th>
                <th scope="col">มาตรา 40</th>
                <th scope="col">ลาออก</th>
                <th scope="col">รวมทุกกรณี</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>


        </div>
      </div>
    </div>

  </div>


</div>

</div>


<script type="text/javascript">
  function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv", ".txt", ".text");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
        validExts.toString() + " types.");
      return false;
    } else {
      var file = $('#uploadBtn')[0].files[0].name;
      document.getElementById("line_subject").value = file;
      return true;
    }
  }

  jQuery(document).ready(function($) {

    $('#uploadBtn').change(function() {
      //var file = $('#uploadBtn')[0].files[0].name;
      //document.getElementById("line_subject").value = file;
    });


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
    jQuery("time.timeago").timeago();
    $("#yiiPager").find('>li >a').addClass("page-link");
    $("div.summary").remove();
    $("#list-grid").removeClass("grid-view");
    $('#selDepartment option').attr("selected", "selected");
    $('#selDepartment').selectpicker('refresh');


    jQuery.datetimepicker.setLocale('th');
		jQuery('#starts').datetimepicker({			
			format: 'd/m/Y',
			lang: 'th',
			step: 10,
			yearStart: 2015,
			timepicker:false,
		});

		jQuery('#ends').datetimepicker({
			format: 'd/m/Y',
			lang: 'th',
			step: 10,
			yearStart: 2015,
			onChangeDateTime: function(dp, $input) {

			},
			timepicker:false,
		});

		//var formDate = moment().format("D/MM/YYYY 00:00");
				var formDate = "01/01/2020";
		$('#starts').val(formDate);
				formDate = moment().format("DD/MM/YYYY");
		$('#ends').val(formDate);

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

  $(document).ready(function() {
    checkFields(1);
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
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("report/listoverduenotify"); ?>",
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


  function ajax_savepermission() {
    $("#btnadd").prop("disabled", true);

    var typenoti = $("input[name='rdoselM39']:checked").val();
    if (typenoti === undefined) {
      alert('กรุณาเลือกประเภทการแจ้งเตือนข้อความ');
      return;
    }

    if (document.getElementById("uploadBtn").files.length == 0) {
      console.log("no files selected");

      $('html, body').animate({
        scrollTop: $("#uploadBtn").offset().top - 100
      }, 2000);
      $("#uploadBtn").focus();

      $("#btnadd").prop("disabled", false);
      alert('กรุณาเลือกไฟล์');
      return;

    }

    var line_message ="";
    
    var line_message = $("#line_message").val();
    if (line_message == "") {
      $('html, body').animate({
        scrollTop: $("#line_message").offset().top - 100
      }, 2000);
      $("#line_message").focus();

      $("#btnadd").prop("disabled", false);
      alert('กรุณาป้อนข้อความที่จะส่งให้ผู้ประกันตน');
      return;
    }


    var result = confirm("ต้องการนำเข้าและส่งออก Line ID สำหรับส่งให้ผู้ประกันตน ม.39 ?");
    if (!result) {
      $("#btnadd").prop("disabled", false);
      return;
    }

    var data = new FormData();
    data.append('uploadBtn', $('#uploadBtn')[0].files[0]);
    data.append('line_message', line_message);
    data.append('typenoti', typenoti);
    data.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->getCsrfToken() ?>');


    $.ajax({
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/line/saveoverduenotify"); ?>",
        method: "POST",
        dataType: "text",
        enctype: 'multipart/form-data',
        contentType: false,
        cache: false,
        processData: false,
        data: data,
        beforeSend: function() {
          $('#imgprocess').show();
        },
      })
      .done(function(data) {

        if (data.indexOf("error:") >= 0) {
          var array = data.split(":");
          alert(array[1]);
          return
        }

        let blob = new Blob([data], {
          type: "application/octetstream"
        });

        let a = document.createElement('a');
        a.href = window.URL.createObjectURL(blob);

        var d = new Date();
        year = d.getFullYear();
        month = ("0" + (d.getMonth() + 1)).slice(-2);
        day = ("0" + d.getDate()).slice(-2)

        var hour = ('0' + d.getHours()).slice(-2);
        var mins = ('0' + d.getMinutes()).slice(-2);
        var sec = ('0' + d.getSeconds()).slice(-2);

        var fileName = 'download_' + year + month + day + "_" + hour + mins + sec;
        a.download = fileName + ".txt";;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        checkFields(1);

        /*
                if (data.status == 'success') {
                  $("#btnadd").prop("disabled", false);
                  alert('เพิ่มข้อความสำหรับส่งให้สมาชิกเรียบร้อย');
                  window.location.href = '' + data.msg + '';
                } else {
                  alert(data.msg);
                  $("#btnadd").prop("disabled", false);
                }
        */
      })
      .fail(function(jqXHR, status, error) {
        // Triggered if response status code is NOT 200 (OK)
        //alert(jqXHR.responseText);

      })
      .always(function() {
        $('#imgprocess').hide();
        $("#btnadd").prop("disabled", false);
      });


  }
</script>

<?php
if ($data != null) {
  if (count($data) != 0) {
?>

    <script type="text/javascript">
      function ajax_editpermission() {
        $("#btnadd").prop("disabled", true);

        var line_subject = $("#line_subject").val();
        if (line_subject == "") {
          $('html, body').animate({
            scrollTop: $("#line_subject").offset().top - 100
          }, 2000);
          $("#line_subject").focus();

          $("#btnadd").prop("disabled", false);
          alert('กรุณาป้อนหัวข้อคำอธิบาย');
          return;
        }

        var line_message = $("#line_message").val();
        if (line_message == "") {
          $('html, body').animate({
            scrollTop: $("#line_message").offset().top - 100
          }, 2000);
          $("#line_message").focus();

          $("#btnadd").prop("disabled", false);
          alert('กรุณาป้อนข้อความที่จะส่งให้สมาชิก');
          return;
        }

        var section = $("#selsection").val();
        //var arrsel = [];
        var arrsel = new Array();
        $("#select2 option").each(function() {
          arrsel.push($(this).val());
        });

        if (arrsel.length == 0) {
          alert('กรุณาเพิ่มหน่วยงานผู้ประกันตน');
          $("#btnadd").prop("disabled", false);
          return;
        }

        var result = confirm("ต้องการแก้ไขข้อความสำหรับส่งให้สมาชิก ?");
        if (!result) {
          $("#btnadd").prop("disabled", false);
          return;
        }

        $.ajax({
          url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("line/editmessage"); ?>",
          method: "POST",
          dataType: "json",
          data: {
            id: <?php echo $id; ?>,
            line_subject: line_subject,
            line_message: line_message,
            section: section,
            perselect: arrsel.join(),
            YII_CSRF_TOKEN: '<?php echo Yii::$app->request->csrfToken; ?>',
            '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          },
          success: function(data) {
            if (data.status == 'success') {
              $("#btnadd").prop("disabled", false);
              alert('แก้ไขข้อความสำหรับส่งให้สมาชิกเรียบร้อย');
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