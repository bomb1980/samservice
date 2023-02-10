<div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, null, [
            'id' => 'fiscalyear_code',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 text-right pr-4">ประเภทกิจกรรม</label>
        {!! Form::select('', ['กิจกรรมจ้างงานเร่งด่วน', 'กิจกรรมทักษะฝีมือแรงงาน'], null, [
            'id' => 'fiscalyear_code',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกประเภทกิจกรรม--',
        ]) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror

    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">รูปแบบ</label>
        {!! Form::select('', ['ภาพรวมประเทศ', 'รายภาค', 'จังหวัด'], null, [
            'id' => 'parttern',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกรูปแบบ--',
        ]) !!}
        @error('parttern')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 text-right pr-4">ภาค</label>
        {!! Form::select('', ['ภาคเหนือ', 'ภาคกลาง', 'ภาคตะวันออกเฉียงเหนือ', 'ภาคตะวันออก', 'ภาคใต้'], null, [
            'id' => 'region',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกภาค--',
        ]) !!}
        @error('region')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 text-right pr-4">จังหวัด</label>
        {!! Form::select('', ['กรุงเทพมหานคร', 'กระบี่', 'กาญจนบุรี', 'กาฬสินธุ์', 'กำแพงเพชร', 'ขอนแก่น '], null, [
            'id' => 'province',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกจังหวัด--',
        ]) !!}
        @error('province')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">คำค้น</label>
        {{-- <div class="col-md-3"> --}}
            {{ Form::text('search', null, ['class' => 'form-control col-md-3', 'id' => 'search', 'placeholder' => 'คำค้น...']) }}
        {{-- </div> --}}
        <div class="col-md-1">
            <button class="btn btn-primary" onclick="search_Click()"><i class="icon wb-search"
                    aria-hidden="true"></i>
                ค้นหา</button>
        </div>
        <div class="col-md-5">
            <button class="btn btn-primary" wire:click="showReport"><i class="icon fa-file-word-o pr-1" aria-hidden="true"></i> รายงาน Word</button>
            <button class="btn btn-primary" wire:click="exportExcel"><i class="icon fa-file-excel-o" aria-hidden="true"></i> รายงาน Excel</button>
            <a class="btn btn-primary" target="_blank" href="#"><i class="icon fa-file-pdf-o pr-1" aria-hidden="true"></i>รายงาน PDF</a>
        </div>
    </div>
    <hr>
    <table class="table table-bordered table-hover table-striped dataTable text-center" id="Datatables">
        <thead>
            <tr>
                <td>ชื่อ-นามสกุล</td>
                <td>อายุ</td>
                <td>ตำบล</td>
                <td>อำเภอ</td>
                <td>จังหวัด</td>
                <td>อาชีพ</td>
            </tr>
        </thead>
    </table>
</div>
<script>
    function button_function() {
            swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK",
                },
                function(isConfirm){
                    if (isConfirm) {
                        // window.livewire.emit('redirect-to');
                }
            });
    }
</script>
