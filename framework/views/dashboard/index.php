<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="page">
	<input id="idnamechart" type="hidden" />

	<div class="page-content container-fluid">
		<h1 class="page-title">สถิติเจ้าหน้าที่<br><br></h1>
		<div class="row" data-plugin="matchHeight" data-by-row="true">
			<div class="col-xl-3 col-md-6" style="height: 109.15px;">
				<!-- Widget Linearea One-->
				<div class="card card-shadow" id="widgetLineareaOne">
					<div class="card-block p-20 pt-10 bg-teal-400">
						<div class="clearfix counter-inverse">
							<div class="float-left py-10">
								<i class="icon md-account font-size-30 vertical-align-middle mr-5"></i> ข้าราชการ
							</div>
							<span class="float-right font-size-30"><?php echo number_format($m33); ?></span>
						</div>

					</div>
				</div>
				<!-- End Widget Linearea One -->
			</div>
			<div class="col-xl-3 col-md-6" style="height: 109.15px;">
				<!-- Widget Linearea Two -->
				<div class="card card-shadow" id="widgetLineareaTwo">
					<div class="card-block p-20 pt-10 bg-green-400">
						<div class="clearfix counter-inverse">
							<div class="float-left py-10">
								<i class="icon md-account font-size-30 vertical-align-middle mr-5"></i> พนักงาน
							</div>
							<span class="float-right font-size-30"><?php echo number_format($m39); ?></span>
						</div>

					</div>
				</div>
				<!-- End Widget Linearea Two -->
			</div>
			<div class="col-xl-3 col-md-6" style="height: 109.15px;">
				<!-- Widget Linearea Three -->
				<div class="card card-shadow" id="widgetLineareaThree">
					<div class="card-block p-20 pt-10 bg-indigo-400">
						<div class="clearfix counter-inverse">
							<div class="float-left py-10">
								<i class="icon md-chart font-size-30 vertical-align-middle mr-5"></i> รวม
							</div>
							<span class="float-right font-size-30"><?php echo number_format($alldata); ?></span>
						</div>

					</div>
				</div>
				<!-- End Widget Linearea Three -->
			</div>


		</div>

		<div class="row">

			<div class="col-xl-6 col-lg-12">
				<div id="container2" class="card">
				</div>
				<!-- Card -->

				<!-- End Card -->
			</div>
			<div class="col-xl-6 col-lg-12">
				<!-- Card -->
				<div id="container1" class="card" style="height:550px;">
				</div>
				<!-- End Card -->
			</div>





			<div class="col-xl-12 col-lg-12">
				<!-- Card -->
				<div id="container3" class="card " style="height:400px;">

				</div>
				<!-- End Card -->
			</div>



		</div>

		<!-- End Card -->
	</div>
	<div class="col-xl-8 col-lg-12">


	</div>
</div>
</div>
</div>








<div class="modal" id="111111" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-simple modal-center modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="provicedetail">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="region" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-simple modal-center modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="regiondetail">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/th/th-all.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>




<script type="text/javascript">
	$(document).ready(function() {
		$('#txtStartDate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},
			language: 'th-TH'
		});

		$('#txtEndDate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},
			language: 'th-TH'
		});


		mapthai();
		chowregion();
		showchart();
		chowchartkeyword();
	});

	function testmodal() {
		alert("rtgtrgtrgtr");
		$("#111111").modal('show');
	}

	function fn_SearchData() {
		/*
	var StartDate = $('#txtStartDate').val();
	var EndDate = $('#txtEndDate').val();
	
	if(StartDate=='')
	{
			swal({
							title: "ข้อผิดพลาด",
							text: "กรุณาใส่วันที่",
							type: "warning",
							confirmButtonColor: "#00E5DA",
							confirmButtonText: "ปิด",
							closeOnConfirm: true
							},
						);
						return;
	}
	if(EndDate=='')
	{
			swal({
							title: "ข้อผิดพลาด",
							text: "กรุณาใส่วันที่",
							type: "warning",
							confirmButtonColor: "#00E5DA",
							confirmButtonText: "ปิด",
							closeOnConfirm: true
							},
						);
						return;
	}
	 $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("site/reportpermission"); ?>",
        data: {'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>','StartDate':StartDate,'EndDate':EndDate,},
                  
        success: function (data) {
         $('#tabletranservice').html(data);
        }
    }); 
*/
		//showchart() ;
	}

	function showchart() {

		/*
	
	var color='';
	var graphTarget1='';
	var barGraph1='';
	var chartdata='';
	var graphTarget='';
	var barGraph='';
	var typechart =$('#drpdep').val();
							if($('#drpdep').val()==''){
								
								typechart='bar'
							}
	var StartDate = $('#txtStartDate').val();
	var EndDate = $('#txtEndDate').val();
	var mytr1 = '';
							 $('#divgraph').empty()
							 $('#divgraph').show();
							 mytr1 ='<canvas  id="graphCanvas" height="70"></canvas>'
							$('#container').html(mytr1);
*/

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/message"); ?>",
			data: {
				'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>'
			},
			dataType: "json",
			success: function(data) {


				Highcharts.chart('container2', {
					chart: {
						type: 'pie',
						options3d: {
							enabled: true,
							alpha: 45,
							beta: 0
						}
					},
					title: {
						text: 'จำนวนเจ้าหน้าที่ประกันสังคมที่แยกเป็นภูมิภาค'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.y}%</b>'
					},
					accessibility: {
						point: {
							valueSuffix: '%'
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							innerSize: 100,
							cursor: 'pointer',
							depth: 50,
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.y} %'
							}
						},


					},
					series: [{
						type: 'pie',
						name: 'คิดเป็นเปอร์เซ็น',
						data: data.chart
					}]
				});




				// chart naw


			}
		});



	}


	function mapthai() {
		// Prepare demo data
		// Data is joined to map using value of 'hc-key' property by default.
		// See API docs for 'joinBy' for more info on linking data and map.


		// Create the chart

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/sso_provice"); ?>",
			data: {
				'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>'
			},
			dataType: "json",
			success: function(data) {

				Highcharts.mapChart('container1', {
					chart: {
						map: 'countries/th/th-all'
					},

					title: {
						text: 'แสดงข้อมูลเจ้าหน้าที่ประกันสังคมแบบแผนที่ประเทศไทย'
					},

					subtitle: {
						text: 'จำนวนแยกตามความเข้มของสี'
					},

					mapNavigation: {
						enabled: true,
						buttonOptions: {
							verticalAlign: 'bottom'
						}
					},

					colorAxis: {
						min: 0
					},
					plotOptions: {

						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function(e) {


										$.ajax({
											type: "POST",
											url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/sso_provicedetail"); ?>",
											data: {
												'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
												'name': this.name
											},
											dataType: "json",
											success: function(data) {
												var provice = data.provice_name

												Highcharts.chart('provicedetail', {
													chart: {
														type: 'column'
													},
													title: {
														text: 'จำนวผู้ใช้ไลน์ จังหวัด ' + provice
													},
													subtitle: {
														text: 'แยกเป็นแต่ละมาตรา'
													},
													accessibility: {
														announceNewData: {
															enabled: true
														}
													},
													xAxis: {
														type: 'category'
													},
													yAxis: {
														title: {
															text: 'Total percent market share'
														}

													},
													legend: {
														enabled: false
													},
													plotOptions: {
														series: {
															borderWidth: 0,
															dataLabels: {
																enabled: true,
																format: '{point.y} คน'
															}
														}
													},

													tooltip: {

														pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} คน</b> of total<br/>'
													},

													series: [{
														name: "",
														colorByPoint: true,
														data: data.provicedetail
													}],

												});
											}

										});

										$("#111111").modal('show');

									}
								}
							}
						}

					},
					series: [{
						data: data.chart,
						name: '',
						states: {
							hover: {
								color: '#BADA55'
							}
						},
						dataLabels: {
							enabled: true,
							format: '{point.name}'
						}
					}]
				});
			}
		});


	}

	function showchart3() {




		var color = '';
		var graphTarget1 = '';
		var barGraph1 = '';
		var chartdata = '';
		var graphTarget = '';
		var barGraph = '';
		var typechart = $('#drpdep').val();
		if ($('#drpdep').val() == '') {

			typechart = 'bar'
		}
		var StartDate = $('#txtStartDate').val();
		var EndDate = $('#txtEndDate').val();
		var nametype = $('#idnamechart').val();
		/*	var mytr1 = '';
									 $('#divgraph').empty()
									 $('#divgraph').show();
									 mytr1 ='<canvas  id="graphCanvas" height="70"></canvas>'
									$('#modalshow').html(mytr1);
		*/

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("site/showdatadatachart"); ?>",
			data: {
				'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
				'StartDate': StartDate,
				'EndDate': EndDate,
			},
			dataType: "json",
			success: function(data) {

				//	console.log(data.count)

				Highcharts.chart('modalshow', {
					chart: {
						type: 'line'
					},
					title: {
						text: 'กราฟแสดงผู้ร้องเรียนในแต่ละประเภท'
					},
					subtitle: {
						text: 'แสดงตามช่วงเวลา'
					},
					xAxis: {
						categories: data.date
					},
					yAxis: {
						title: {
							text: 'จำนวน'
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: nametype,
						data: data.count
					}]
				});

			}
		});


	}

	function chowchartline() {
		Highcharts.chart('container3', {

			title: {
				text: 'จำนวนผู้เข้าใช้ Line ประกันสังคม ของแต่ละปี'
			},

			subtitle: {
				text: 'แบ่งเป็นตามแต่ละมาตรา'
			},

			yAxis: {
				title: {
					text: 'Number of Employees'
				}
			},

			xAxis: {
				accessibility: {
					rangeDescription: 'Range: 2010 to 2020'
				}
			},

			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},

			plotOptions: {
				series: {
					label: {
						connectorAllowed: false
					},
					pointStart: 2555,

				}
			},

			series: [{
				name: 'มาตรา 33',
				data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
			}, {
				name: 'มาตรา 39',
				data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434, ]
			}, {
				name: 'มาตรา 40',
				data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
			}],

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

		});
	}

	function chowchartkeyword() {

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/sso_keyword"); ?>",
			data: {
				'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>'
			},
			dataType: "json",
			success: function(data) {

				Highcharts.chart('container5', {
					chart: {
						type: 'column',
						options3d: {
							enabled: true,
							alpha: 10,
							beta: 25,
							depth: 70
						}
					},
					title: {
						text: 'จำนวนคำหรือ keyword ที่เพื่อนในไลน์พิมพ์เข้ามา'
					},
					subtitle: {
						text: '(กรณีใช้การตอบกลับแบบอัตโนมัติเท่านั้น)'
					},
					plotOptions: {
						column: {
							depth: 25
						}
					},
					xAxis: {
						categories: ["เงื่อนไขเงินบำเหน็จ", "ลงทะเบียนว่างงาน", "สงเคราะบุตร", "เจ็บป่วย"],
						labels: {
							skew3d: true,
							style: {
								fontSize: '16px'
							}
						}
					},
					yAxis: {
						title: {
							text: null
						}
					},
					series: [{
						name: 'Sales',
						data: data.chart
					}]
				});
			}
		});
	}

	function chowregion() {

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/sso_region"); ?>",
			data: {
				'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>'
			},
			dataType: "json",
			success: function(data3) {

				console.log(data3);
				// Create the chart
				Highcharts.chart('container3', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'เจ้าหน้าที่'
					},
					subtitle: {
						text: 'จำนวนเจ้าหน้าที่แยกแต่ละภูมิภาค'
					},
					accessibility: {
						announceNewData: {
							enabled: true
						}
					},
					xAxis: {
						type: 'category'
					},
					yAxis: {
						title: {
							text: 'จำนวนเจ้าหน้าที่แยกแต่ละภูมิภาค'
						}

					},
					legend: {
						enabled: false
					},
					plotOptions: {
						series: {
							borderWidth: 0,
							dataLabels: {
								enabled: true,
								format: '{point.y} คน'
							},
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										$.ajax({
											type: "POST",
											url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("/dashboard/sso_regiondetail"); ?>",
											data: {
												'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
												'name': this.name
											},
											dataType: "json",
											success: function(data1) {


												Highcharts.chart('regiondetail', {
													chart: {
														type: 'column'
													},
													title: {
														text: 'ผู้ประกันตนที่ใช้งานไลน์จำแนกเป็นแต่ละจังหวัด'
													},
													subtitle: {
														text: 'สามารถแยกเป็นแต่ละมาตราได้'
													},
													accessibility: {
														announceNewData: {
															enabled: true
														}
													},
													xAxis: {
														type: 'category'
													},
													yAxis: {
														title: {
															text: 'จำนวนผู้ประกันตนในแต่ละแต่ละจังหวัด'
														}

													},
													legend: {
														enabled: false
													},
													plotOptions: {
														series: {
															borderWidth: 0,
															dataLabels: {
																enabled: true,
																format: '{point.y} คน'
															}
														}
													},

													tooltip: {
														pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}คน</b> of total<br/>'
													},

													series: [{

														colorByPoint: true,
														data: data1.region_detail
													}],
													drilldown: {
														series: data1.region_provice1
													}
												});
											}

										});
										$("#region").modal('show');
									}
								}
							}
						}
					},

					tooltip: {

						pointFormat: ' <b>{point.y:.2f}%</b> of total<br/>'
					},

					series: [{

						colorByPoint: true,
						data: data3.chart
					}],



				});
			}
		});

	}
</script>