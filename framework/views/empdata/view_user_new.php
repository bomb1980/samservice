<?php

use app\widgets\Alert;
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

	.fade:not(.show) {
		opacity: 1 !important;
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

			
			<?php echo Alert::widget() ?>
			<div class="form-content">
				<form role="form" method="post" name="loginform" autocomplete="off">

					<input type="hidden" name="<?php echo Yii::$app->request->csrfParam ?>" value="<?php echo Yii::$app->request->csrfToken; ?>">

					<div class="row">

						<div class="form-material col-md-6" data-plugin="formMaterial">
							<label class="">uid</label>

							<input class="form-control empty" name="uid" type="text" value="<?php echo $form['uid'] ?>" autofocus="" maxlength="20">
						</div>

						<div class="form-material col-md-6" data-plugin="formMaterial">
							<label class="">displayname</label>

							<input class="form-control empty" name="displayname" type="text" value="<?php echo $form['displayname'] ?>" autofocus="" maxlength="50">
						</div>



					</div>


					<br>

					<div class="row">
						<div class="form-material col-md-6" data-plugin="formMaterial">
							<label class="">Password</label>
							<input class="form-control empty" name="password" type="password" value="" maxlength="20">
						</div>
						<div class="form-material col-md-6" data-plugin="formMaterial">
							<label class="">Re-enter Password</label>
							<input type="password" class="form-control empty" name="passwordcheck" maxlength="20">
						</div>


					</div>
					<br>

					<div class="row">

						<div class="form-material col-md-6">
							<!-- <select class="form-control selectpicker show-tick" id="selDepartment" name="selDepartment" title="เลือกหน่วยงาน..." data-selected-text-format="count > 2" data-live-search="true" required="">
								<option value="0" disabled="disabled" hidden="hidden" selected="selected">กรุณาเลือกหน่วยงาน</option>
								<option value="1000"> สำนักงานประกันสังคมสำนักงานใหญ่ </option>
								<option value="1001"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 1 </option>
								<option value="1002"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 2 </option>
								<option selected value="1003"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 3 </option>
								<option value="1004"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 4 </option>
								<option value="1005"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 5 </option>
								<option value="1006"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 6 </option>
								<option value="1007"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 7 </option>
								<option value="1008"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 8 </option>
								<option value="1009"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 9 </option>
								<option value="1010"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 10 </option>
								<option value="1011"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 11 </option>
								<option value="1012"> สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 12 </option>
								<option value="1050"> สำนักบริหารเทคโนโลยีสารสนเทศ </option>
								<option value="1063"> ศูนย์สารนิเทศ </option>
							</select> -->
							<?php echo $DepartmentList ?>
						</div>


						<div class="form-material col-md-6">



							<input type="submit" class="btn btn-primary btn-block" value="<?php echo $button_text ?>" />
						</div>

					</div>
				</form>
			</div>
		</div>



	</div>
</div>

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
				$('.table.is-indent thead').hide();
			}
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

						$.ajax({
							url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/updateuserworkstatus"); ?>",
							method: "POST",
							dataType: "json",
							data: {
								id: $(this).data("id"),
								'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
							},
							success: function(data) {

								alert(data.msg);
							}
						});
					};
				});
				$('.grid-error').html('');

			}
		});

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