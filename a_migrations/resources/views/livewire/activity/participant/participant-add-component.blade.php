<div>
    <div class="row form-group">
        {{ Form::label('identification_id', 'บัตรประชาชน', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
        {{ Form::text('identification_id', $identification_id, ['wire:model' => 'identification_id', 'class' => 'form-control  col-md-3']) }}
        {{ Form::button('เชื่อมโยงแรงงานนอกระบบ', ['wire:click' => 'getnlic()', 'type' => 'button', 'class' => 'btn btn-primary mx-1 col-md-1']) }}
        {{ Form::button('เชื่อมโยงกรมการปกครอง', ['type' => 'button', 'class' => 'btn btn-primary mx-1 col-md-1', 'disabled']) }}
    </div>
    @error('identification_id')
        <div class="row form-group">

            {{ Form::label('identification_id', $message, ['class' => ' col-md-3 pr-4 offset-3 form-control-label py-0 text-danger']) }}
        </div>
    @enderror
    @if ($customer_fname)
        {{-- {!! Form::open([
            'wire:submit.prevent' => 'submit()',
            'autocomplete' => 'off',
            // 'class' => 'fv-form form-horizontal fv-form-bootstrap4',
        ]) !!} --}}
        <div class="row form-group">
            {{ Form::label('customer_fname', 'ชื่อ', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('customer_fname', $customer_fname, ['wire:model' => 'customer_fname', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('customer_lname', 'นามสกุล', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('customer_lname', $customer_lname, ['wire:model' => 'customer_lname', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('sex', 'เพศ', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('sex', $sex, ['wire:model' => 'sex', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('dateofbirth', 'วันเกิด', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('dateofbirth', $dateofbirth, ['wire:model' => 'dateofbirth', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('status_id', 'สถานะ', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('status_id', $status_id, ['wire:model' => 'status_id', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>

        <div class="row form-group">
            {{ Form::label('address_number', 'ที่อยู่', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('address_number', $address_number, ['wire:model' => 'address_number', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('address_moo', 'หมู่', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('address_moo', $address_moo, ['wire:model' => 'address_moo', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('address_tumbol', 'ตำบล', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('address_tumbol', $address_tumbol, ['wire:model' => 'address_tumbol', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('address_amphur', 'อำเภอ', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('address_amphur', $address_amphur, ['wire:model' => 'address_amphur', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('address_province', 'จังหวัด', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('address_province', $address_province, ['wire:model' => 'address_province', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('mobile', 'เบอร์โทร', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('mobile', $mobile, ['wire:model' => 'mobile', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        <div class="row form-group">
            {{ Form::label('occupation_text', 'อาชีพ', ['class' => 'form-control-label col-md-3 text-right pr-4']) }}
            {{ Form::text('occupation_text', $occupation_text, ['wire:model' => 'occupation_text', 'class' => 'form-control  col-md-3', 'disabled']) }}
        </div>
        {{-- <div class="row form-group">
        <label class="form-control-label col-md-3 text-right pr-4">สถานะ</label>
        {!! Form::select('', ['ลูกจ้าง', 'ว่างงาน', 'อื่นๆ'], null, [
            'id' => '',
            'onchange' => 'setSearch',
            'class' => 'form-control col-md-2',
            'placeholder' => '--เลือกสถานะ--',
        ]) !!}
    </div> --}}
        <div class="form-group text-center">
            <button type="submit" onclick="from_submit()" class="btn btn-primary">บันทึกข้อมูล</button>
            <button type="button" wire:click='callBack()' class="btn btn-danger">ยกเลิก</button>
        </div>

        {{-- {!! Form::close() !!} --}}
    @endif
</div>

@push('js')
    <script>
        function from_submit() {
            swal({
                    title: 'ยืนยันการ เพิ่มข้อมูลงวดเงิน',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-primary',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonClass: 'btn-danger',
                    cancelButtonText: 'ยกเลิก'
                },
                function(isConfirm) {
                    if (isConfirm) {
                        @this.submit();
                    }
                });
        }
    </script>
@endpush
