<?php

use app\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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

	
	<!-- $name, $selection = null, $items = [], $options = [] -->
	
		<!-- Panel jvectormap -->
		<div class="panel-body container-fluid">

			
			<?php echo Alert::widget() ?>
			<div class="form-content">

				<?php echo  Html::beginForm(['', 'id' => $form['id']], 'post', ['enctype' => 'multipart/form-data']) ?>
				<!-- <form role="form" method="post" name="loginform" autocomplete="off"> -->

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
							 
						 

							<?php echo  Html::dropDownList('ssobranch_code', $form['ssobranch_code'], ArrayHelper::map($MasSsobranch, 'ssobranch_code', 'name'), ['title'=>'เลือกหน่วยงาน...', 'prompt'=>'เลือกหน่วยงาน...', 'class'=>'form-control selectpicker show-tick', 'data-live-search'=>'true']) ?>
						</div>


						<div class="form-material col-md-6">



							<input type="submit" class="btn btn-primary btn-block" value="<?php echo $button_text ?>" />
						</div>

					</div>

					<?php echo Html::endForm() ?>
				 
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


<script type="text/javascript">
	jQuery(document).ready(function($) {

		 
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