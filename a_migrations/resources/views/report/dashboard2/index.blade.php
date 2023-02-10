@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">รายงานรูปภาพกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#" class="keychainify-checked">รายงาน</a></li>
                <li class="breadcrumb-item active">รายงานรูปภาพกิจกรรม</li>
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
                                        <option value="">กิจกรรมจ้างงานเร่งด่วน</option>
                                        <option value="">กิจกรรมทักษะฝีมือแรงงาน</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">หลักสูตร </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกหลักสูตร</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">ภูมิภาค </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกหลักสูตร</option>
                                    </select>
                                </div>
                                <label class="col-md-1 form-control-label">หน่วยงาน </label>
                                <div class="col-md-2">
                                    <select name="" class="form-control" id="">
                                        <option value="">เลือกหน่วยงาน</option>
                                    </select>
                                </div>
                                {{-- <label class="col-md-1 form-control-label">โครงการ </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary">Word</button>
                                    <button type="button" class="btn btn-danger">PDF</button>
                                </div> --}}
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
                        <div class="col-md-12 text-center">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="col-2"></th>
                                        <th class="col-1">จำนวนผู้เข้าร่วมกิจกรรม</th>
                                        <th class="col-1">ระยะเวลาดำเนินการ</th>
                                        <th class="col-1">งบประมาณ</th>
                                        <th class="col-1">ช่วงเวลา</th>
                                        <th class="col">รูปภาพ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left"><b>จังหวัดเลย</b></td>
                                        <td>100</td>
                                        <td>13</td>
                                        <td>100,000</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><font class = "ml-2"><b>กิจกรรมจ้างงานเร่งด่วน</b></font></td>
                                        <td>30</td>
                                        <td>8</td>
                                        <td>30,000</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" rowspan="3"><font class = "ml-4"><b>ซ่อมฝาย</b></font></td>
                                        <td rowspan="3">10</td>
                                        <td rowspan="3">3</td>
                                        <td rowspan="3">10,000</td>
                                        <td>ก่อนกิจกรรม</td>
                                        <td class="text-left">
                                            <img src="{{ asset('assets/images/seminar1.jpg') }}" style="height: 200px;" alt="">
                                            <img src="{{ asset('assets/images/seminar1.jpg') }}" style="height: 200px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- <td></td> --}}
                                        {{-- <td></td>
                                        <td></td>
                                        <td></td> --}}
                                        <td>ระหว่าง</td>
                                        <td class="text-left">
                                            <img src="{{ asset('assets/images/seminar1.jpg') }}" style="height: 200px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- <td></td> --}}
                                        {{-- <td></td>
                                        <td></td>
                                        <td></td> --}}
                                        <td>หลัง</td>
                                        <td class="text-left">
                                            <img src="{{ asset('assets/images/seminar1.jpg') }}" style="height: 200px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><font class = "ml-2"><b>กิจกรรมฝึกทักษะฝีมือแรงงาน</b></font></td>
                                        <td>70</td>
                                        <td>5</td>
                                        <td>70,000</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><font class = "ml-4"><b>ซ่อมจักรยาน</b></font></td>
                                        <td>50</td>
                                        <td>2</td>
                                        <td>30,000</td>
                                        <td></td>
                                        <td class="text-left"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><font class = "ml-4"><b>ซ่อมแอร์</b></font></td>
                                        <td>50</td>
                                        <td>2</td>
                                        <td>30,000</td>
                                        <td></td>
                                        <td class="text-left"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'ช่วงอายุ'
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
                name: "ช่วงอายุ",
                colorByPoint: true,
                data: [{
                        name: "18-25",
                        y: 63,
                    },
                    {
                        name: "26-40",
                        y: 19,
                    },
                    {
                        name: "40-60",
                        y: 4,
                    }
                ]
            }]
        });
    </script>
@endpush
