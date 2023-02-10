@extends('layouts.app', ['activePage' => 'operate'])

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">เพิ่มข้อมูลผู้เข้าร่วมกิจกรรม</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                <li class="breadcrumb-item active">บริหารกิจกรรม</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>
        @livewire('activity.operate.population.add-component', ['act_id' => $act_id, 'act_number' => $act_number, 'role' => $role])
    </div>
@endsection

@push('js')

@endpush
