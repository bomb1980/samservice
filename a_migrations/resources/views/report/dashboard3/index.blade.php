@extends('layouts.app', ['activePage' => 'master'])

@section('content')

    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Dashborad</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
                {{-- <li class="breadcrumb-item"><a href="#" class="keychainify-checked">รายงาน</a></li> --}}
                <li class="breadcrumb-item active">Dashborad</li>
            </ol>
            <div class="page-header-actions">

            </div>
        </div>

        @livewire('dashborad-livewire')


    </div>
@endsection
