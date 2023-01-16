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

<script type="text/javascript" src="<?php Url::base(true); ?>/vendor/tab/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php Url::base(true); ?>/vendor/dotdotdot/dotdotdot.js"></script>

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

  $menu_id = "";
  $section = "";
  $curpage = "สร้าง";
  if ($data != null) {
    $items = (array)$data[0];
    $menu_id = $items['menu_id'];
    $section_id = $items['section_type'];
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
    <h1 class="page-title">LINE Richmenu</h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl("/richmenu/listmenumap")  ?>">รายการ</a></li>
        <li class="breadcrumb-item atcitve"><?php echo $curpage; ?></li>
      </ol>
    </div>
  </div>

  <div class="page-content">


    <div class="panel">
      <div class="panel-body container-fluid">

      <div class="form-group row pl-5 required" style="border-bottom: 1px solid #ebebeb;">
          <div class="col-md-8">
            <h3>ส่งออกข้อมูลผู้ประกันตน</h3>
          </div>
        </div>
        <div class="content-wrap" >

          <div class="col-lg-auto" style="margin: 0 auto;max-width: 1200px;">
            <div class="form-inline">
              <h4 class="example-title">เมนู ID</h4>
            </div>
            <div class="form-inline">
              <div class="form-group form-material">
                <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="เมนู ID" autocomplete="off" value="<?php echo $menu_id; ?>">
              </div>
              <div class="form-group form-material">
                <button type="button" class="btn btn-primary waves-effect waves-classic ml-5" name="btnClearX" id="btnClearX" title="ตรวจสอบ" data-toggle="modal" data-target="#uidModal"><i class="fa fa-search" aria-hidden="true"></i></button>

              </div>
            </div>
          </div>

          <div id="op-group21" style="border-bottom: 1px solid #ebebeb; margin-top: 1.429rem;">
            <div class="form-group row pl-5 required">

              <label class="col-md-2 col-form-label control-label">สิทธิ์ผู้ประกันตน</label>
              <div class="col-md-8">

                <select class="form-control selectpicker" id="selsection" name="selsection" data-live-search="true" data-title="" multiple>

                  <?php

                  $section = \app\models\lkup_data::getSection(null, '1');
                  if ($data == null) {
                    $section_id = 1;
                  }
                  foreach ($section as $dataitem) {
                    $select = $section_id == $dataitem['id'] ? "selected='selected'" : "";
                    echo '<option value="' . $dataitem['id'] . '" ' . $select . ' >' . $dataitem['name'] . '</option>';
                  }

                  /*
                  $select = $section == 1 ? "selected='selected'" : "";
                  echo '<option value="1" ' . $select . ' >มาตรา 33</option>';
                  $select = $section == 2 ? "selected='selected'" : "";
                  echo '<option value="2" ' . $select . ' >มาตรา 39</option>';
                  $select = $section == 3 ? "selected='selected'" : "";
                  echo '<option value="3" ' . $select . ' >มาตรา 40</option>';
                  /*
                                  <option value="1">มาตรา 33</option>
                  <option value="2">มาตรา 39</option>
                  <option value="3">มาตรา 40</option>*/
                  ?>

                </select>

              </div>
            </div>
            <div class="form-group row pl-5 required">

              <label class="col-md-2 col-form-label control-label">หน่วยงานที่ลงทะเบียน</label>
              <div class="col-md-8">


                <?php
                $branch = \app\models\lkup_data::getDepartment(null, "1", "1,2");

                ?>


                <div class="row justify-content-center">
                  <div class="col-md-6 text-right">
                    <div class="block1 form-group">
                      <div class="block2">
                        <select multiple="multiple" id="select1" style="margin-right:-17px" size="15">
                          <?php
                          foreach ($branch as $dataitem) {
                          ?>
                            <option value="<?php echo $dataitem['ssobranch_code']; ?>"><?php echo $dataitem['name']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div>
                      <button id="add" class="btn btn-primary"> เพิ่ม</button>
                      <button id="add_all" class="btn btn-primary">เพิ่มทั้งหมด</button>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="block1 form-group">
                      <div class="block2">
                        <select multiple="multiple" id="select2" style="margin-right:-17px;min-width:350px;height:375px;" size="15">
                          <?php
                          if ($data != null) {
                            if (!is_null($data[0]['ssobranch']) || !empty($data[0]['ssobranch']) || $data[0]['ssobranch'] != "") {
                              $myArray = explode(',', $data[0]['ssobranch']);
                              //var_dump($myArray);
                              foreach ($myArray as $ubranch) {
                                if (is_numeric($ubranch)) {
                                  $branchdetail = \app\models\lkup_data::getDepartment($ubranch);
                          ?>
                                  <option value="<?php echo $ubranch; ?>"><?php echo $branchdetail[0]['name']; ?></option>
                          <?php
                                }
                              }
                            }
                          }

                          ?>

                        </select>
                      </div>
                    </div>
                    <button id="remove" class="btn btn-primary">ลบ</button>
                    <button id="remove_all" class="btn btn-primary">ลบทั้งหมด</button>
                  </div>
                </div>


                <script type="text/javascript">
                  function ajax_selectdata(menuid) {

                    $('#txtSearch').val(menuid);

                    $('#hdmenu_id').val(menuid);
                    $("uidModalBody").html("");
                    $('#uidModal').modal('hide');

                  }

                  jQuery(document).ready(function($) {
                    /*
                    $('.select2').select2({
                    placeholder: 'Select an option'
                    });*/

                  });
                  $(function() {
                    $('#add').click(function() {
                      let $options = $('#select1 option:selected');
                      $options.appendTo("#select2");
                    });
                    $('#add_all').click(function() {
                      let $options = $('#select1 option');
                      $options.appendTo("#select2");
                    });
                    $('#select1').dblclick(function() {
                      let $option = $('option:selected', this);
                      $option.appendTo('#select2');
                    });
                    $("#remove").click(function() {

                      $('#select2 > option:selected').each(function() {
                        $("#select1 option[value='" + this.value + "']").remove();
                      });

                      let $option = $('#select2 option:selected');
                      $option.appendTo("#select1");

                    });
                    $("#remove_all").click(function() {
                      let $options = $('#select2 option');
                      $options.appendTo('#select1');
                    });
                    $('#select2').dblclick(function() {
                      let $option = $('#select2 option:selected');
                      var value = $option.val();
                      //$option.appendTo("#select1");
                      $("#select1 > option").each(function() {
                        if (this.value == value) {
                          $("#select1 option[value='" + this.value + "']").remove();
                        }
                      });
                      $option.appendTo("#select1");

                    });
                  });
                </script>

              </div>

            </div>


          </div>

          <div class="form-group row pl-5 pt-10">
            <div class="col-md-8">
              <input type="hidden" id="hdmenu_id" value="<?php echo $menu_id; ?>">
              <?php
              if ($data != null) {
                if (count($data) != 0) {
              ?>
                  <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_editpermission();">แก้ไขชุดกลุ่มเมนู</button>
                <?php
                } else {
                ?>
                  <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_savepermission();">สร้างชุดกลุ่มเมนู</button>
                <?php
                }
              } else {
                ?>
                <button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_savepermission();">สร้างชุดกลุ่มเมนู</button>
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

    $('#selsection').on('loaded.bs.select', function() {

    });

    $('#selsection').change(function() {
      var selectedItem = $('#selsection').val();

    });

    $('#selsection').on('changed.bs.select', function(e, clickedIndex, isSelected) {

      if (clickedIndex !== 0) {
        console.log($(this).val());

        return;
      }

      if (this.value === '0' && isSelected == true) {
        return $(this).selectpicker('selectAll');
      }

    });

    $('#selsection').selectpicker('val', [<?php echo  $section_id; ?>]);
    <?php
    if ($section_id == "") {
    ?>
      $('#selsection').selectpicker('val', [0]);
    <?php
    }
    
    ?>
    $('#selsection').selectpicker('refresh');

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
    var id = $("#keyid").val();

    var menu_id = $("#hdmenu_id").val();
    if (menu_id == "") {
      $('html, body').animate({
        scrollTop: $("#txtSearch").offset().top - 100
      }, 2000);
      $("#txtSearch").focus();

      $("#btnadd").prop("disabled", false);
      alert('กรุณาเลือกเมนูจากรายการเมนู (กดปุ่มเพื่อค้นหา)');
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

    var result = confirm("ต้องการจัดการสิทธิ์การแสดงเมนูของแต่ละบุคคล ?");
    if (!result) {
      $("#btnadd").prop("disabled", false);
      return;
    }


    $.ajax({
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/setviewmenu"); ?>",
        method: "POST",
        dataType: "json",
        data: {
          menu_id: menu_id,
          section: section,
          perselect: arrsel.join(),
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        },
      })
      .done(function(data) {

        if (data.status == 'success') {
          $("#btnadd").prop("disabled", false);
          alert('เพิ่มสิทธิ์การแสดงเมนูของแต่ละบุคคลเรียบร้อย');
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
      function ajax_editpermission() {
        $("#btnadd").prop("disabled", true);
        var id = $("#keyid").val();

        var menu_id = $("#hdmenu_id").val();
        if (menu_id == "") {
          $('html, body').animate({
            scrollTop: $("#txtSearch").offset().top - 100
          }, 2000);
          $("#txtSearch").focus();

          $("#btnadd").prop("disabled", false);
          alert('กรุณาเลือกเมนูจากรายการเมนู');
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

        var result = confirm("ต้องการแก้ไขการจัดการสิทธิ์การแสดงเมนูของแต่ละบุคคล ?");
        if (!result) {
          $("#btnadd").prop("disabled", false);
          return;
        }


        $.ajax({
            url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/editviewmenu"); ?>",
            method: "POST",
            dataType: "json",
            data: {
              id: <?php echo $id; ?>,
              menu_id: menu_id,
              section: section,
              perselect: arrsel.join(),
              '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
            },
          })
          .done(function(data) {

            if (data.status == 'success') {
              $("#btnadd").prop("disabled", false);
              alert('แก้ไขสิทธิ์การแสดงเมนูของแต่ละบุคคลเรียบร้อย');
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
  }
}

?>