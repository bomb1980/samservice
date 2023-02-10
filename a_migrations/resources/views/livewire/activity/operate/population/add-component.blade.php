<div>
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        {{ Form::open([
                            'wire:submit.prevent' => 'submit()',
                            'autocomplete' => 'off',
                            'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                        ]) }}
                        @if ($role == 1)
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">ประเภทวิทยากร <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    {{ Form::select('type_role', $role_list_1, $type_role, [
                                        'onchange' => 'setValue("type_role",event.target.value)',
                                        'class' => 'form-control select2',
                                        'placeholder' => '--เลือกประเภท--',
                                    ]) }}
                                    @error('type_role')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if ($role == 2)
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">สถานะการเข้าร่วม <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    {{ Form::select('type_role', $role_list_2, $type_role, [
                                        'onchange' => 'setValue("type_role",event.target.value)',
                                        'class' => 'form-control select2',
                                        'placeholder' => '--เลือกประเภท--',
                                    ]) }}
                                    @error('type_role')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">บัตรประจำตัวประชาชน <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                {{ form::text('pop_nationalid', $pop_nationalid, [
                                    'oninput' => 'applications_thai_format("pop_nationalid", event.target.value)',
                                    'onchange' => 'setValue("pop_nationalid", event.target.value)',
                                    'class' => 'form-control',
                                    'maxlength' => 17,
                                    'id' => 'pop_nationalid',
                                    'autocomplete' => 'off',
                                    'placeholder' => 'กรอกบัตรประชาชน',
                                ]) }}
                                @if ($pop_nationalid)
                                    {!! $check_thai_id == false
                                        ? '<small class="text-danger"><i class="icon wb-close"></i> รหัสไม่ถูกต้อง</small>'
                                        : '<small class="text-success"><i class="icon wb-check"></i> รหัสถูกต้อง</small>' !!}
                                @endif
                                @error('pop_nationalid')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success"
                                    {{ $check_thai_id == false ? 'disabled' : '' }}
                                    wire:click="getDataLinkgate()">ดึงข้อมูล</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">หมายเลขสวัสดิการอื่นๆ</label>
                            <div class="col-md-3">
                                {{ form::number('pop_welfarecard', $pop_welfarecard, [
                                    'wire:model' => 'pop_welfarecard',
                                    'min' => 0,
                                    'class' => 'form-control',
                                    'placeholder' => 'กรอกหมายเลขสวัสดิการอื่นๆ',
                                ]) }}
                                @error('pop_welfarecard')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">คำนำหน้า <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                {{ Form::select('pop_sname', $pop_sname_list, $pop_sname, [
                                    'onchange' => 'setValue("pop_sname", event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => 'เลือกคำนำหน้า',
                                ]) }}
                                @error('pop_sname')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">ชื่อ <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                {{ form::text('pop_firstname', $pop_firstname, [
                                    'wire:model' => 'pop_firstname',
                                    'class' => 'form-control',
                                    'placeholder' => 'ชื่อ',
                                ]) }}
                                @error('pop_firstname')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <label class="col-md-2 form-control-label">นามสกุล <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                {{ form::text('pop_lastname', $pop_lastname, [
                                    'wire:model' => 'pop_lastname',
                                    'class' => 'form-control',
                                    'placeholder' => 'นามสกุล',
                                ]) }}
                                @error('pop_lastname')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">เพศ</label>
                            <div class="col-md-3">
                                <div class="radio-custom radio-primary radio-inline">
                                    <input name="pop_gender" type="radio"
                                        onchange="setValue('pop_gender', this.value)" value="ไม่ระบุ"
                                        {{ $pop_gender == 'ไม่ระบุ' ? 'checked' : '' }} />
                                    <label for="population_gender_true">ไม่ระบุ</label>
                                </div>
                                <div class="radio-custom radio-primary radio-inline">
                                    <input name="pop_gender" type="radio"
                                        onchange="setValue('pop_gender', this.value)" value="ชาย"
                                        {{ $pop_gender == 'ชาย' ? 'checked' : '' }} />
                                    <label for="population_gender_true">ชาย</label>
                                </div>
                                <div class="radio-custom radio-primary radio-inline">
                                    <input name="pop_gender" type="radio"
                                        onchange="setValue('pop_gender', this.value)" value="หญิง"
                                        {{ $pop_gender == 'หญิง' ? 'checked' : '' }} />
                                    <label for="population_gender_false">หญิง</label>
                                </div>
                                @error('population_gender')
                                    <label class="text-danger col-md-12 row">{{ $message }}</label>
                                @enderror
                            </div>

                            <label class="col-md-2 form-control-label">วัน/เดือน/ปีเกิด <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 form-group">
                                <div class="input-group">
                                    {{ Form::text('pop_birthday', $pop_birthday, [
                                        'onchange' => 'setValue("pop_birthday", event.target.value)',
                                        'class' => 'form-control datepicker',
                                        'id' => 'pop_birthday',
                                        'autocomplete' => 'close',
                                    ]) }}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('pop_birthday')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">
                                <h5><b><u>ที่อยู่ที่ติดต่อได้สะดวก</u></b></h5>
                            </label>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">บ้านเลขที่ <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 form-group">
                                {{ form::text('pop_addressno', $pop_addressno, [
                                    'wire:model' => 'pop_addressno',
                                    'class' => 'form-control',
                                    'onkeypress' => 'return validateNumber(event)',
                                    'placeholder' => 'บ้านเลขที่',
                                ]) }}
                                @error('pop_addressno')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <label class="col-md-2 form-control-label">หมู่ที่</label>
                            <div class="col-md-3 form-group">
                                {{ form::number('pop_moo', $pop_moo, [
                                    'wire:model' => 'pop_moo',
                                    'class' => 'form-control',
                                    'min' => 0,
                                    'placeholder' => 'หมู่ที่',
                                ]) }}
                                @error('pop_moo')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">ซอย</label>
                            <div class="col-md-3 form-group">
                                {{ form::text('pop_soi', $pop_soi, [
                                    'wire:model' => 'pop_soi',
                                    'class' => 'form-control',
                                    'placeholder' => 'ซอย',
                                ]) }}
                                @error('pop_soi')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <label class="col-md-2 form-control-label">จังหวัด <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3 form-group">
                                {{ form::select('pop_province', $province_list, $pop_province, [
                                    'onchange' => 'setValue("pop_province",event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--เลือกจังหวัด--',
                                ]) }}
                                @error('pop_province')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">อำเภอ <span class="text-danger">*</span></label>
                            <div class="col-md-3 form-group">
                                {{ form::select('pop_district', $amphur_list, $pop_district, [
                                    'onchange' => 'setValue("pop_district",event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--เลือกอำเภอ--',
                                ]) }}
                                @error('pop_district')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <label class="col-md-2 form-control-label">ตำบล <span class="text-danger">*</span></label>
                            <div class="col-md-3 form-group">
                                {{ form::select('pop_subdistrict', $subdistrict_list, $pop_subdistrict, [
                                    'onchange' => 'setValue("pop_subdistrict",event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--เลือกตำบล--',
                                ]) }}
                                @error('pop_subdistrict')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">รหัสไปรษณีย์</label>
                            <div class="col-md-3 form-group">
                                {{ form::text('pop_postcode', $pop_postcode, [
                                    'wire:model' => 'pop_postcode',
                                    'class' => 'form-control',
                                    'maxlength' => 5,
                                    'placeholder' => 'รหัสไปรษณีย์',
                                ]) }}
                                @error('pop_postcode')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <label class="col-md-2 form-control-label">เบอร์โทรศัพท์</label>
                            <div class="col-md-3 form-group">
                                {{ form::text('pop_mobileno', $pop_mobileno, [
                                    'id' => 'pop_mobileno',
                                    'oninput' => 'phone_format("pop_mobileno", event.target.value)',
                                    'onchange' => 'setValue("pop_mobileno", event.target.value)',
                                    'maxlength' => 11,
                                    'class' => 'form-control',
                                ]) }}
                                @error('pop_mobileno')
                                    <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        @if ($role == 1)
                            <div class="row form-group">
                                <label class="col-md-2 form-control-label">วุฒิการศึกษา <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3 form-group">
                                    {{ form::select('pop_education', $education_list, $pop_education, [
                                        'onchange' => 'setValue("pop_education",event.target.value)',
                                        'class' => 'form-control select2',
                                        'placeholder' => '--เลือกวุฒิการศึกษา--',
                                    ]) }}
                                    @error('pop_education')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @if ($role == 2)
                            <div class="row form-group">
                                <label class="col-md-2 form-control-label">กลุ่มอาชีพหลัก <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3 form-group">
                                    {{ form::select('pop_ocuupation', $ocuupation_list, $pop_ocuupation, [
                                        'onchange' => 'setValue("pop_ocuupation",event.target.value)',
                                        'class' => 'form-control select2',
                                        'placeholder' => '--เลือกกลุ่มอาชีพหลัก--',
                                    ]) }}
                                    @error('pop_ocuupation')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <label class="col-md-2 form-control-label">รายได้ต่อเดือน <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3 form-group">
                                    {{ form::number('pop_income', $pop_income, [
                                        'wire:model' => 'pop_income',
                                        'id' => 'pop_income',
                                        'placeholder' => '--รายได้ต่อเดือน--',
                                        'class' => 'form-control',
                                        'min' => 0,
                                    ]) }}
                                    @error('pop_income')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">ท่านเป็นผู้พิการใช่หรือไม่ <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="defective" type="radio"
                                            onchange="setValue('defective', this.value)" value="1"
                                            {{ $defective == '1' ? 'checked' : '' }} />
                                        <label for="population_gender_true">ใช่</label>
                                    </div>
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="defective" type="radio"
                                            onchange="setValue('defective', this.value)" value="2"
                                            {{ $defective == '2' ? 'checked' : '' }} />
                                        <label for="population_gender_false">ไม่ใช่</label>
                                    </div>
                                    @error('defective')
                                        <label class="text-danger col-md-12 row">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">ท่านเป็นแรงงานนอกระบบใช่หรือไม่ <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="labor" type="radio" onchange="setValue('labor', this.value)"
                                            value="1" {{ $labor == '1' ? 'checked' : '' }} />
                                        <label for="population_gender_true">ใช่</label>
                                    </div>
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="labor" type="radio" onchange="setValue('labor', this.value)"
                                            value="2" {{ $labor == '2' ? 'checked' : '' }} />
                                        <label for="population_gender_false">ไม่ใช่</label>
                                    </div>
                                    @error('labor')
                                        <label class="text-danger col-md-12 row">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label">ท่านเป็นผู้สูงอายุหรือไม่</label>
                                <div class="col-md-3">
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="elderly" type="radio"
                                            onchange="setValue('elderly', this.value)" value="1"
                                            {{ $elderly == '1' ? 'checked' : '' }} disabled />
                                        <label for="population_gender_true">ใช่</label>
                                    </div>
                                    <div class="radio-custom radio-primary radio-inline">
                                        <input name="elderly" type="radio"
                                            onchange="setValue('elderly', this.value)" value="2"
                                            {{ $elderly == '2' ? 'checked' : '' }} disabled />
                                        <label for="population_gender_false">ไม่ใช่</label>
                                    </div>
                                    @error('elderly')
                                        <label class="text-danger col-md-12 row">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group text-center">
            <button type="button" class="w-full form-group btn btn-danger col-2"
            onclick="callBack()">ยกเลิก</button>
            &nbsp;
            &nbsp;
            <button type="submit" class="w-full form-group btn btn-success col-2">บันทึกข้อมูล</button>
        </div>
        {{ Form::close() }}

    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();

            $("#pop_birthday").datepicker({
                language: 'th-th',
                format: 'dd/mm/yyyy',
                endDate: '-20y',
                autoclose: true
            });

            Livewire.on('emits', () => {
                $('.select2').select2();
            });
        });
    </script>
</div>

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.2/imask.min.js"></script>

    <script>
        function getDataFromLinkagte(pop_nationalid) {
            @this.getDataLinkagte(pop_nationalid);
        }

        window.onload = function() {
            Livewire.on('popup', (num) => {
                if (num == 1) {
                    swal({
                            title: "บันทึกเสร็จสิ้น",
                            type: "success",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ตกลง",
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                // window.livewire.emit('redirect-to');
                                window.close();
                            }
                        });
                } else if (num == 2) {
                    swal({
                            title: "ไม่พบข้อมูล",
                            type: "warning",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ตกลง",
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                // window.livewire.emit('redirect-to');
                            }
                        });
                }
            });
        }

        function callBack() {
            swal({
                title: 'ต้องการยกเลิกการบันทึกใช่หรือไม่',
                icon: 'close',
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#00BCD4',
                cancelButtonText: 'ยกเลิก',
                cancelButtonColor: '#00BCD4',
            }, function(isConfirm) {
                if (isConfirm) {
                    window.close();
                } else {
                    console.log('reject');
                }
            });
        }

        function validateNumber(thestr) {
            const pattern = /^[0-9/]$/;
            return pattern.test(thestr.key)
        }

        function setValue(name, val) {
            @this.set(name, val);
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
