<?php
$this->title   = 'หน้าหลัก' . Yii::$app->params['prg_ctrl']['pagetitle'];
//$folder = Yii::$app->params['prg_ctrl']['url']['thumbnail'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];

?>


<style>
	/* HIDE RADIO */
	.hiddenradio {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		grid-gap: 8px 40px;
	}

	.hiddenradio>div {
		cursor: pointer;
		text-align: center;
		padding: 12px 8px;
		margin-bottom: 12px;
	}

	.hiddenradio [type=radio] {
		position: absolute;
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* IMAGE STYLES */
	.hiddenradio [type=radio]+img {
		cursor: pointer;
	}

	/* CHECKED STYLES */
	.hiddenradio [type=radio]:checked+img {
		outline: 2px solid #f00;
	}
</style>

<!-- Page -->
<div class="page">

	<div class="page-header">
		<h1 class="page-title">จัดการสิทธิ์ผู้ใช้งาน</h1>
		<div class="page-header-actions">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createUrl(""); ?>">หน้าแรก</a></li>
				<li class="breadcrumb-item atcitve">แอดมิน</li>
			</ol>
		</div>
	</div>

	<div class="page-content">
		<!-- Panel jvectormap -->

		<div class="panel-body container-fluid">



			<div class="row">
				<div class="col-md-6">
					<div class="row required">

						<div class="col-md-8">
							<div class="input-group">
								<input type="text" name="FSearch1" id="FSearch1" class="form-control" placeholder="Login หรือ ชื่อ-นามสกุล" maxlength="20" style="width: 200px">
								<span class="input-group-append">
									<button type="button" class="btn btn-primary waves-effect waves-classic" onclick="checkFields();" title="ค้นหา"><i class="icon wb-search" aria-hidden="true"></i></button>
									<button type="button" class="btn btn-primary waves-effect waves-classic" onclick="sync_data();" title="ปรับปรุงข้อมูล"><i class="icon md-refresh-sync" aria-hidden="true"></i></button>


								</span>

							</div>
						</div>
					</div>

				</div>



			</div>


			<table class="table table-hover dataTable table-striped w-full no-footer dtr-inline mt-15" id="Datatables">
				<thead>
					<tr>

						<?php

						foreach ($columns as $kc => $vc) {

							echo '<th class="text-center">' . $vc['label'] . '</th>';
						}
						?>

					</tr>
				</thead>
			</table>

		</div>

	</div>
</div>
<!-- End Page -->

<script src="js/datatables.net/jquery.dataTables.js"></script>
<script src="js/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="js/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="js/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="js/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="js/datatables.net-scroller/dataTables.scroller.js"></script>
<script src="js/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="js/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="js/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="js/datatables.net-buttons/buttons.html5.js"></script>
<script src="js/datatables.net-buttons/buttons.flash.js"></script>
<script src="js/datatables.net-buttons/buttons.print.js"></script>
<script src="js/datatables.net-buttons/buttons.colVis.js"></script>
<script src="js/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {

		call_datatable('');

		$('#seltype').change(function() {
			call_datatable('');

		});
		$('#per_cardno').keyup(function() {
			call_datatable('');

		});
	});



	function call_datatable(search) {

		postDatas = {};
		postDatas.token = 'pP63DE5y2z53FHqvtOW4slL0AsUfnfAX8beGLuPj';

		postDatas.seltype = $("#seltype").val();
		postDatas.per_cardno = $("#per_cardno").val();

		$('#Datatables').DataTable().destroy();
		var table = $('#Datatables').DataTable({
			language: {
				url: 'js/datatable-thai.json',
			},
			serverSide: true,
			processing: true,
			dom: 'rtp<"bottom"i>',
			ajax: {
				url: 'api/getuser',
				type: 'GET',
				data: postDatas,
				headers: {
					'Authorization': 'Bearer dNyCr0GdC0jZfNih9bHrIuPjxUW2Xctn6nbZIm8B'
				}
			},
			columns: [

				<?php

				foreach ($columns as $kc => $vc) {

					$className = 'text-center';
					if (isset($vc['className'])) {
						$className = $vc['className'];
					}

					echo '{
                        data: \'' . $vc['name'] . '\',
                        name: \'' . $vc['name'] . '\',
                        className: "' . $className . '",
                        orderable: true,
                    },';
				}
				?>
			],

			paging: true,
			pageLength: 10,
			ordering: false,
			drawCallback: function(settings) {
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch_work_status'));
				elems.forEach(function(el) {
					//var init = new Switchery(el);
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
				// pageinfo = dataTable.page.info();
				//console.log(pageinfo.start);
			}
		});
		// table.search(search).draw();
	}


	async function calltask() {
		const [totalPage, limit, totalRow] = await callApi()

		await sync_data(totalPage, limit, totalRow)
	}
	async function callApi() {


		return new Promise(function(resolve, reject, totalRow) {

			$.ajax({
				url: "<?php echo Yii::$app->urlManager->createUrl("empdata/getapiinfomation"); ?>",
				method: "POST",
				cache: false,
				data: {
					'<?= Yii::$app->request->csrfParam ?>': '<?php echo Yii::$app->request->csrfToken; ?>',
					'rand': '<?php echo time(); ?>',
				},
				success: function(data) {
					//$(".sync_progress1").html(data);
					let totalPage = data.totalPage;
					let limit = data.limit;
					let totalRow = data.totalRow;
					resolve([totalPage, limit, totalRow]);
				}
			});

		});


	}


	async function sync_data(totalPage, limit, totalRow) {

		/*
		var result = confirm("ระบบการอัพเดตข้อมูลอาจใช้เวลานาน ต้องการทำงานต่อหรือไม่ ?");
		if (!result) {
			return;
		}*/

		$.ajax({
			url: "<?php echo Yii::$app->urlManager->createUrl("partial/sync_datapaging"); ?>",
			method: "POST",
			cache: false,
			data: {
				'<?= Yii::$app->request->csrfParam ?>': '<?php echo Yii::$app->request->csrfToken; ?>',
				'rand': '<?php echo time(); ?>',
				'totalPage': totalPage,
				'limit': limit,
				'totalRow': totalRow
			},
			success: function(data) {
				$(".sync_progress1").html(data);
			}
		});


	}

	function ajax_savedata() {

		var menu_name = $("#menu_name").val();
		if (menu_name == "") {

			$('html, body').animate({
				scrollTop: $("#menu_name").offset().top - 100
			}, 2000);
			$("#menu_name").focus();

			$("#btnadd").prop("disabled", false);
			alert('กรุณาป้อนข้อมูลหัวข้อ');
			return;
		}

		var menu_json = $("#menu_json").val();
		if (menu_json == "") {
			$('html, body').animate({
				scrollTop: $("#menu_json").offset().top - 100
			}, 2000);
			$("#menu_json").focus();

			$("#btnadd").prop("disabled", false);
			alert('กรุณาป้อนข้อมูลหัวข้อ');
			return;
		}


		if (document.getElementById("menuimg").files.length == 0) {

			var elem = document.getElementById('preview');
			if (elem.getAttribute('src') == "") {
				alert('กรุณาเลือกไฟล์ที่จะอัพโหลด');
				return;
			}

		}


		$("#btnadd").prop("disabled", true);

		var result = confirm("ต้องการแก้ไขเมนู ?");
		if (!result) {
			$("#btnadd").prop("disabled", false);
			return;
		}

		let formData = new FormData()
		var file_data = $('#menuimg').prop('files')[0]; //console.log(file_data);return;

		formData.append('id', <?php //echo $id; 
						?>);
		formData.append('menuimg', file_data);
		formData.append('menu_name', menu_name);
		formData.append('menu_json', menu_json);
		formData.append('<?= Yii::$app->request->csrfParam ?>', '<?php echo Yii::$app->request->csrfToken; ?>');
		formData.append('hdsetdefault', $("#hdsetdefault").val());

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createUrl("richmenu/editmenu"); ?>",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function(data) {
				if (data.status == 'success') {
					$("#btnadd").prop("disabled", false);
					alert('บันทึกข้อมูลเรียบร้อย');
					window.location.href = '' + data.msg + '';
				} else {
					alert(data.msg);
					$("#btnadd").removeAttr('disabled');
				}
			}
		});
	}
</script>