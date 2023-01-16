<?php
use yii\helpers\Url;
$this->title  = 'ดูฐานข้อมูลระบบ' . Yii::$app->params['prg_ctrl']['pagetitle'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>

<link rel="stylesheet" href="<?php echo Url::base(true); ?>/vendor/datatables/DataTables-1.10.20/css/dataTables.foundation.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">

<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">

<script src="<?php echo Url::base(true) ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>

<link rel="stylesheet" href="<?php echo Url::base(true)  ?>/vendor/lobipanel/dist/css/lobipanel.css">

<script src="<?php echo Url::base(true) ?>/vendor/lobipanel/dist/js/lobipanel.js"></script>


<style>
  .box {
    width: 100%;
    background-color: #fff;
    border-radius: 5px;
  }

  #page_list li {
    padding: 10px;
    background-color: #f9f9f9;
    border: 1px dotted #ccc;
    cursor: move;
    margin-top: 5px;
  }

  #page_list li.ui-state-highlight {
    padding: 24px;
    background-color: #ffffcc;
    border: 1px dotted #ccc;
    cursor: move;
    margin-top: 12px;
  }


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

  .thfont5 {
    font-family: Prompt-Regular !important;
    font-size: 18px;
    line-height: normal;
    /*font-weight:bold;*/
  }

  .panel-body {
    padding: 15px !important;
  }
</style>


<script src="<?php echo Url::base(true); ?>/vendor/datatables/JSZip-2.5.0/jszip.js"></script>

<script src="<?php echo Url::base(true) ?>/vendor/datatables/datatables.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/datatables/DataTables-1.10.20/js/jquery.dataTables.js"></script>

<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>


<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-colreorderwithresize/ColReorderWithResize.js"></script>

<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.print.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>

<script src="<?php echo Url::base(true) ?>/vendor/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script>
  pdfMake.fonts = {
    THSarabunNew: {
      normal: 'THSarabunNew.ttf',
      bold: 'THSarabunNew-Bold.ttf',
      italics: 'THSarabunNew-Italic.ttf',
      bolditalics: 'THSarabunNew-BoldItalic.ttf'
    },
    // Default font should still be available
    Roboto: {
      normal: 'Roboto-Regular.ttf',
      bold: 'Roboto-Medium.ttf',
      italics: 'Roboto-Italic.ttf',
      bolditalics: 'Roboto-Italic.ttf'
    },

  };
</script>

<!-- Page -->
<div class="page">

  <div class="page-header">
    <h1 class="page-title">ดูฐานข้อมูลระบบ</h1>
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


        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <i class="fa fa-database"></i>
                    <font class="thfont5" style="font-size:18px;"> Database Name</font>
                  </div>
                  <!--panel heading-->
                  <div class="panel-body">
                    <div id="dbn" class="thfont5" style="font-size:18px; color:#666; width:100%; height:auto;">
                      <table class="thfont5">
                        <?php

                        $DBName = \app\models\lkup_data::getDBName();

                        foreach ($DBName as $db) {
                        ?>
                          <tr>
                            <td id="<?php echo $db['Database'] ?>"><i class="fa fa-cube"></i> <span style="color:#3333FF; cursor:pointer;" onClick="javascript:gettablename('<?php echo $db['Database'] ?>');"><?php echo $db['Database'] ?></span></td>
                          </tr>
                        <?php
                        }

                        ?>

                      </table>
                    </div>
                  </div>
                  <!--panelbody-->
                </div>
                <!--panel-->
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <i class="fa fa-table"></i>
                    <font class="thfont5" style="font-size:18px;"><span id="dbntt"> Table Name</span></font>
                  </div>
                  <!--panel heading-->
                  <div class="panel-body" style="">
                    <div id="tbn" class="thfont5" style="font-size:18px; color:#666; width:100%; height:auto;">

                    </div>
                  </div>
                  <!--panelbody-->
                </div>
                <!--panel-->
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <i class="fa fa-sitemap"></i>
                  <font class="thfont5" style="font-size:18px;"> SQL Command <span id="udbid"></span></font>
                </div>
                <!--panel heading-->
                <div class="panel-body">
                  <div id="sqlc" class="thfont5" style="font-size:18px; color:#666; width:100%; height:auto;">
                    <div class="form-group">
                      <!--<label for="sqlcommand">SQL:</label>-->
                      <textarea class="form-control thfont5" rows="2" id="sqlcommand" placeholder="select * from... "></textarea>
                      <input type="hidden" id="udb1" value="wpddb">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning thfont5" onClick="javascript:executesql();"><i class="fa fa-bolt"></i> SELECT</button>
                      <button class="btn btn-danger thfont5" onClick="javascript:executesqlrun();"><i class="fa fa-play"></i> Run</button>
                    </div>
                  </div>
                </div>
                <!--panelbody-->
              </div>
              <!--panel-->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <i class="fa fa-tasks"></i>
                  <font class="thfont5" style="font-size:18px;"><span id="dtn"> Data</span></font>
                </div>
                <!--panel heading-->
                <div class="panel-body">				
				  <div id="process" style="display: none;">
					<img src='<?php echo Url::base(true) ?>/images/common/loading264.gif' height='30' width='30' /> <br> Loading...
				  </div>
                  <div id="sqlr" class="thfont5" style="font-size:18px; color:#666; width:100%; height:auto;">

                  </div>
                </div>
                <!--panelbody-->
              </div>
              <!--panel-->
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

  </div>
</div>

  <script type="text/javascript">
    function gettablename(tbn) {

      $('.thfont5 tr').each(function() {
        var $row = $(this);
        $row.children().each(function() {
          var $cell = $(this).attr('id');
          if ($cell != tbn) {
            $("#" + $cell).css("background-color", "");
          } else {
            $("#" + tbn).css("background-color", "#E6E9FD");
          }
        });
      });

      var data1 = 'action=gettablename&tbn=' + tbn;
      var tbntt = ' ' + tbn;

      $("#udbid").html("Use - " + tbn);
      $("#udb1").val(tbn);
      $('#tbn').html("<img src='<?php echo Url::base(true) ?>/images/common/loading264.gif' height='30' width='30' /> <br> Loading...");
      $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl('datamanagement/gettablename'); ?>",
        data: {
          tbn: tbn,
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        },
        success: function(da) {
          $("#dbntt").html(tbntt);
          $('#tbn').html("<img src='<?php echo Url::base(true) ?>/images/common/loading264.gif' height='30' width='30' /> <br> Loading...");
          $("#tbn").html(da);
        }
      });
    }

    function executesql() {
      var sqlc = $("#sqlcommand").val();
      var udb1 = $("#udb1").val();


      //alert(udb1);
      if (!udb1) {
        alertify.alert('<font class="thfont5">กรุณาเลือก Database Name !</font>');
      } else if (!sqlc) {
        alertify.alert('<font class="thfont5">กรุณาป้อน sql command !</font>');
      } else {
        //alert('test');
        var data1 = 'action=execsql&sqlc=' + sqlc + '&udb1=' + udb1;

		/*
        $("#sqlr").html("<img src='<?php echo Url::base(true) ?>/images/common/loading264.gif' height='30' width='30' /> <br> Loading...");
        $.ajax({
          type: "POST",
          url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl('datamanagement/executesqlc'); ?>",
          data: data1,
          data: {
            sqlc: sqlc,
            udb1: udb1,
            '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          },
          success: function(da) {
            $("#sqlr").html(da);
          }
        }); //ajax 
		*/
		
			$.ajax({
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl('datamanagement/executesqlc'); ?>",
			method: "POST",			
			data: {
			  sqlc: sqlc,
			  udb1: udb1,
			  '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
			},
			beforeSend: function() {
			  $("#process").show();
			},
		  })
		  .done(function(data) {
			$("#sqlr").html(data);
		  })
		  .fail(function(jqXHR, status, error) {
			// Triggered if response status code is NOT 200 (OK)
			alert(error);
			//alert(jqXHR.responseText);

		  })
		  .always(function() {
			//$("#sqlr").html('');
			$("#process").hide();
		  });


      } //if
    } //function

    function executesqlrun() {
      var sqlcr = $("#sqlcommand").val();
      var udb1 = $("#udb1").val();
      if (udb1) { //ค่าเริ่มต้นคือ wpddb
        if (sqlcr) {
          var data1 = 'action=execsqlrun&sqlcr=' + sqlcr + '&udb1=' + udb1;

		/*
          $("#sqlr").html("<img src='<?php echo Url::base(true) ?>/images/common/loading264.gif' height='30' width='30' /> <br> Loading...");        
		  $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl('datamanagement/executesqlcr'); ?>",
            data: {
              sqlcr: sqlcr,
              udb1: udb1,
              '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
            },
            success: function(da) {
              $("#sqlr").html(da);
            }

          }); //ajax
		*/

		$.ajax({
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl('datamanagement/executesqlcr'); ?>",
			method: "POST",			
            data: {
              sqlcr: sqlcr,
              udb1: udb1,
              '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
            },
			beforeSend: function() {
			  $("#process").show();
			},
		  })
		  .done(function(data) {
			$("#sqlr").html(data);
		  })
		  .fail(function(jqXHR, status, error) {
			// Triggered if response status code is NOT 200 (OK)
			alert(error);
			//alert(jqXHR.responseText);

		  })
		  .always(function() {
			$("#process").hide();
		  });

        } else {
          alertify.alert('<font class="thfont5">กรุณาป้อน sql command !</font>');
        }
      } else {
        alertify.alert('<font class="thfont5">กรุณาเลือก Database Name !</font>');
      }

    } //function

    jQuery(document).ready(function($) {

      $('.panel').lobiPanel({
        reload: false,
        close: false,
        editTitle: false,
        sortable: true
        //minimize: false
      });


    });
  </script>

  <!-- End Page -->