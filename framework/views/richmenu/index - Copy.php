<?php
$this->pageTitle  = 'หน้าหลัก' . Yii::app()->params['prg_ctrl']['pagetitle'];
//$folder = Yii::app()->params['prg_ctrl']['url']['thumbnail'];
$themesurl = Yii::app()->params['prg_ctrl']['url']['themes'];

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
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="">หน้าหลัก</a></li>
			<li class="breadcrumb-item active">Rich menu</li>
		</ol>
	</div>

	<div class="page-content">
		<!-- Panel jvectormap -->
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row row-lg">

					<?php

					//$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(''); var_dump($httpClient);
					use \LINE\LINEBot\RichMenuBuilder;
					use \LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
					use \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
					use \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

					use \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
					use \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

					use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
					//$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
					//$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
					//$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder(...);
					//$response = $bot->createRichMenu($richMenuBuilder);



					$rich =    new RichMenuBuilder(
						new RichMenuSizeBuilder(1686, 2500), // ขนาด rich menu ปกติจะไม่เปลี่ยน แปลง
						true, // เปิดให้แสดง * จะไม่แสดงทันที 
						"Rich Menu 1", // ชื่อ rich menu
						"เมนู", // ข้อความที่จะแสดงที่แถบเมนู
						array( // array ของ action แต่ละบริเวณ
							new RichMenuAreaBuilder( // action ที่ 1
								new RichMenuAreaBoundsBuilder(0, 0, 1250, 1686), // พื้นที่ A (x,y,width,height)
								new MessageTemplateActionBuilder('m', 'Area A') // เปลี่ยนเฉพาะตัวที่ 2 ตามต้องการ 'Area A'
							),
							new RichMenuAreaBuilder( // action ที่ 2
								new RichMenuAreaBoundsBuilder(1250, 0, 1250, 1686), // พื้นที่ B (x,y,width,height)
								new UriTemplateActionBuilder('u', 'http://niik.in') // เปลี่ยนเฉพาะตัวที่ 2 ตามต้องการ 'http://niik.in'
							),
						)
					);



					$height = 1686;
					$width = 2500;
					$ncol = 4;
					$nrow = 2;
					$xstep = $width / $ncol;
					$ystep = $height / $nrow;
					$nitem = $nrow * $ncol;


					for ($i = 0; $i < $nrow; $i++) {
						$y = $ystep * $i;
						for ($j = 0; $j < $ncol; $j++) {
							$x = $xstep * $j;
							//echo $x . ", " . $y . ", " . $xstep . ", " . $ystep . "<br/>";
							//echo $ncol*$i+$j . "<br/>";
						}
					}
					?>

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
														<input type="text" id="poll_title" name="poll_title" class="form-control" placeholder="ชื่อเมนู" value="">
													</div>
												</div>

												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">กำหนดค่า default ในการแสดงผล</label>
													<div class="col-md-8">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="rdoselected1" id="rdoselected1" value="Yes" />
															<label class="form-check-label" for="rdoselected1">
																Yes
															</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="rdoselected1" id="rdoselected2" value="No" checked />
															<label class="form-check-label" for="rdoselected2">
																No
															</label>
														</div>
													</div>
												</div>

												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">Chat bar text</label>
													<div class="col-md-8">
														<input type="text" id="chatbartext" name="chatbartext" class="form-control" placeholder="" value="">
													</div>
												</div>




												<div class="form-group row pl-5" style="border-bottom: 1px solid #ebebeb;">
													<h4 class="col-md-3">เลือกรูปแบบตามต้องการ </h4>
												</div>
												<div class="row pl-5 required">

													<label class="col-md-12 control-label">ขนาดใหญ่</label>

													<div class="row col">
														<div class="hiddenradio">
															<div>
																<label>
																	<input type="radio" name="richtype" value="1" checked>
																	<img src="https://lineforbusiness.com/richmenumaker/assets/layout/type_richmenu_01.png">
																</label>
															</div>
															<div>

																<label>
																	<input type="radio" name="richtype" value="2">
																	<img src="https://lineforbusiness.com/richmenumaker/assets/layout/type_richmenu_02.png">
																</label>
															</div>
														</div>
													</div>


												</div>
												<div class="row pl-5 required">

													<label class="col-md-12 control-label">ขนาดเล็ก</label>
													<div class="row col">
														<div class="hiddenradio">
															<div>
																<label>
																	<input type="radio" name="richtype" value="3" >
																	<img src="https://lineforbusiness.com/richmenumaker/assets/layout/type_richmenu_08.png">
																</label>
															</div>
															<div>

																<label>
																	<input type="radio" name="richtype" value="4">
																	<img src="https://lineforbusiness.com/richmenumaker/assets/layout/type_richmenu_11.png">
																</label>
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
			</div>
		</div>
		<!-- End Panel jvectormap -->
	</div>
</div>
<!-- End Page -->




<script type="text/javascript">
	jQuery(document).ready(function($) {



	});
</script>