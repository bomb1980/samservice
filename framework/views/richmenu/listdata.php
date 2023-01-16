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

<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/vendor/tab/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/vendor/dotdotdot/dotdotdot.js"></script>

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


  ?>

  <div class="page-header">
    <h1 class="page-title">รายการ LINE Rich menu</h1>
  </div>

  <div class="page-content">


    <div class="panel">
      <div class="panel-body container-fluid">


        <div class="content-wrap panel-body" style="border-top: 1px solid #ebebeb;">

          <div class="col-lg-auto" style="margin: 0 auto;max-width: 1200px;">
            <div class="form-inline">
              <h4 class="example-title">ค้นหา</h4>
            </div>
            <div class="form-inline">
              <div class="form-group form-material">
                <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="ชื่อเมนู" autocomplete="off">
              </div>
              <div class="form-group form-material">
                <button type="submit" onclick="checkFields(1);" class="btn btn-primary waves-effect waves-classic" name="btnSearch" id="btnSearch" title="ค้นหา"><i class="fa fa-search" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-primary waves-effect waves-classic ml-5" name="btnClear" id="btnClear" title="เคลียร์"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                <?php
                if ($btnVisible) {
                ?>
                  <button type="button" onclick="location.href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/create"); ?>';" class="btn btn-primary waves-effect waves-classic ml-5" name="btnCreate" id="btnCreate" title="สร้าง Rich menu">สร้าง Rich menu</button>
                <?php
                }
                ?>
              </div>
            </div>
          </div>

          <table id="productTable1" class="table table-striped table-hover table-bordered tableUpdated">
            <thead>
              <tr>
                <th style="width: 5%;">#</th>
                <th>ID</th>
                <th scope="col">ชื่อเมนู</th>
                <th scope="col">Rich Menu id</th>
                <th style='width:20%'>จัดการ LINE</th>
                <th style='width:20%'>จัดการ</th>
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
    jQuery("time.timeago").timeago();
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
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/listback"); ?>",
        "data": {
          'search': search,
		      '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
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
        "visible": true
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

  function ajax_setdefault(_this, id) {
    var result = confirm("ต้องการตั้งค่าให้เป็นเมนูเริ่มต้น ?");
    if (!result) {
      $(_this).removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/setdefaultmenu"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
		    '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
        'id': id,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('ตั้งค่าให้เป็นเมนูเริ่มต้นในระบบไลน์เรียบร้อย');
          checkFields(1);
        } else {
          alert(data.msg);
          $(_this).removeAttr('disabled');
        }
      }
    });

  }

  function ajax_push(_this, id) {
    var result = confirm("ต้องการส่งเมนูเข้าไปในระบบไลน์ ?");
    if (!result) {
      $(_this).removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/pushmenu"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
		    '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
        'id': id,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('ส่งเมนูเข้าไปในระบบไลน์เรียบร้อย');
          checkFields(1);
        } else {
          alert(data.msg);
          $(_this).removeAttr('disabled');
        }
      }
    });

  }

  function ajax_unpush(_this, id) {
    var result = confirm("ต้องการลบเมนูออกจากไลน์ ?");
    if (!result) {
      $(_this).removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/unpushmenu"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
		    '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
        'id': id,
      },
      dataType: "json",
      success: function(data) { 
        if (data.msg == 'success') {
          alert('ลบเมนูออกจากไลน์เรียบร้อย');
          checkFields(1);
        } else {
          alert(data.msg);
          $(_this).removeAttr('disabled');
          checkFields(1);
        }
      }
    });

  }

  function ajax_deldata(_this, id) {

    var $this = $(_this);
    $(_this).prop('disabled', true);

    var result = confirm("ต้องการลบเมนู ?");
    if (!result) {
      $(_this).removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/delete_richmenu"); ?>",
      data: {
        'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
		    '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
        'content_id': id,
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('ลบข้อมูลเรียบร้อย');
          window.location.href = '<?php echo $_SERVER['REQUEST_URI']; ?>';
        } else {
          alert(data.msg);
          $(_this).removeAttr('disabled');
        }
      }
    });

  }
</script>