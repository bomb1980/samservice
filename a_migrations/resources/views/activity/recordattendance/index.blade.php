@extends('layouts.app', ['activePage' => 'result'])

@section('content')

@livewire('activity.assessment.record-attendance-component')

@endsection

@push('js')
    <script>
        $(function() {
            @if (session('success'))
                swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                });
            @endif

            @if (session('success_del'))
                swal({
                title: "ลบข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                });
            @endif
        });
    </script>
@endpush
