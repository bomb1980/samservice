<div>
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <label class="col-md-2 form-control-label">จังหวัด <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::select('province_id', $province_sel, $province_id, [
                        // 'wire:model' => 'province_id',
                        'onchange' => 'setValue("province_id", event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'province_id',
                        'placeholder' => '--เลือกจังหวัด--',
                    ]) }}
                    @error('province_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">ประเภท <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::select('lecturer_types_id', $lecturer_types_sel, $lecturer_types_id, [
                        // 'wire:model' => 'lecturer_types_id',
                        'onchange' => 'setValue("lecturer_types_id", event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'lecturer_types_id',
                        'placeholder' => '--เลือกประเภท--',
                    ]) }}
                    @error('lecturer_types_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">บัตรประจำตัวประชาชน <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    {{ form::text('lecturer_nationalid', $lecturer_nationalid, [
                        'oninput' => 'applications_thai_format("lecturer_nationalid", event.target.value)',
                        'onchange' => 'setValue("lecturer_nationalid", event.target.value)',
                        'class' => 'form-control',
                        'maxlength' => 17,
                        'id' => 'lecturer_nationalid',
                        'autocomplete' => 'off',
                        'placeholder' => 'กรอกบัตรประชาชน',
                    ]) }}
                    @if ($lecturer_nationalid)
                        {!! $check_thai_id == false
                            ? '<small class="text-danger"><i class="icon wb-close"></i> รหัสไม่ถูกต้อง</small>'
                            : '<small class="text-success"><i class="icon wb-check"></i> รหัสถูกต้อง</small>' !!}
                    @endif
                    @error('pop_nationalid')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">ชื่อ: <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    {{ Form::text('lecturer_fname', $lecturer_fname, [
                        'wire:model' => 'lecturer_fname',
                        'id' => 'lecturer_fname',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'maxlength' => 100,
                        'placeholder' => 'กรุณากรอก ชื่อวิทยากร',
                    ]) }}
                    @error('lecturer_fname')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">นามสกุล:</label>
                <div class="col-md-7">
                    {{ Form::text('lecturer_lname', $lecturer_lname, [
                        'wire:model' => 'lecturer_lname',
                        'id' => 'lecturer_lname',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'placeholder' => 'กรุณากรอก นามสกุลวิทยากร',
                    ]) }}
                    @error('lecturer_lname')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">เบอร์โทรศัพท์:</label>
                <div class="col-md-7">
                    {{ Form::text('lecturer_phone', $lecturer_phone, [
                        'oninput' => 'phone_format("lecturer_phone", event.target.value)',
                        // 'onchange' => 'setValue("lecturer_phone", event.target.value)',
                        'wire:model' => 'lecturer_phone',
                        'maxlength' => 11,
                        'id' => 'lecturer_phone',
                        'class' => 'form-control',
                        'placeholder' => 'กรุณากรอก เบอร์โทรศัพท์',
                    ]) }}
                    @error('lecturer_phone')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">ที่อยู่:</label>
                <div class="col-md-7">
                    {{ Form::text('lecturer_address', $lecturer_address, [
                        'wire:model' => 'lecturer_address',
                        'id' => 'lecturer_address',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'placeholder' => 'กรุณากรอก ที่อยู่',
                    ]) }}
                    @error('lecturer_address')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button type="button" wire:click='submit()'class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='redirect_to()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();
            Livewire.on('emits', () => {
                $('.select2').select2();
            });
        });
    </script>
    <script>
        window.onload = function() {
            Livewire.on('popup', () => {

                swal({
                        title: "บันทึกข้อมูลเรียบร้อย",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            @this.redirect_to();
                        }
                    });
            });
        }
    </script>
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.2/imask.min.js"></script>

    <script>
        function setValue(name, value) {
            @this.set(name, value);
        }

        function applications_thai_format(id, text) {
            @this.set('check_thai_id', false);
            const input = document.getElementById(id);
            const mask = new IMask(input, {
                mask: "0-0000-00000-00-0"
            });
            let number = text.replace(/-/g, "");
            for (i = 0, sum = 0; i < 12; i++) {
                sum += parseInt(number.charAt(i)) * (13 - i);
            }
            let mod = sum % 11;
            let check = (11 - mod) % 10;
            if (check == parseInt(number.charAt(12))) {
                @this.set('check_thai_id', true);
            }
        }

        function phone_format(id, number) {
            const input = document.getElementById(id);
            const mask = new IMask(input, {
                mask: "000-0000000"
            });
        }
    </script>
@endpush
