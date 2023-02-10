@extends('layouts.app',['activePage' => 'config'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">ตั้งค่าระบบ Api Monitor</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('config.apiMonitor.index') }}"
                        class="keychainify-checked active">Api Monitor</a></li>
            </ol>
        </div>
        <div class="page-content container-fluid">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title"><i class="icon wb-plus-circle" aria-hidden="true"></i>
                        เพิ่ม Api Monitor
                    </h3>
                </header>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            {{-- @livewire('config.branchtype-add-component') --}}
                            <div class="col-lg-12">
                                <div class="panel-body">
                                    {!! Form::open(['autocomplete' => 'off', 'class' => 'fv-form form-horizontal fv-form-bootstrap4']) !!}
                                    {{-- {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'fv-form form-horizontal fv-form-bootstrap4']) !!} --}}
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">ชื่อระบบเข้าใช้งาน: <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('branch_name', null, ['id' => 'branch_name', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'กรุณากรอก ชื่อระบบเข้าใช้งาน']) !!}
                                            @error('branch_name')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">รายละเอียด Route API: <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('branch_description', null, ['id' => 'branch_description', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'กรุณา ระบุรายละเอียด Route API']) !!}
                                            @error('branch_description')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                        <button type="reset" wire:click='thisReset()'
                                            class="btn btn-default btn-outline">ยกเลิก</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
    </script>
@endpush
