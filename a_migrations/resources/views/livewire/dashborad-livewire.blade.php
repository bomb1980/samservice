<div>
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
                                {{ Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
                                    'onchange' => 'setFilters("fiscalyear_code",event.target.value)',
                                    'id' => 'fiscalyear_code',
                                    'class' => 'form-control',
                                    'placeholder' => '--เลือกปีงบประมาณ--',
                                ]) }}
                            </div>
                            <label class="col-md-1 form-control-label">งวดที่ </label>
                            <div class="col-md-2">
                                {{ Form::select('periodno', $periodno_list, $periodno, [
                                    'wire:change' => 'changePeriod($event.target.value)',
                                    'id' => 'periodno',
                                    'class' => 'form-control',
                                    'placeholder' => '--เลือกงวด--',
                                ]) }}
                            </div>
                            <label class="col-md-1 form-control-label">ช่วงเวลา </label>
                            <div class="col-md-2">
                                <input type="text" class="form-control datepicker" data-date-language="th-th"
                                    onchange="setDatePicker('stdate', event.target.value)" placeholder="เดือนที่เริ่ม">
                            </div>
                            <label class="form-control-label">-</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control datepicker" data-date-language="th-th"
                                    onchange="setDatePicker('endate', event.target.value)"
                                    placeholder="เดือนที่สิ้นสุด">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 form-control-label">ประเภทกิจกรรม </label>
                            <div class="col-md-2">
                                {!! Form::select('acttype_id', $acttype_list, $acttype_id, [
                                    'class' => 'form-control',
                                    'id' => 'acttype_id',
                                    'onchange' => 'setFilters("acttype_id",event.target.value)',
                                    // 'wire:change' => 'changeAct($event.target.value)',
                                    'placeholder' => '--เลือกประเภทกิจกรรม--',
                                ]) !!}
                            </div>
                            <label class="col-md-1 form-control-label">ภูมิภาค </label>
                            <div class="col-md-2">
                                {!! Form::select('geo_id', $geo_list, $geo_id, [
                                    'class' => 'form-control',
                                    'id' => 'geo_id',
                                    'onchange' => 'setFilters("geo_id",event.target.value)',
                                    // 'wire:change' => 'changeGeo($event.target.value)',
                                    'placeholder' => '--เลือกภูมิภาค--',
                                ]) !!}
                            </div>
                            <label class="col-md-1 form-control-label">หน่วยงาน </label>
                            <div class="col-md-2">
                                {!! Form::select('division_id', $division_list, $division_id, [
                                    'class' => 'form-control',
                                    'id' => 'division_id',
                                    // 'wire:change' => 'changeDiv($event.target.value)',
                                    'placeholder' => '--เลือกหน่วยงาน--',
                                ]) !!}
                            </div>
                            <label class="col-md-1 form-control-label">มิติข้อมูล </label>
                            <div class="col-md-2">
                                {!! Form::select('dimension', $dimension_list, $dimension, [
                                    'class' => 'form-control',
                                    'onchange' => 'setFilters("dimension",event.target.value)',
                                    // 'wire:change' => 'changeDimension($event.target.value)',
                                    'placeholder' => '--เลือกมิติข้อมูล--',
                                ]) !!}
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <div class="col-md-5">
                                <button class="btn btn-primary" wire:click="showReport"><i
                                        class="icon fa-file-word-o pr-1" aria-hidden="true"></i> รายงาน Word</button>
                                <button class="btn btn-primary" wire:click="exportExcel"><i class="icon fa-file-excel-o"
                                        aria-hidden="true"></i> รายงาน Excel</button>
                                <a class="btn btn-primary" target="_blank"
                                    href="{{ route('report.dashboard1.pdf') }}"><i class="icon fa-file-pdf-o pr-1"
                                        aria-hidden="true"></i>รายงาน PDF</a>
                            </div>
                        </div> --}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        @if (!$dimension)
            <div class="panel form-group">
                @livewire('act-dashboard')
            </div>
            <div class="panel form-group">
                @livewire('age-period-dashboard')
            </div>
            <div class="panel form-group">
                @livewire('gender-dashboard')
            </div>
            <div class="panel form-group">
                @livewire('income-dashboard')
            </div>
            <div class="panel form-group">
                @livewire('occupation-dashboard')
            </div>
            <div class="panel form-group">
                @livewire('course-dashboard')
            </div>
        @elseif ($dimension == 1)
            <div class="panel form-group">
                @livewire('act-dashboard')
            </div>
        @elseif ($dimension == 2)
            <div class="panel form-group">
                @livewire('age-period-dashboard')
            </div>
        @elseif ($dimension == 3)
            <div class="panel form-group">
                @livewire('gender-dashboard')
            </div>
        @elseif ($dimension == 4)
            <div class="panel form-group">
                @livewire('income-dashboard')
            </div>
        @elseif ($dimension == 5)
            <div class="panel form-group">
                @livewire('occupation-dashboard')
            </div>
        @elseif ($dimension == 6)
            <div class="panel form-group">
                @livewire('course-dashboard')
            </div>
        @endif


        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            $(document).ready(function() {
                $('#division_id').select2();
                $('#division_id').on('change', function(e) {
                    var data = $('#division_id').select2("val");
                    @this.division_id = data;
                    console.log(data);
                });
            });

            document.addEventListener('livewire:load', function() {
                window.livewire.on('select2', function(data) {
                    $('#division_id').select2();
                    $("select").select2();
                });
            })
        </script>

    </div>
</div>

@push('js')
    <script>
        $("select").select2();

        function setFilters(name, val) {
            var fiscalyear_code = $('#fiscalyear_code').val();
            @this.set(name, val);
            console.log(name, val);
        }

        $(".datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            orientation: "bottom left"
        });

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
        }
    </script>
@endpush
