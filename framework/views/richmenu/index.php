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
													<label class="col-md-2 col-form-label control-label">รายละเอียดเมนู</label>
													<div class="col-md-8">

														<textarea id="w3review" name="w3review" rows="10" cols="50" style="width: 100%;">

														</textarea>
													</div>
												</div>

												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">เงื่อนไข</label>
													<div class="col-md-8">
														<select class="form-control" id="selcontent_category_id" name="selcontent_category_id">

															<option value="1">มาตรา40</option>
															<option value="2">มาตรา39</option>
															<option value="3">มาตรา33</option>

														</select>
														<select class="form-control" id="selcontent_category_id" name="selcontent_category_id">

															<option value="1">สำนักงานประกันสังคมกรุงเทพมหานครพื้นที่ 1</option>
															<option value="2">สำนักงานประกันสังคมจังหวัดสมุทรปราการ</option>
															<option value="3">สำนักงานประกันสังคมจังหวัดนนทบุรี</option>

														</select>														
													</div>
												</div>

												<div class="form-group row pl-5 required">
													<label class="col-md-2 col-form-label control-label">รูปภาพขนาด 2500x1686 หรือ 2500x843</label>
													<div class="col-md-8">
														<input type="file" id="myfile" name="myfile">
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
</script>