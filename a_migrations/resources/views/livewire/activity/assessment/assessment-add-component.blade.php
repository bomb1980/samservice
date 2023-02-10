<div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">เพศ</label>
        <input type="text" class="form-control  col-md-3" id="">
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">อายุ</label>
        {!! Form::select('', ['18-25', '26-35', '36-45'], null, [
            'id' => '',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกอายุ--',
        ]) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">สถานะ</label>
        {!! Form::select('', ['ลูกจ้าง', 'ว่างงาน', 'อื่นๆ'], null, [
            'id' => '',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกสถานะ--',
        ]) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ที่อยู่</label>
        <label class="form-control-label col-md-1 text-right pr-4">หมู่</label>
        {!! Form::text('', null, ['class' => 'form-control col-md-2']) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4"></label>
        <label class="form-control-label col-md-1 text-right pr-4">ตำบล</label>
        {!! Form::text('', null, ['class' => 'form-control col-md-2']) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4"></label>
        <label class="form-control-label col-md-1 text-right pr-4">อำเภอ</label>
        {!! Form::text('', null, ['class' => 'form-control col-md-2']) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4"></label>
        <label class="form-control-label col-md-1 text-right pr-4">จังหวัด</label>
        {!! Form::text('', null, ['class' => 'form-control col-md-2']) !!}
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4"></label>
        <table class="table table-bordered table-hover table-striped dataTable col-md-5 text-center" id="Datatables">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th>คะแนน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>รายการที่ 1</td>
                    <td>{!! Form::select('', [1, 2, 3, 4, 5], null, [
                        'id' => '',
                        'onchange' => 'setSearch',
                        'class' => 'form-control',
                        'placeholder' => '--เลือกคะแนน--',
                    ]) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group text-center">
        <button class="btn btn-primary">บันทึก</button>
        {{-- onclick="button_function()" --}}
        <button class="btn btn-danger">ย้อนกลับ</button>
    </div>
</div>

<script>
    function button_function() {
        swal({
                title: "บันทึกข้อมูลเรียบร้อย",
                type: "success",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
            },
            function(isConfirm) {
                if (isConfirm) {
                    // window.livewire.emit('redirect-to');
                }
            });
    }
</script>
