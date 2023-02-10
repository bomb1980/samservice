@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ตารางข้อมูลรายงานสรุปข้อมูลรายได้เฉลี่ยต่อเดือนแยกตามหลักสูตร</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">รายงาน</a></li>
                <li class="breadcrumb-item active">ตารางข้อมูลรายงานสรุปข้อมูลรายได้เฉลี่ยต่อเดือนแยกตามหลักสูตร</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="panel form-group">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            {!! Form::open([
                                'wire:submit.prevent' => 'submit()',
                                'autocomplete' => 'off',
                                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                            ]) !!}
                            <div class="form-group row">
                                <label class="col-md-1 form-control-label">ปีงบประมาณ </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกปีงบประมาณ</option>
                                        <option value="">2565</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">งวดที่ </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกงวด</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">ช่วงเวลา </label>
                                <div class="col-md-1">
                                    <input type="text" class="form-control">
                                </div>
                                -
                                <div class="col-md-1">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 form-control-label">ประเภทกิจกรรม </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกประเภทกิจกรรม</option>
                                        <option value="">กิจกรรมจ้างงานเร่งด่วน</option>
                                        <option value="">กิจกรรมทักษะฝีมือแรงงาน</option>
                                    </select>
                                </div>
                                {{-- <label class="col-md-1 form-control-label">รูปแบบ </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกรูปแบบ</option>
                                        <option value="">ภาพรวมประเทศ</option>
                                        <option value="">รายภาค</option>
                                        <option value="">จังหวัด</option>
                                    </select>
                                </div> --}}
                                <label class="col-md-1 form-control-label">ภูมิภาค </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกภาค</option>
                                        <option value="">เหนือ</option>
                                        <option value="">กลาง</option>
                                        <option value="">ตะวันออก</option>
                                        <option value="">ตะวันออกเฉียงเหนือ</option>
                                        <option value="">ใต้</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">หน่วยงาน </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกหน่วยงาน</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 form-control-label">คำค้น </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="" />
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-primary" wire:click="showReport"><i
                                            class="icon fa-file-word-o pr-1" aria-hidden="true"></i> รายงาน Word</button>
                                    <button class="btn btn-primary" wire:click="exportExcel"><i class="icon fa-file-excel-o"
                                            aria-hidden="true"></i> รายงาน Excel</button>
                                    <a class="btn btn-primary" target="_blank" href="#"><i
                                            class="icon fa-file-pdf-o pr-1" aria-hidden="true"></i>รายงาน PDF</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel form-group">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-6 text-center">
                            <figure class="highcharts-figure">
                                <div id="chart1"></div>
                            </figure>
                        </div>
                        <div class="col-md-6 text-center">
                            <figure class="highcharts-figure">
                                <div id="chart2"></div>
                            </figure>
                        </div>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-6 text-center">
                            <figure class="highcharts-figure">
                                <div id="chart3"></div>
                            </figure>
                        </div>
                        <div class="col-md-6 text-center">
                            <figure class="highcharts-figure">
                                <div id="chart4"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel form-group">
                <div class="panel-body container-fluid">
                    <table class="table table-bordered table-hover table-striped dataTable text-center" id="Datatables">
                        <thead>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center">จำนวนผู้เข้าร่วมกิจกรรมจ้างงาน</td>
                                <td class="text-center">จำนวนผู้เข้าร่วมกิจกรรมฝึกอบรม</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left"><b>ภาพรวมประเทศ</b></td>
                                <td class="text-center">100</td>
                                <td class="text-center">58</td>
                            </tr>
                            <tr>
                                <td class="text-left"><b>ภาครวม</b></td>
                                <td class="text-center">60</td>
                                <td class="text-center">58</td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-2">จังหวัดเลย</font>
                                </td>
                                <td class="text-center">20</td>
                                <td class="text-center">18</td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-4">ซ่อมฝายชะลอน้ำ</font>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-4">ซ่อมกำแพง</font>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-2">จังหวัดเชียงใหม่</font>
                                </td>
                                <td class="text-center">2</td>
                                <td class="text-center">20</td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-4">ทำแนวกันไฟป่า</font>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <font class="ml-4">ซ่อมวัด</font>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        $("select").select2();

        Highcharts.chart('chart1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'กิจกรรม'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'กิจกรรมจ้างงานเร่งด่วน',
                    y: 70.67,
                }, {
                    name: 'กิจกรรมทักษะฝีมือแรงงาน',
                    y: 14.77
                }]
            }]
        });

        Highcharts.chart('chart2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'ภูมิภาค'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                        name: 'ภาคตะวันตก',
                        y: 20,
                    },
                    {
                        name: 'ภาคตะวันออก',
                        y: 20
                    },
                    {
                        name: 'ภาคกลาง',
                        y: 20
                    },
                    {
                        name: 'ภาคเหนือ',
                        y: 20
                    },
                    {
                        name: 'ภาคใต้',
                        y: 10
                    },
                    {
                        name: 'ภาคตะวันออกเฉียงเหนือ',
                        y: 10
                    },
                ]
            }]
        });

        Highcharts.chart('chart3', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'จังหวัด'
            },
            subtitle: {
                align: 'left',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
                // title: {
                //     text: 'จำนวนสัญญา'
                // }
            },
            yAxis: {
                title: {
                    text: 'สัญญา'
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
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
            },

            series: [{
                name: "จังหวัด",
                colorByPoint: true,
                data: [{
                        name: "เชียงใหม่",
                        y: 63,
                    },
                    {
                        name: "ลำพูน",
                        y: 19,
                    },
                    {
                        name: "ลำปาง",
                        y: 44,
                    },
                    {
                        name: "อุตรดิตถ์",
                        y: 44,
                    },
                    {
                        name: "แพร่",
                        y: 44,
                    },
                ]
            }]
        });

        Highcharts.chart('chart4', {
            chart: {
                type: 'bar'
            },
            title: {
                align: 'left',
                text: 'หลักสูตร'
            },
            subtitle: {
                align: 'left',
                text: ''
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
                    text: 'จำนวน'
                }

            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'กิจกรรม'

                ],
                crosshair: true
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
            },
            series: [{
                name: 'ซ่อมจักรยาน',
                data: [140000]

            },{
                name: 'ซ่อมฝายชะลอน้ำ',
                data: [30000]

            }]
        });
    </script>
@endpush
