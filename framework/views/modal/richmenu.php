<?php
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">

<table id="productTable1" class="table table-striped table-hover table-bordered tableUpdated">
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th></th>
            <th scope="col">ชื่อเมนู</th>
            <th style='width:20%'>รูปภาพเมนู</th>
            <th style='width:10%'>เลือก</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script type="text/javascript">
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

        var search = "";

        dataTable = $(tbel).DataTable({
            responsive: true,
            "language": {
                "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json",
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("richmenu/listselect"); ?>",
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
</script>