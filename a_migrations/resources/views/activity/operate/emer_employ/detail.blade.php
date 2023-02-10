@extends('layouts.app', ['activePage' => 'activity'])

@section('content')
    <style>
        .pol {
            position: relative;
            top: 10px;
        }

        .bgfl {
            position: relative;
            padding: 12px 20px;
            margin: 0;
            font-size: inherit;
            color: #a3afb7;
            vertical-align: top;
            background-color: white;
            border-radius: 5px;
            border-style: solid;
        }

        .progress-tt {
            height: 1.5rem !important;
        }

        .step.current,
        .step.active {
            color: #fff;
            background-color: #3e8ef7;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
        }


        @media (max-width: 1000px) {
            .grid-container {
                display: grid;
                grid-template-columns: auto;
            }
        }

        i.wb-plus.splus {
            color: green;
        }

        i.wb-plus.splus:hover {
            color: lime;
        }

        i.wb-trash.sdell {
            color: red;
        }

        i.wb-trash.sdell:hover {
            color: pink;
        }

        .sel1,
        .sel4 {
            width: 400px;
        }

        .sel2,
        .sel3 {
            width: 200px;
        }

        .pull-right {
            float: right;
        }
    </style>

    <div class="page">
        {{-- <div class="page-header">
        <h1 class="page-title">บันทึกผลการดำเนินงาน</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item active">บันทึกผลการดำเนินงาน</li>
        </ol>
        <div class="page-header-actions">

        </div>
    </div> --}}

        {{-- <div class="page-content container-fluid"> --}}
        @livewire('activity.operate.emer-employ.detail-component', ['act_id' => $act_id, 'p_id' => $p_id])
        {{-- </div> --}}
    </div>
@endsection

@push('js')
    <script></script>
@endpush
