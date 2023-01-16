<?php
use yii\helpers\Url;

  $this->title  = 'เพิ่มหน่วยงาน' . Yii::$app->params['prg_ctrl']['pagetitle'];
?>
<!-- Include Font Awesome. -->
<link href="<?php echo Url::base(true) ?>/vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Url::base(true) ?>/vendor/font-awesome/css/v4-shims.min.css" rel="stylesheet" type="text/css"/>
<!-- Include Froala Editor styles -->
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/froala_editor.min.css" />
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/froala_style.min.css" />
<!-- Include Froala Editor Plugins styles -->
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/emoticons.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/file.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/image_manager.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/image.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/css/plugins/video.css">
<!-- Include Froala Editor -->
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/froala_editor.min.js"></script>
<!-- Include Froala Editor Plugins -->
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/align.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/char_counter.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/code_view.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/colors.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/emoticons.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/entities.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/file.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/font_family.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/font_size.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/image.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/image_manager.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/inline_style.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/link.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/lists.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/quote.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/save.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/table.min.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/plugins/video.min.js"></script>
<!-- Include the language file. -->
<script src='<?php echo Url::base(true) ?>/vendor/froala/wysiwyg-editor/js/languages/th.js'></script>
<style>
	   /*a[href*="froala"]{
	  	display: none !important;
		} */ 
		
		div.fr-wrapper>div>a {
      /* display: none !important; */
      /* position: fixed; */
      /* z-index: -99999 !important; */
      font-size: 0px !important;
      padding: 0px !important;
      height: 0px !important;
    }

  </style>
<!-- End Froala -->

<!--Multiple Ajax Upload -->
<link href="<?php echo Url::base(true) ?>/vendor/fileupload/style.css" rel="stylesheet" type="text/css">
<!-- <script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/load-image.all.min.js"></script> 
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.iframe-transport.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo Url::base(true) ?>/vendor/fileupload/js/jquery.fileupload-validate.js"></script>
<script language="javascript">
	$(function(){
		'use strict';
		var fi = $('#fileupload'); //file input 
		//var process_url = '<?php echo dirname($_SERVER["PHP_SELF"]) ?>/upload.php'; //PHP script
		var process_url = '<?php echo Url::base(true) ?>/fileupload/Upload_file';
		var progressBar = $('<div/>').addClass('uploadprogress').append($('<div/>').addClass('uploadprogress-bar')); //progress bar
		var uploadButton = $('<button/>').addClass('button btn-blue upload').text('Upload'); //upload button

		uploadButton.on('click', function () {
			var $this = $(this), data = $this.data();
			data.submit().always(function () {
				$this.parent().find('.uploadprogress').show();
				$this.parent().find('.remove').remove();
				$this.remove();
			});
		});

		fi.fileupload({
			url: process_url,
			dataType: 'json',
			autoUpload: false,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png|mp4|mp3|pdf|ppt|pptx|doc|docx|xls|xlsx|zip|rar|7z)$/i,
			//maxFileSize: 1048576, //1MB
			maxFileSize: 20971520, //20MB
			disableImageResize: /Android(?!.*Chrome)|Opera/ 
			.test(window.navigator.userAgent),
			previewMaxWidth: 50,
			previewMaxHeight: 50,
			previewCrop: true,
			dropZone: $('#dropzone'),
			formData: {
				'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',,
				filecode : '<?php echo $filecode; ?>'
			}
		});

		fi.on('fileuploadadd', function (e, data) {
			data.context = $('<div/>').addClass('file-wrapper').appendTo('#files');
			$.each(data.files, function (index, file){
			var node = $('<div/>').addClass('file-row');
				var removeBtn  = $('<button/>').addClass('button btn-red remove').text('Remove');
				removeBtn.on('click', function(e, data){
					$(this).parent().parent().remove();
				});
				var file_txt = $('<div/>').addClass('file-row-text').append('<span>'+file.name + ' (' +format_size(file.size) + ')' + '</span>');
				file_txt.append(removeBtn);
				file_txt.prependTo(node).append(uploadButton.clone(true).data(data));
				progressBar.clone().appendTo(file_txt);
				if (!index){
					node.prepend(file.preview);
				}
				node.appendTo(data.context);
			});
		});

		fi.on('fileuploadprocessalways', function (e, data) {
			var index = data.index,
			file = data.files[index],
			node = $(data.context.children()[index]);
			if (file.preview) {
				node .prepend(file.preview);
			}
			if (file.error) {
				node.append($('<span class="text-danger"/>').text(file.error));
			}
			if (index + 1 === data.files.length) {
				data.context.find('button.upload').prop('disabled', !!data.files.error);
			}
		});

		fi.on('fileuploadprogress', function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			if (data.context) {
				data.context.each(function () {
					$(this).find('.uploadprogress').attr('aria-valuenow', progress).children().first().css('width',progress + '%').text(progress + '%');
				});
			}
		});

		fi.on('fileuploaddone', function (e, data) {
			$.each(data.result.files, function (index, file) {
				if (file.url) {
					var link = $('<a>') .attr('target', '_blank') .prop('href', file.url);
					$(data.context.children()[index]).addClass('file-uploaded');
					$(data.context.children()[index]).find('canvas').wrap(link);
					$(data.context.children()[index]).find('.file-remove').hide(); 
					var done = $('<span class="text-success"/>').text('Uploaded!');
					$(data.context.children()[index]).append(done);
				} else if (file.error) {
					var error = $('<span class="text-danger"/>').text(file.error);
					$(data.context.children()[index]).append(error);
				}
			});
		});

		fi.on('fileuploadfail', function (e, data) {
			$('#error_output').html(data.jqXHR.responseText);
		});

		function format_size(bytes) {
			if (typeof bytes !== 'number') {
				return '';
			}
			if (bytes >= 1000000000) {
				return (bytes / 1000000000).toFixed(2) + ' GB';
			}
			if (bytes >= 1000000) {
				return (bytes / 1000000).toFixed(2) + ' MB';
			}
			return (bytes / 1000).toFixed(2) + ' KB';
		}
	});
</script>
<!-- End Multiple Ajax Upload -->

<!-- Page -->
<div class="page">
	<div class="page-header" >
		<h1 class="page-title">หน่วยงาน</h1>
		<div class="page-header-actions">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
				<li class="breadcrumb-item"><a href="<?php echo $isAddmin ? Yii::$app->urlManager->createAbsoluteUrl("/admin/branch") . '/' : Yii::$app->urlManager->createAbsoluteUrl("/branch") . '/' ; ?>">หน่วยงาน</a></li>
				<li class="breadcrumb-item atcitve">เพิ่มหน่วยงาน</li>
			</ol>
		</div>
	</div>
	<div class="page-content container-fluid">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">เพิ่มหน่วยงาน</h3>
			</div>
			<div class="panel-body">
				<form class="frmadd" method="post" name="frmadd" id="frmadd" enctype="multipart/form-data">
					<div class="row row-lg">
						<div class="col-md-12 col-lg-9">
							<div class="mb-10">
								<input type="file" class="form-control" id="cover" name="cover" data-plugin="dropify" data-height="128" data-width="128" data-allowed-file-extensions="png jpg gif" data-max-file-size="1024K" style="object-fit:contain; width:100%; margin-left: 32px;"/>
							</div></br>
						</div>
					</div>
					<div class="row row-lg">
						<div class="col-md-4">
							<h4 class="example-title">รหัสหน่วยงาน</h4>
							<input type="text" class="form-control" id="branchcode" name="branchcode" placeholder="รหัสหน่วยงาน">
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-4">
							<h4 class="example-title">ชื่อหน่วยงาน</h4>
							<input type="text" class="form-control" id="name" name="name" placeholder="ชื่อหน่วยงาน">
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-4">
							<h4 class="example-title">ชื่อย่อหน่วยงาน</h4>
							<input type="text" class="form-control" id="shortname" name="shortname" placeholder="คำย่อ">
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-4">
							<h4 class="example-title">ประเภท</h4>
							<select class="form-control" data-plugin="select2" id="ssobranch_type_id" name="ssobranch_type_id">
								<?php
								 foreach ($branch_type as $dataitem) {
									 echo '<option value="' . $dataitem['id'] .'">' . $dataitem['name'] .'</option>';
								 }
								?>
							</select>
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-12">
							<h4 class="example-title">รายละเอียดเนื้อหา</h4>
							<div class="comments-add media">
								<textarea id="edit" name="content"></textarea>
							</div>
						</div>
						<script>
							$(function() {
								$('#edit').froalaEditor({
									language: 'th',
									imageUploadURL: '<?php echo Url::base(true)  ?>/Upload_image',
									imageUploadParams: {
										id: 'my_editor',
										'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
									},

									fileUploadURL: '<?php echo Url::base(true)  ?>/Upload_file',
									fileUploadParams: {
										id: 'my_editor'
									},

									imageManagerLoadURL: '<?php echo Url::base(true)  ?>/getlist',
									imageManagerDeleteURL: '<?php echo Url::base(true)  ?>/delete_file',
									imageManagerDeleteMethod: "POST",

									imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL'],
									toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertTable', '|', 'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
									heightMin: 200,
									toolbarStickyOffset: 50,
									toolbarSticky: false,
									width:'100%',
								})

								.on('froalaEditor.image.removed', function (e, editor, $img) {
									$.ajax({
										method: "POST",
										url: '<?php echo Url::base(true)  ?>/delete_file',
										data: {
											src: $img.attr('src'),
											'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
										}
									})
									.done (function (data) {
										if(data=='"Success"'){
											console.log ('image was deleted');  
										} else {
											console.log('could not access the path');
										}
									})
									.fail (function (err) {
										console.log ('image delete problem: ' + JSON.stringify(err));
									})
								})
								.on('froalaEditor.file.unlink', function (e, editor, link) {
									$.ajax({
										method: "POST",
										url: '<?php echo Url::base(true)  ?>/delete_file',
										data: {
											src: link.getAttribute('href'),
											'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
										}
									})
									.done (function (data) {
										if(data=='"Success"'){
											console.log ('file was deleted');  
										} else {
											console.log('could not access the path');
										}
									})
									.fail (function (err) {
										console.log ('file delete problem: ' + JSON.stringify(err));
									})
								})
							});
						</script>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-12">
							<h4 class="example-title">ที่อยู่ติดต่อ</h4>
							<input type="text" class="form-control" id="address" name="address" placeholder="ที่อยู่" value="">
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-12">
							<h4 class="example-title">หมายเลขโทรศัพท์ติดต่อ</h4>
							<input type="text" class="form-control" id="telno" name="telno" placeholder="โทรศัพท์" value="">
						</div>
					</div><br>
					<div class="row row-lg">
						<div class="col-md-12">
							<h4 class="example-title">ลิงค์แผนที่</h4>
							<input type="text" class="form-control" id="location" name="location" placeholder="ลิงค์" value="">
						</div>
					</div>	
					</div><br>					
					<input type="hidden" id="<?= Yii::$app->request->csrfParam ?>" name="<?= Yii::$app->request->csrfParam ?>" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
					<div class="row row-lg">
						<div class="form-group form-material row">
							<div class="col-md-9 offset-md-3">
								<button type="submit" id="btnadd" name="btnadd" class="btn-primary btn waves-effect waves-classic">บันทึกข้อมูล</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$("#selcontent_category_id").select2({
			language: "th"
		});
		$('button[id=btnadd]').click(function () {
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			var elems = Array.prototype.slice.call(document.querySelectorAll('.frmadd'));
			elems.forEach(function(el) {
				el.onsubmit= function(e) {
					var branchcode = $("#branchcode").val(); 
					if (branchcode == ""){
						alert('กรุณาป้อนรหัสหน่วยงาน');
						return false;
					}
					
					var name = $("#name").val(); 
					if (name == ""){
						alert('กรุณาป้อนชื่อหน่วยงาน');
						return false;
					}
					
					var shortname = $("#shortname").val(); 
					if (shortname == ""){
						alert('กรุณาป้อนชื่อย่อหน่วยงาน');
						return false;
					}
					
					var desc =  $('#edit').froalaEditor('html.get');
					if (desc == ""){
						alert('กรุณาป้อนข้อมูลเนื้อหา');
						return false;
					}

					var address = $("#address").val();
					if (address == "") {
						alert('กรุณาป้อนที่อยู่');
						return false;
					}

					var telno = $("#telno").val();
					if (telno == "") {
						alert('กรุณาป้อนหมายเลขโทรศัพท์ติดต่อ');
						return false;
					}

					var location = $("#location").val();
					if (location == "") {
						alert('กรุณาป้อนลิงค์แผนที่');
						return false;
					}
					
					var data = new FormData(this);
					data.append('<?= Yii::$app->request->csrfParam ?>', $('#<?= Yii::$app->request->csrfParam ?>').val());
					data.append('cover',$("#cover").val());
					data.append('filecode','<?php echo $filecode; ?>');
					data.append('branchcode',$('#branchcode').val());
					data.append('name',$('#name').val());
					data.append('shortname',$('#shortname').val());
					data.append('ssobranch_type_id',$('#ssobranch_type_id').val());
					data.append('desc',$('#edit').froalaEditor('html.get'));
					data.append('address', $('#address').val());
					data.append('telno', $('#telno').val());
					data.append('location', $('#location').val());
					
					$.ajax({
						url:"<?php echo Yii::$app->urlManager->createAbsoluteUrl("branch/savedata"); ?>",
						method:"POST",
						enctype: 'multipart/form-data',
						contentType: false,
						cache: false,
						processData:false,
						data: data,
						dataType:"json",
						success: function (data) {
							if (data.status=='success') {
								alert('บันทึกข้อมูลเรียบร้อย');
								window.location.href='<?php echo Yii::$app->urlManager->createUrl('/admin/branch'); ?>';
							} else {
								alert(data.msg);
								$("#btnadd").removeAttr('disabled');
								return false;
							}
						}
					});
					e.preventDefault();
				};
			});
		});
	});
</script>