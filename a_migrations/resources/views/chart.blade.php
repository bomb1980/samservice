@section('top_content_search')
    <div class="breadcrumb-wrapper d-none d-sm-block float-right">
        <ol class="breadcrumb border-none p-0 mb-0 pl-1">
            <li class="breadcrumb-item breadcrumb-item-none">
                <div class="dropdown">
                    {!! Form::select('searchGender', $searchGenders, $searchGender, [
                        'id' => 'searchGender',
                        'placeholder' => 'Gender',
                    ]) !!}
                </div>
            </li>
            <li class="breadcrumb-item breadcrumb-item-none">
                <div class="dropdown">
                    {!! Form::select('searchBMI', $searchBMIs, $searchBMI, ['id' => 'searchBMI', 'placeholder' => 'BMI']) !!}
                </div>
            </li>
            <li class="breadcrumb-item breadcrumb-item-none">
                <div class="dropdown">
                    {!! Form::select('searchCD', $searchCDs, $searchCD, ['id' => 'searchCD', 'placeholder' => 'Congenital Disease']) !!}
                </div>
            </li>
            <li class="breadcrumb-item breadcrumb-item-none">
                <div class="dropdown">
                    {!! Form::select('searchLocation', $searchLocations, $searchLocation, [
                        'id' => 'searchLocation',
                        'placeholder' => 'Location',
                    ]) !!}
                </div>
            </li>
            </li>
            <li class="breadcrumb-item breadcrumb-item-none">
                <div class="dropdown">
                    <fieldset class="position-relative has-icon-left mr-1">
                        <input type="text" class="form-control dateranges" placeholder="Select Date">
                        <div class="form-control-position">
                            <i class='bx bx-calendar-check'></i>
                        </div>
                    </fieldset>
                </div>
            </li>
            <li class="breadcrumb-item breadcrumb-item-none" style="margin: 8px 0;">
                {{ Form::open(['url' => 'admin/dashboardexcel']) }}
                {!! Form::hidden('excel_get_userid', $get_userid) !!}
                {!! Form::hidden('excel_Gender', null) !!}
                {!! Form::hidden('excel_BMI', null) !!}
                {!! Form::hidden('excel_CD', null) !!}
                {!! Form::hidden('excel_Location', null) !!}
                {!! Form::hidden('excel_start_dateranges', null) !!}
                {!! Form::hidden('excel_end_dateranges', null) !!}
                <button type="submit" class="border-0" style="background-color: transparent;">
                    <img class="btn-excel mr-1" style="cursor: pointer;" src="{{ asset('images/icon/typeExcel.png') }}">
                </button>
                {{ Form::close() }}
            </li>
            <li class="breadcrumb-item breadcrumb-item-none" style="margin: 8px 0;">
                {{ Form::open(['url' => 'admin/dashboardmail']) }}
                {!! Form::hidden('convertEmail', $convertEmail, [
                    'wire:model' => 'convertEmail',
                    'id' => 'convertEmail',
                    'class' => 'form-control',
                ]) !!}
                <button type="submit" class="border-0" style="background-color: transparent;">
                    <img class="btn-excel" style="cursor: pointer;" src="{{ asset('images/icon/Vector.png') }}">
                </button>
                {{ Form::close() }}
            </li>
        </ol>
    </div>
@endsection
{{-- page Title --}}
<div>
    {{-- <div class="row">
        <div class="col">
            customer id : {{ print_r($per_excel) }}
            customer id : {{ $get_userid }}
            search : {{ $searchGender }}
        </div>
    </div> --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card dashboard_1">
                <div class="card-header pb-0">
                    <h6 class="text-white h61rem">ผู้ใช้งานทั้งหมด</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="dashboard-content-left">
                            <div class="conversion-title">
                                <h6 class="text-white count1625rem" id="all_user">
                                    {{ count($dataA) }}
                                </h6>
                                <p class="text-white h61rem">
                                    <i class="bx bx-trending-up font-size-small align-middle mr-25 text-white"></i>
                                    {{ $dataC }}% Last Month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card dashboard_2">
                <div class="card-header pb-0">
                    <h6 class="text-white h61rem">ผู้ใช้งานใหม่</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="dashboard-content-left">
                            <div class="conversion-title">
                                <h6 class="text-white count1625rem" id="all_user">
                                    {{ count($dataD) }}
                                </h6>
                                <p class="text-white h61rem">
                                    <i class="bx bx-trending-up font-size-small align-middle mr-25 text-white"></i>
                                    {{ $dataF }}% Last Month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card dashboard_3">
                <div class="card-header pb-0">
                    <h6 class="text-white h61rem">ผู้ไม่ได้ใช้งาน</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="dashboard-content-left">
                            <div class="conversion-title">
                                <h6 class="text-white count1625rem" id="all_user">
                                    {{ count($dataG) }}
                                </h6>
                                <p class="text-white h61rem">
                                    <i class="bx bx-trending-up font-size-small align-middle mr-25 text-white"></i>
                                    {{ $dataJ }}% Last Month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card dashboard_4">
                <div class="card-header pb-0">
                    <h6 class="text-white h61rem">อัตราการใช้งานซ้ำ</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="dashboard-content-left">
                            <div class="conversion-title">
                                <h6 class="text-white count1625rem" id="all_user">
                                    {{ $dataM }}
                                </h6>
                                <p class="text-white h61rem">
                                    <i class="bx bx-trending-up font-size-small align-middle mr-25 text-white"></i>
                                    {{ $dataO }}% Last Month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title cardtitle125">ช่วงเวลาที่คนเริ่มใช้งาน</h4>
                </div>
                <div class="card-body p-0">
                    <div id="order-summary-chart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- card group --}}
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="row">
                {{-- start row card 4 --}}
                <div class="col-3">
                    <div class="card text-center mb-1">
                        <div class="card-body card-body-4 py-1">
                            <div class="media d-flex">
                                <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-auto">
                                    <i class="bx bx-run font-medium-2"></i>
                                </div>
                                <div class="media-body text-left">
                                    <small class="text-muted line-ellipsis">ความเร็วเฉลี่ย</small><br>
                                    <small class="mb-0 line-ellipsis2">{{ $dataP }} km/h</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center mb-1">
                        <div class="card-body card-body-4 py-1">
                            <div class="media d-flex">
                                <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-auto">
                                    <i class="bx bx-map font-medium-2"></i>
                                </div>
                                <div class="media-body text-left">
                                    <small class="text-muted line-ellipsis">ระยะทางเฉลี่ย</small><br>
                                    <small class="mb-0 line-ellipsis2">{{ $dataQ }} m</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center mb-1">
                        <div class="card-body card-body-4 py-1">
                            <div class="media d-flex">
                                <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-auto">
                                    <i class="bx bx-droplet font-medium-2"></i>
                                </div>
                                <div class="media-body text-left">
                                    <small class="text-muted line-ellipsis">ระดับน้ำเฉลี่ย</small><br>
                                    <small class="mb-0 line-ellipsis2">{{ $dataR }} cm</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-center mb-1">
                        <div class="card-body card-body-4 py-1">
                            <div class="media d-flex">
                                <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-auto">
                                    <i class="bx bxs-thermometer font-medium-2"></i>
                                </div>
                                <div class="media-body text-left">
                                    <small class="text-muted line-ellipsis">อุณหภูมิเฉลี่ย</small><br>
                                    <small class="mb-0 line-ellipsis2">{{ $dataS }} ํC</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end row card 4 --}}
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title cardtitle125">การเปิด/ปิด Jet</h4>
                            {{-- <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i> --}}
                        </div>
                        <div class="card-body row py-0">
                            <div class="col-2">
                                <div class="h-100 row align-items-center">
                                    <button class="btn btn-primary btn-sm">Front</button>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-6 text-center">LEFT</div>
                                    <div class="col-6 text-center">RIGHT</div>
                                </div>
                                <div class="row form-group">
                                    <div id="radial-chart1" class="col-6"></div>
                                    <div id="radial-chart3" class="col-6"></div>
                                </div>
                                <div class="row form-group">
                                    <div id="radial-chart2" class="col-6"></div>
                                    <div id="radial-chart4" class="col-6"></div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <hr style="background-color: #1aa1ba; height: 1px;">
                        </div>
                        {{-- <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title cardtitle125">การเปิด/ปิด Jet</h4>
                        </div> --}}
                        <div class="card-body row py-0">
                            <div class="col-2">
                                <div class="h-100 row align-items-center">
                                    <button class="btn btn-primary btn-sm">Back</button>
                                </div>
                            </div>
                            <div class="col-10">
                                {{-- <div class="row">
                                    <div class="col-6 text-center">ฝั่งซ้าย</div>
                                    <div class="col-6 text-center">ฝั่งขวา</div>
                                </div> --}}
                                <div class="row form-group">
                                    <div id="radial-chart5" class="col-6"></div>
                                    <div id="radial-chart7" class="col-6"></div>
                                </div>
                                <div class="row form-group">
                                    <div id="radial-chart6" class="col-6"></div>
                                    <div id="radial-chart8" class="col-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title cardtitle125">การเปิดไฟเครื่อง</h6>
                        </div>
                        <div class="card-body" style="height: 160px;">
                            <div id="semi-circle-chart" class="gauge-chart ct-golden-section"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Slope</h4>
                        </div>
                        <div class="card-body" style="height: 310px !important;">
                            <div id="bar-chart" class="horizontal-bar-chart ct-golden-section"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-12 dashboard-referral-impression">
            <div class="row">
                <!-- Referral Chart Starts-->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title cardtitle125">ระยะเวลาการใช้งานเครื่อง</h4>
                        </div>
                        <div class="card-body pb-0" style="height: 240px;">
                            <div id="pie-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title cardtitle125">วันที่คนเข้าใช้งาน</h4>
                        </div>
                        <div class="card-body pb-1" style="height: 310px !important;">
                            <div id="column-custom-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function set_search() {
            $("#searchGender").select2({
                placeholder: "Gender",
                dropdownAutoWidth: true,
                width: '100%'
            });

            $("#searchBMI").select2({
                placeholder: "BMI",
                dropdownAutoWidth: true,
                width: '100%'
            });

            $("#searchCD").select2({
                placeholder: "Congenital Disease",
                dropdownAutoWidth: true,
                width: '100%'
            });

            $("#searchLocation").select2({
                placeholder: "Location",
                dropdownAutoWidth: true,
                width: '100%'
            });

            $('.dateranges').daterangepicker({
                // opens: 'bottom'
                opens: 'left',
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }, function(start, end, label) {
                @this.set('start_dateranges', start.format('YYYY-MM-DD'));
                @this.set('end_dateranges', end.format('YYYY-MM-DD'));

                $('input[name="excel_start_dateranges"]').val(start.format('YYYY-MM-DD'));
                $('input[name="excel_end_dateranges"]').val(end.format('YYYY-MM-DD'));

            });
        }


        function loadData() {

            var optionsJet1 = {
                series: [{{ $jet1 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                fontSize: '10px',
                                color: '#000000',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 1'],
            }
            var chartJet1 = new ApexCharts(document.querySelector("#radial-chart1"), optionsJet1);
            chartJet1.render();

            var optionsJet2 = {
                series: [{{ $jet2 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                fontSize: '10px',
                                color: '#000000',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 2'],
            }
            var chartJet2 = new ApexCharts(document.querySelector("#radial-chart2"), optionsJet2);
            chartJet2.render();

            var optionsJet3 = {
                series: [{{ $jet3 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                fontSize: '10px',
                                color: '#000000',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 3'],
            }
            var chartJet3 = new ApexCharts(document.querySelector("#radial-chart3"), optionsJet3);
            chartJet3.render();

            var optionsJet4 = {
                series: [{{ $jet4 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                color: '#000000',
                                fontSize: '10px',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 4'],
            }
            var chartJet4 = new ApexCharts(document.querySelector("#radial-chart4"), optionsJet4);
            chartJet4.render();

            var optionsJet5 = {
                series: [{{ $jet5 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                fontSize: '10px',
                                color: '#000000',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 5'],
            }
            var chartJet5 = new ApexCharts(document.querySelector("#radial-chart5"), optionsJet5);
            chartJet5.render();

            var optionsJet6 = {
                series: [{{ $jet6 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                fontSize: '10px',
                                color: '#000000',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 6'],
            }
            var chartJet6 = new ApexCharts(document.querySelector("#radial-chart6"), optionsJet6);
            chartJet6.render();

            var optionsJet7 = {
                series: [{{ $jet7 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                color: '#000000',
                                fontSize: '10px',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 7'],
            }
            var chartJet7 = new ApexCharts(document.querySelector("#radial-chart7"), optionsJet7);
            chartJet7.render();

            var optionsJet8 = {
                series: [{{ $jet8 }}],
                chart: {
                    height: '90%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: '50%',
                            // image: '/images/icon/fier.png',
                            imageWidth: 30,
                            imageHeight: 64,
                            imageClipped: false
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                color: '#000000',
                                offsetY: 15,
                                fontSize: '10px',
                            },
                            value: {
                                show: true,
                                color: '#000000',
                                fontSize: '10px',
                                offsetY: -20,
                            }
                        }
                    }
                },
                colors: ['#1AA1BA'],
                stroke: {
                    lineCap: 'round'
                },
                labels: ['Jet 8'],
            }
            var chartJet8 = new ApexCharts(document.querySelector("#radial-chart8"), optionsJet8);
            chartJet8.render();

            var optionsOpen = {
                series: [{{ $openPer }}],
                chart: {
                    // height: 390,
                    type: 'radialBar',
                    offsetY: -20,
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        dataLabels: {
                            textAnchor: 'start',
                            name: {
                                fontSize: '12px',
                                offsetY: -5,
                                color: '#000000',
                            },
                            value: {
                                fontSize: '12px',
                                offsetY: -40,
                                color: '#000000',
                            }
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -10
                    }
                },
                colors: ['#1AA1BA'],
                labels: ['เปิดไฟ'],
            }

            var chartOpen = new ApexCharts(document.querySelector("#semi-circle-chart"), optionsOpen);
            chartOpen.render();

            // var dateQueryWater = {!! json_encode($waterVolumn) !!};
            var optionsSlope = {
                series: [{
                    name: [],
                    data: [{{ $waterVolumn0 }}, {{ $waterVolumn1 }}, {{ $waterVolumn2 }},
                        {{ $waterVolumn3 }},
                        {{ $waterVolumn4 }}, {{ $waterVolumn5 }}
                    ]
                }],
                chart: {
                    toolbar: {
                        show: false,
                    },
                    type: 'bar',
                    height: 280
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [
                        5, 4, 3, 2, 1, 0
                    ],
                },
                colors: ['#1AA1BA'],
                tooltip: {
                    custom: function({
                        value,
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        var data = w.config.xaxis.categories[dataPointIndex];
                        return (
                            "<div class='alert alert-secondary text-center mb-0' role='alert'>" + series[
                                seriesIndex][dataPointIndex] + " คน (" +
                            avergeSeries(series, series[seriesIndex][dataPointIndex]) + "%)<br/>slope " + data +
                            "</div>");
                    }
                }
            };
            var chartSlope = new ApexCharts(document.querySelector("#bar-chart"), optionsSlope);
            chartSlope.render();

            var pieChartOptions = {
                chart: {
                    // height: '80%',
                    type: 'pie',
                },
                colors: ['#1AA1BA', '#2EC6E2', '#137688', '#CBF1F8', '#48E9DF'],
                labels: ['1-10 min', '11-20 min', '21-30 min', '31-40 min', '41-50 min'],
                series: [{{ $time10 }}, {{ $time20 }}, {{ $time30 }}, {{ $time40 }},
                    {{ $time50 }}
                ],
                legend: {
                    itemMargin: {
                        horizontal: 2
                    },
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        // chart: {
                        //     width: 220
                        // },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        var data = w.config.labels[seriesIndex];
                        return (
                            "<div class='alert alert-secondary text-center mb-0' role='alert'>" + series[
                                seriesIndex] + " คน (" +
                            avergeSeries(series, series[seriesIndex]) + "%)</br>" + data + "</div>");
                    }
                }
            }
            var pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieChartOptions);
            pieChart.render();

            var optionsDayWeeks = {
                series: [{
                    data: [
                        {{ $DayMon }},
                        {{ $DayTue }},
                        {{ $DayWed }},
                        {{ $DayThu }},
                        {{ $DayFri }},
                        {{ $DaySat }},
                        {{ $DaySun }}
                    ]
                }],
                chart: {
                    toolbar: {
                        show: false,
                    },
                    height: 300,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                        distributed: true,
                    }
                },
                colors: ['#1AA1BA'],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        'MON',
                        'TUE',
                        'WED',
                        'THU',
                        'FRI',
                        'SAT',
                        'SUN'
                    ]
                },
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        // console.log(w)
                        var data = w.config.xaxis.categories[dataPointIndex];
                        return (
                            "<div class='alert alert-secondary text-center mb-0' role='alert'>" + series[
                                seriesIndex][dataPointIndex] + " คน (" + avergeSeries(series, series[
                                seriesIndex][dataPointIndex]) + "%)</br>" + data + "</div>");
                    }
                }
            };
            var chartDayWeeks = new ApexCharts(document.querySelector("#column-custom-chart"), optionsDayWeeks);
            chartDayWeeks.render();

            var dateQuery = {!! json_encode($timeuseAll) !!};

            var options = {
                series: [{
                    data: dateQuery
                }],
                chart: {
                    toolbar: {
                        show: false,
                    },
                    height: 350,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    labels: {
                        formatter: function(value) {
                            return value + ":00";
                        }
                    }
                },
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        var data = w.config.series[seriesIndex].data[dataPointIndex].x;
                        // console.log(data)
                        return ("<div class='alert alert-secondary text-center mb-0' role='alert'>" + series[
                            seriesIndex][dataPointIndex] + " คน <br/>" + data + ":00 น.</div>");
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#order-summary-chart"), options);
            chart.render();

        }

        document.addEventListener('livewire:load', function() {
            set_search();
            loadData();

            window.livewire.on('event', () => {
                set_search();
                loadData();
            });

            $("#searchGender").on('change', function(e) {
                @this.set('searchGender', e.target.value);
                $('input[name="excel_Gender"]').val(e.target.value);
            });

            $("#searchBMI").on('change', function(e) {
                @this.set('searchBMI', e.target.value);
                $('input[name="excel_BMI"]').val(e.target.value);
            });

            $("#searchCD").on('change', function(e) {
                @this.set('searchCD', e.target.value);
                $('input[name="excel_CD"]').val(e.target.value);
            });

            $("#searchLocation").on('change', function(e) {
                @this.set('searchLocation', e.target.value);
                $('input[name="excel_Location"]').val(e.target.value);
            });
        });

        function avergeSeries(series, index) {
            var total = 0;
            for (var i = 0; i < series.length; i++) {
                total += parseFloat(series[i]);
            }
            return parseFloat((index / total) * 100).toFixed(2);
        }
    </script>
</div>
