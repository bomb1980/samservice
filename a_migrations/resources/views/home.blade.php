@extends('layouts.app', ['activePage' => ''])

@section('content')
    {{-- @livewire('counter')
<livewire:counter /> --}}
    <!-- Page -->
    <div class="page">
        <div class="page-content container-fluid">
            <div class="row" data-plugin="matchHeight" data-by-row="true">
                {{ getRole() }}
            </div>
        </div>
    </div>
    <!-- End Edit Dialog -->
@endsection
