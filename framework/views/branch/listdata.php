<?php
        $this->pageTitle  = 'หน่วยงาน ' . Yii::app()->params['prg_ctrl']['pagetitle'];
        $themesurl = Yii::app()->params['prg_ctrl']['url']['themes'];
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

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/tab/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/dotdotdot/dotdotdot.js"></script>

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

<script src="<?php echo Yii::app()->baseUrl ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>

<style>
  .page {
    background: white;
  }

  .page-content-table .table>tbody>tr>td {
    cursor: default;
  }

  ul#yiiPager>li>a {}

  .panel-line.panel-info .panel-heading {
    color: #4A7800;
    background: 0 0;
    border-top-color: #4A7800;
  }

  .info-wrap {
    color: #76838f;
    text-align: left;
  }

  .panel-line.panel-info .panel-title {
    color: #4A7800;
    font-size: 30px;
  }

  .image-wrap img {
    height: 200px;
    width: 300px;
    object-fit: cover;
  }

  * {
    transition: all .1s linear 0;
  }

  body {
    font-family: "Lucida Sans Unicode";
  }

  .post {
    position: relative;
    margin: 1.2em;
    padding: 30px 20px;
    border-radius: 0px;
    width: auto;
    border: 0px solid #e8e8e8;
    margin-bottom: 20px;
    text-align: center;
  }

  .tabs-style-bar nav {
    background: rgba(40, 44, 42, 0.05);
  }

  .tabs-style-bar nav ul {
    border: 4px solid transparent;
  }

  .tabs-style-bar nav ul li a {
    margin: 0 2px;
    background-color: #f7f7f7;
    color: #74777b;
    transition: background-color 0.2s, color 0.2s;
    border-radius: 20px;
  }

  .tabs-style-bar nav ul li a:hover,
  .tabs-style-bar nav ul li a:focus {
    color: #4A7800;
  }

  .tabs-style-bar nav ul li a span {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 500;
    font-size: 0.6em;
  }

  .tabs-style-bar nav ul li.tab-current a {
    background: #005c9e;
    color: #fff;
    border-radius: 20px;
  }

  .tabs-style-bar nav ul li.tab-current h4 {
    color: #fff;
  }

  .tabs nav {
    text-align: center;
  }

  .tabs nav ul {
    position: relative;
    display: flex;
    margin: 0 auto;
    padding: 0;
    max-width: 1200px;
    list-style: none;
    flex-flow: row wrap;
    justify-content: center;
  }

  .tabs nav ul li {
    position: relative;
    z-index: 1;
    display: block;
    margin: 0;
    text-align: center;
    /*width: 200px;*/
    radius: 100px;
    min-width: 200px;
  }

  .tabs nav a {
    position: relative;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 2.5;
  }

  .tabs nav a span {
    vertical-align: middle;
    font-size: 0.75em;
  }

  .tabs nav li.tab-current a {
    color: white;
  }

  .tabs nav a:focus {
    outline: none;
  }

  .content-wrap {
    position: relative;
  }

  .content-wrap section {
    display: none;
    margin: 0 auto;
    padding: 1em;
    max-width: 1200px;
    text-align: center;
  }

  .content-wrap section.content-current {
    display: block;
  }

  .content-wrap section p {
    margin: 0;
    padding: 0.75em 0;
    color: rgba(40, 44, 42, 0.05);
    font-weight: 900;
    font-size: 4em;
    line-height: 1;
  }

  .no-js .content-wrap section {
    display: block;
    padding-bottom: 2em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.6);
  }


  .tabs-style-bar nav ul {
    border: 0px solid transparent;
  }

  .tabs-style-bar nav {
    background: #FFF;
  }

  .app-media .media-list.is-grid .media-item {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 0.286rem;
    border: 1px solid #dcf7b0ad;
    background-color: #dcf7b03b;
    position: relative;
    cursor: pointer;
  }

  .content-wrap section {
    display: none;
    margin: 0 auto;
    padding: 1em;
    max-width: 1200px;
    text-align: left;
  }

  .title {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    height: 4.5em;
    overflow: hidden;
    white-space: normal !important;
  }

  .next {
    color: #4A7800;
    font-weight: bold;
    font-size: 14px;
  }

  .next:hover {
    color: #2F4C00;
    font-weight: bold;
    font-size: 14px;
  }

  <?php /*
	#productTable1_processing {}
	.is-list > .blocks > .animation-fade > .media-item > .info-wrap > .title{
		max-width: 88%;
	}
*/
  ?>.is-list>.blocks>.animation-fade>.media-item>.info-wrap {
    width: 87%;
  }

  .is-list>.blocks>li>.media-item>.info-wrap {
    width: 87%;
  }

  /* show hide */
  .is-grid>.blocks>.animation-scale-up>.media-item>.info-wrap>.title>.metas {
    display: none;
  }

  .is-grid>.blocks>li>.media-item>.info-wrap>.title>.metas {
    display: none;
  }

  .is-list>.blocks>.animation-fade>.media-item>.info-wrap>.title>.metas {
    display: block;
  }

  .is-list>.blocks>.animation-fade>.media-item>.image-wrap {
    height: auto;
  }

  .is-list>.blocks>li>.media-item>.image-wrap {
    height: auto;
  }

  .is-grid>.blocks>.animation-scale-up>.media-item>.image-wrap {
    height: auto;
  }

  .is-grid>.blocks>li>.media-item>.image-wrap {
    height: auto;
  }


  .is-grid>.blocks>.animation-scale-up>.media-item>.info-wrap>.row.pt-10>.mr-auto.pl-15>a {
    display: none;
  }

  .is-grid>.blocks>li>.media-item>.info-wrap>.row.pt-10>.mr-auto.pl-15>a {
    display: none;
  }

  .is-list>.blocks>.animation-fade>.media-item>.info-wrap>.row.pt-10>.mr-auto.pl-15>a {
    display: inline;
  }


  #section-linemove-2>.is-list>.blocks>.animation-fade>.media-item>.image-wrap {
    text-align: center;
  }

  #section-linemove-2>.is-grid>.blocks>.animation-scale-up>.media-item>.image-wrap {
    text-align: center;
  }

  #section-linemove-2>.is-list>.blocks>.animation-fade>.media-item>.image-wrap>img {
    width: auto;
    height: auto;
  }

  #section-linemove-2>.is-list>.blocks>li>.media-item>.image-wrap>img {
    width: auto;
    height: auto;
  }

  #section-linemove-2>.is-grid>.blocks>li>.media-item>.image-wrap>img {
    width: auto;
    height: auto;
  }

  .app-media .media-list.is-list .media-item {
    padding: 8px 30px;
  }

  .page-content-actions {
    padding: 0 30px 5px;
  }
</style>

<div class="page">
  <div class="page-header">
    <h1 class="page-title">หน่วยงาน</h1>
  </div>
  <div class="page-content container-fluid">
    <div class="page-main">

      <div class="tabs tabs-style-bar">
        <nav>
          <ul>
            <?php
             foreach ($branch_type as $dataitem) {
              ?>
              <li><a href="#section-linemove-<?php echo $dataitem['id'] ?>" class="icon icon-home">
                <span>
                  <h4><?php echo $dataitem['name'] ?></h4>
                </span></a></li>
              <?php
            }
            ?>

          </ul>
        </nav>

        <div class="content-wrap">

          <div class="col-lg-auto" style="margin: 0 auto;max-width: 1200px;">
            <div class="form-inline">
              <h4 class="example-title">ค้นหา</h4>
            </div>
            <div class="form-inline">
              <div class="form-group form-material">
                <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="คำค้น" autocomplete="off">
              </div>
              <div class="form-group form-material">
                <button type="submit" onclick="checkFields(1); checkFields2(2); checkFields3(3);" class="btn btn-primary waves-effect waves-classic" name="btnSearch" id="btnSearch" title="ค้นหา"><i class="fa fa-search" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-primary waves-effect waves-classic ml-5" name="btnClear" id="btnClear" title="เคลียร์"><i class="fa fa-refresh" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>

          <section id="section-linemove-1">          
            <div class="media-list is-grid pb-50" data-plugin="animateList" data-child="li" style="display:none;">
              <ul id="new-list" class="blocks blocks-100 blocks-xxl-5 blocks-xl-4 blocks-lg-4 blocks-md-3 blocks-sm-3" data-plugin="animateList" data-child=">li"></ul>
            </div>
            <table id="productTable1" class="table table-striped table-hover table-bordered tableUpdated">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th scope="col">รหัสหน่วยงาน</th>
                  <th scope="col">ชื่อหน่วยงาน</th>
                  <th></th>
                  <th style='width:70px'></th>
                  <th style='width:70px'>จัดการ</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </section>

          <section id="section-linemove-2">
            <div class="media-list is-list pb-50" data-plugin="animateList" data-child="li" style="display:none;">
              <ul id="new-list2" class="blocks blocks-100 blocks-xxl-5 blocks-xl-4 blocks-lg-4 blocks-md-3 blocks-sm-3" data-plugin="animateList" data-child=">li">


              </ul>
            </div>
            <table id="productTable2" class="table table-striped table-hover table-bordered tableUpdated">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th scope="col">รหัสหน่วยงาน</th>
                  <th scope="col">ชื่อหน่วยงาน</th>
                  <th></th>
                  <th style='width:70px'></th>
                  <th style='width:70px'>จัดการ</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </section>
          <section id="section-linemove-3">
            <div class="media-list is-list pb-50" data-plugin="animateList" data-child="li" style="display:none;">
              <ul id="new-list2" class="blocks blocks-100 blocks-xxl-5 blocks-xl-4 blocks-lg-4 blocks-md-3 blocks-sm-3" data-plugin="animateList" data-child=">li">


              </ul>
            </div>
            <table id="productTable3" class="table table-striped table-hover table-bordered tableUpdated">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th scope="col">รหัสหน่วยงาน</th>
                  <th scope="col">ชื่อหน่วยงาน</th>
                  <th></th>
                  <th style='width:70px'></th>
                  <th style='width:70px'>จัดการ</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </section>

        </div>
      </div>

    </div>
  </div>

</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/tab/js/cbpFWTabs.js"></script>
<script type="text/javascript">
  (function() {
    [].slice.call(document.querySelectorAll('.tabs')).forEach(function(el) {
      new CBPFWTabs(el);
    });
  })();
</script>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $("#btnClear").click(function() {
      $("#txtSearch").val("");
      checkFields(1);
      checkFields2(2);
      checkFields3(3);
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
    checkFields2(2);
    checkFields3(3);
    //checkFields2(2,dataTable2);
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
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::app()->createAbsoluteUrl("admin/listbranch"); ?>",
        "data": {
          'search': search,
          'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
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
        "targets": [0, 1, 4, 5, 6],
        "visible": false
      }],
      "preDrawCallback": function(settings) {
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list').empty();
      },
      "drawCallback": function(settings) {

      },
      createdRow: function(row, data, index) {
        var pageUrl = '<?php echo Yii::app()->createAbsoluteUrl("branch/viewdata") ?>/'+ data[1];
        var newLink = '<a href="'+ pageUrl +'" target="_blank" style="text-decoration: none;" >'+data[3]+'</a>';
        $($('td', row).eq(1)).html(newLink);
      }
    });
    $(tbel + '_paginate').css("padding-bottom", "10px");
  }

  function checkFields2(type_id) {
    if (type_id == 1) {
      var tbel = "#productTable1";
    } else if (type_id == 2) {
      var tbel = "#productTable2";
    }
    $(".employee-grid-error").html("");
    if (typeof dataTable2 != 'undefined') {
      dataTable2.destroy();
    }

    var search = $("#txtSearch").val();

    dataTable2 = $(tbel).DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::app()->createAbsoluteUrl("admin/listbranch"); ?>",
        "data": {
          'search': search,
          'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
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
        "targets": [0, 1, 4, 5, 6],
        "visible": false
      }],
      "preDrawCallback": function(settings) {
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list').empty();
      },
      "drawCallback": function(settings) {

      },
      createdRow: function(row, data, index) {
        var pageUrl = '<?php echo Yii::app()->createAbsoluteUrl("branch/viewdata") ?>/'+ data[1];
        var newLink = '<a href="'+ pageUrl +'" target="_blank" style="text-decoration: none;" >'+data[3]+'</a>';
        $($('td', row).eq(1)).html(newLink);
      }

    });
    $(tbel + '_paginate').css("padding-bottom", "10px");
  }

  function checkFields3(type_id) {
    if (type_id == 1) {
      var tbel = "#productTable1";
    } else if (type_id == 2) {
      var tbel = "#productTable2";
    }else if (type_id == 3) {
      var tbel = "#productTable3";
    }

    $(".employee-grid-error").html("");
    if (typeof dataTable3 != 'undefined') {
      dataTable3.destroy();
    }

    var search = $("#txtSearch").val();

    dataTable3 = $(tbel).DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::app()->createAbsoluteUrl("admin/listbranch"); ?>",
        "data": {
          'search': search,
          'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>',
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
        "targets": [0, 1, 4, 5, 6],
        "visible": false
      }],
      "preDrawCallback": function(settings) {
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list').empty();
      },
      "drawCallback": function(settings) {

      },
      createdRow: function(row, data, index) {
        var pageUrl = '<?php echo Yii::app()->createAbsoluteUrl("branch/viewdata") ?>/'+ data[1];
        var newLink = '<a href="'+ pageUrl +'" target="_blank" style="text-decoration: none;" >'+data[3]+'</a>';
        $($('td', row).eq(1)).html(newLink);
      }

    });
    $(tbel + '_paginate').css("padding-bottom", "10px");
  }

</script>