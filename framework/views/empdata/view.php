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
		<h1 class="page-title">อัพเดตข้อมูลเจ้าหน้าที่</h1>
		<div class="page-header-actions">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createUrl(""); ?>">หน้าแรก</a></li>
				<li class="breadcrumb-item atcitve">ปรับปรุง</li>
			</ol>
		</div>
	</div>

	<div class="page-content">
		<!-- Panel jvectormap -->
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row row-lg">

					<div class="col-xs-12 col-sm-12 pl-0 pr-0">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col">
								<div class="panel panel-line">

									<div id="divlist" class="panel-body">
										<div class="rows" style="border-bottom: 2px solid #ebebeb;">
											<div class="col-xl-6 col-lg-12">
												<div class="card">

													<div class="form-group row pl-5 required">
														<label class="col-md-4 col-form-label control-label">รหัสบัตรประชาชน</label>
														<div class="col-md-8">
															<input type="text" class="form-control" id="line_message" name="line_message">
														</div>
													</div>

													<div class="form-group row pl-5 pt-10">
														<div class="col-md-8 form-inline">

															<button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="">ปรับปรุงข้อมูล</button>
															<img id="imgprocess" src="<?php echo Yii::$app->request->baseUrl; ?>/images/common/loading232.gif" style="display: none;" alt="อยู่ระหว่างการประมวลผล">

														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="rows">
											<div class="col-xl-6 col-lg-12">
												<div class="card">
													<div class="form-group row pl-5 required">
														<label class="col-md-4 col-form-label control-label">ประเภทเจ้าหน้าที่</label>
														<div class="col-md-8">

															<select class="form-control" id="seltype" name="seltype">

																<option value="1">ข้าราชการ</option>
																<option value="2">พนักงาน</option>

															</select>
														</div>
													</div>

													<div class="form-group row pl-5 pt-10">
														<div class="col-md-8 form-inline">

															<button type="button" id="btnaddall" name="btnaddall" class="btn-primary btn waves-effect waves-classic" onclick="ajax_savepermission();">ปรับปรุงข้อมูลทั้งหมด</button>
															<img id="imgprocessall" src="<?php echo Yii::$app->request->baseUrl; ?>/images/common/loading232.gif" style="display: none;" alt="อยู่ระหว่างการประมวลผล">

														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="rows">
											<div class="sync_progress1 text-center">

											</div>
										</div>


									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- End Panel jvectormap -->
	</div>
</div>
<!-- End Page -->




<script type="text/javascript">
	jQuery(document).ready(function($) {

		calltask();

	});


	async function calltask() {
		const [totalPage, limit, totalRow] = await callApi()

		await sync_data(totalPage, limit, totalRow)
	}
	async function callApi() {
		/*
		return new Promise(function(resolve, reject) {
			resolve(["test1", "test2"]);
		})*/

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


	function ajax_savepermission() {

		$("#btnaddall").prop("disabled", true);

		var result = confirm("ต้องการนำอัพเดตข้อมูลเจ้าหน้าที่ ?");
		if (!result) {
			$("#btnaddall").prop("disabled", false);
			return;
		}

		var seltype = $("#seltype").val();

		var data = new FormData();
		data.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->getCsrfToken() ?>');
		data.append('seltype', seltype);
		// url: "<?php echo Yii::$app->urlManager->createUrl("empdata/processsyndata"); ?>",


		$.ajax({
				url: "<?php echo Yii::$app->urlManager->createUrl("empdata/gogo"); ?>",
				method: "POST",
				cache: false,
				processData: false,
				contentType: false,
				dataType: "json",
				data: data,
				beforeSend: function() {
					$('#imgprocessall').show();
				},
			})
			.done(function(data) {
				console.log(data);
				if (data.status == 'success') {
					$("#btnaddall").prop("disabled", false);

					$('#imgprocessall').replaceWith(data.msg);
					// alert('ปรับปรุงข้อมูลจำนวน ' + data.msg.toLocaleString() + ' ราย เรียบร้อยแล้ว');
				} else {
					alert(data.msg);
					$("#btnaddall").prop("disabled", false);
				}

			})
			.fail(function(jqXHR, status, error) {
				// Triggered if response status code is NOT 200 (OK)
				//alert(jqXHR.responseText);

			})
			.always(function() {
				$('#imgprocessall').hide();
				$("#btnaddall").prop("disabled", false);
			});


	}
</script>