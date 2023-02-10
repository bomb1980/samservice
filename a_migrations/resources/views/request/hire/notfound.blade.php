@extends('layouts.app', ['activePage' => 'request'])

@section('content')
    <style>
        .pearl.disabled::before,
        .pearl.disabled::after {
            background-color: rgb(0, 0, 0, 8%);
        }

        .dot-checkmark i:before {
            font-family: sans-serif;
            content: "✔";
            color: white;
            display: inline-block;
            width: 2em;
            background: #11c26d;
            border-radius: 50%;
        }
    </style>
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">บันทึกแบบคำขอทำโครงการ (กิจกรรมจ้างงานเร่งด่วน)</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>

                <li class="breadcrumb-item active">บันทึกข้อมูลคำขอรับการจัดสรรงบประมาณ (กิจกรรมจ้างงานเร่งด่วน)</li>
            </ol>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">

                </div>
            </div>
        </div>

        <div class="page-content container-fluid">




            <div class="row row-lg">
                <div class="col-md-12">

                    <div class="row">
                        <div class="form-group col-md-12 panel" style="padding: 25px;">


                            <h1 class="grey lighter smaller text-center">
                                <span class="blue bigger-125">
                                    <i class="ace-icon fa fa-sitemap"></i>
                                    404
                                </span>
                                Page Not Found
                            </h1>

                            <div class="center">
                                <a href="javascript:history.back()" class="btn btn-grey">
                                    <i class="ace-icon fa fa-arrow-left"></i>
                                    Go Back
                                </a>

                                <a href="#" class="btn btn-primary">
                                    <i class="ace-icon fa fa-tachometer"></i>
                                    Dashboard
                                </a>
                            </div>


                           {{-- {!!$next_time!!} --}}
                        </div>
                    </div>



                </div>
            </div>
        </div>


    </div>
@endsection
