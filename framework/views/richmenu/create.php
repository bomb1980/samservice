<?php
$this->title  = 'หน้าหลัก' . Yii::$app->params['prg_ctrl']['pagetitle'];
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
		<h1 class="page-title">LINE Rich menu</h1>
		<div class="page-header-actions">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createUrl(""); ?>">หน้าแรก</a></li>
				<li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createUrl("/richmenu/list")  ?>">รายการ Rich menu</a></li>
				<li class="breadcrumb-item atcitve">สร้าง</li>
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

										<div class="row">

											<div class="col">
												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">ชื่อเมนู</label>
													<div class="col-md-8">
														<input type="text" id="menu_name" name="menu_name" class="form-control" placeholder="ชื่อเมนู" value="">
													</div>
												</div>

												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">โค้ด JSON</label>
													<div class="col-md-8">

														<textarea id="menu_json" name="menu_json" rows="10" cols="50" style="width: 100%;"></textarea>
													</div>
												</div>


												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">รูปภาพขนาด 2500x1686 หรือ 2500x843 ขนาดไม่เกิน 1 MB.</label>
													<div class="col-md-8">
														<input type="file" id="menuimg" name="menuimg" onchange="readURL(this);" accept=".jpg,.jpeg,.png">
														<img id="preview" src="#" alt="" />
														<script>
															function readURL(input) {
																if (input.files && input.files[0]) {

																	var ext = $('#menuimg').val().split('.').pop().toLowerCase();
																	//Allowed file types
																	if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
																		alert('ประเภทของไฟล์รูปภาพไม่ถูกต้อง');
																		$('#menuimg').val("");
																		return;
																	}
																	sizee = $("#menuimg")[0].files[0].size; //byte
																	if (sizee > 1048576) {
																		alert("LINE Rich menu รองรับไฟล์ขนาดไม่เกิน 1 MB.");
																		$('#menuimg').val("");
																		return;
																	}

																	var reader = new FileReader();

																	reader.onload = function(e) {
																		$('#preview')
																			.attr('src', e.target.result)
																			/*.width(150)*/
																			.height(200);
																	};

																	reader.readAsDataURL(input.files[0]);
																}
															}
														</script>
													</div>
												</div>


												<div class="form-group row pl-5">
													<div class="col-md-8">
														<button type="button" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic" onclick="ajax_savedata();">สร้าง Rich menu</button>

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
			</div>
		</div>
		<!-- End Panel jvectormap -->
	</div>
</div>
<!-- End Page -->




<script type="text/javascript">
	jQuery(document).ready(function($) {



	});

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
			alert('กรุณาเลือกไฟล์ที่จะอัพโหลด');
			return;
		}

		//return;

		$("#btnadd").prop("disabled", true);

		var result = confirm("ต้องการเพิ่มเมนู ?");
		if (!result) {
			$("#btnadd").prop("disabled", false);
			return;
		}


		let formData = new FormData()
		var file_data = $('#menuimg').prop('files')[0]; //console.log(file_data);return;

		formData.append('menuimg', file_data);
		formData.append('menu_name', menu_name);
		formData.append('menu_json', menu_json);
		formData.append('<?=Yii::$app->request->csrfParam?>', '<?php echo Yii::$app->request->csrfToken; ?>');

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createUrl("richmenu/savemenu"); ?>",
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