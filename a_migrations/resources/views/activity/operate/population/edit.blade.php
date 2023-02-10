@extends('layouts.app', ['activePage' => 'operate'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">แก้ไขข้อมูลผู้เข้าร่วมกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บันทึกผลการดำเนินงาน</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>
        @livewire('activity.operate.population.edit-component', ['act_id' => $act_id, 'pop_id' => $pop_id])
    </div>
@endsection

@push('js')

@endpush
