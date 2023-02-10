<div>
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
                            'wire:change' => 'changeYear($event.target.value)',
                            'id' => 'fiscalyear_code',
                            'class' => 'form-control',
                            'placeholder' => '--เลือกปีงบประมาณ--',
                        ]) }}
                    </div>
                    {{-- <label class="col-md-1 form-control-label">ประเภทกิจกรรม </label>
                    <div class="col-md-2">
                        <select name="" class="form-control" id="">
                            <option value="">เลือกประเภทกิจกรรม</option>
                            <option value="">กิจกรรมจ้างงานเร่งด่วน</option>
                            <option value="">กิจกรรมทักษะฝีมือแรงงาน</option>
                        </select>
                    </div> --}}
                    <label class="col-md-1 form-control-label">ช่วงเวลา </label>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('stdate', event.target.value)" placeholder="เดือนที่เริ่ม">
                    </div>
                    <label class="form-control-label">-</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control datepicker" data-date-language="th-th"
                            onchange="setDatePicker('endate', event.target.value)" placeholder="เดือนที่สิ้นสุด">
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label class="col-md-1 form-control-label">รูปแบบ </label>
                    <div class="col-md-2">
                        <select name="" class="form-control" id="">
                            <option value="">เลือกรูปแบบ</option>
                            <option value="">ภาพรวมประเทศ</option>
                            <option value="">รายภาค</option>
                            <option value="">จังหวัด</option>
                        </select>
                    </div>
                    <label class="col-md-1 form-control-label">ภาค </label>
                    <div class="col-md-2">
                        <select name="" class="form-control" id="">
                            <option value="">เลือกภาค</option>
                            <option value="">เหนือ</option>
                            <option value="">กลาง</option>
                            <option value="">ตะวันออก</option>
                            <option value="">ตะวันออกเฉียงเหนือ</option>
                            <option value="">ใต้</option>
                        </select>
                    </div>
                    <label class="col-md-1 form-control-label">จังหวัด </label>
                    <div class="col-md-2">
                        <select name="" class="form-control" id="">
                            <option value="">เลือกจังหวัด</option>
                            <option value="">กรุงเทพมหานคร</option>
                            <option value="">กระบี่</option>
                            <option value="">กาญจนบุรี</option>
                            <option value="">กาฬสินธุ์</option>
                        </select>
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label class="col-md-1 form-control-label">คำค้น </label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" value="" />
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-primary" wire:click="showReport"><i class="icon fa-file-word-o pr-1"
                                aria-hidden="true"></i> รายงาน Word</button>
                        <button class="btn btn-primary" wire:click="exportExcel"><i class="icon fa-file-excel-o"
                                aria-hidden="true"></i> รายงาน Excel</button>
                        <a class="btn btn-primary" target="_blank" href="#"><i class="icon fa-file-pdf-o pr-1"
                                aria-hidden="true"></i>รายงาน PDF</a>
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-md-5">
                        <button class="btn btn-primary" wire:click="showReport"><i
                                class="icon fa-file-word-o pr-1" aria-hidden="true"></i> รายงาน Word</button>
                        <button class="btn btn-primary" wire:click="exportExcel"><i class="icon fa-file-excel-o"
                                aria-hidden="true"></i> รายงาน Excel</button>
                        <a class="btn btn-primary" target="_blank"
                            href="{{ route('report.dashboard1.pdf') }}"><i class="icon fa-file-pdf-o pr-1"
                                aria-hidden="true"></i>รายงาน PDF</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // $("select").select2();

        $(".datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true,
            orientation: "bottom left"
        });

        function setDatePicker(name, val) {
            @this.set(name, val);
            @this.setArray();
        }
    </script>
@endpush
