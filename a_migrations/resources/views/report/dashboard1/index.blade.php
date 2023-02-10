@extends('layouts.app', ['activePage' => 'manage'])

@section('content')
<div class="page">
    <div class="page-header">
        <h1 class="page-title">รายงานสรุป</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="#" class="keychainify-checked">รายงาน</a></li>
            <li class="breadcrumb-item active">รายงานสรุป</li>
        </ol>
        <div class="page-header-actions">

        </div>
    </div>

    <div class="page-content container-fluid">
        <div class="panel form-group">
            @livewire('report.dashboard.filter-component')
        </div>

        @livewire('report.dashboard.installment-component')

        @livewire('report.dashboard.table-report-component')
        {{-- <div class="panel form-group">
            <div class="panel-body container-fluid">
                <table class="table table-bordered table-hover table-striped dataTable text-center" id="Datatables">
                    <thead>
                        <tr>
                            <td class="text-center">กิจกรรม</td>
                            <td class="text-center">งวด</td>
                            <td class="text-center">งบ</td>
                            <td class="text-center">เบิกจ่าย</td>
                            <td class="text-center">คงเหลือ</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>จ้างงาน</td>
                            <td class="text-center">1</td>
                            <td class="text-right">100,000</td>
                            <td class="text-right">100,000</td>
                            <td class="text-right">0</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">2</td>
                            <td class="text-right">100,000</td>
                            <td class="text-right">50,000</td>
                            <td class="text-right">50,000</td>
                        </tr>
                        <tr>
                            <td>อบรม</td>
                            <td class="text-center">1</td>
                            <td class="text-right">100,000</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">2</td>
                            <td class="text-right">100,000</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('js')
<script>
    // $("select").select2();
</script>
@endpush
