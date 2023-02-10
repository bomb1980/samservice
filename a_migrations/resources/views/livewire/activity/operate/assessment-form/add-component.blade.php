<div>
    <div class="page-header">
        <h1 class="page-title text-center">แบบประเมินความพึงพอใจ</h1>
    </div>

    <div class="page-content container-fluid">
        <div class="panel_">
            <div class="panel-body container-fluid">
                <br>
                {{ Form::open([
                    'wire:submit.prevent' => 'submit()',
                    'autocomplete' => 'off',
                    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                ]) }}

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">บัตรประจำตัวประชาชน</label>
                    <div class="col-md-3">
                        {{ form::text('pop_nationalid', $pop_nationalid, [
                            'oninput' => 'applications_thai_format("pop_nationalid", event.target.value)',
                            'onchange' => 'setValue("pop_nationalid", event.target.value)',
                            'class' => 'form-control',
                            'maxlength' => 17,
                            'id' => 'pop_nationalid',
                            'autocomplete' => 'off',
                            'placeholder' => 'กรอกบัตรประชาชน',
                            'disabled' => $check_edit,
                        ]) }}
                        @if ($check_edit == false)
                            @if ($pop_nationalid)
                                @if ($check_thai_id)
                                    @if ($alert_nopop)
                                        <small class="text-success"><i class="icon wb-check"></i>
                                            รหัสถูกต้อง</small>
                                    @else
                                        <small class="text-warning"><i class="icon wb-alert"></i>
                                            ไม่พบรายชื่อผู้ร่วมกิจกรรม</small>
                                    @endif
                                @else
                                    <small class="text-danger"><i class="icon wb-close"></i>
                                        รหัสไม่ถูกต้อง</small>
                                @endif
                            @endif
                        @endif
                        @error('pop_nationalid')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

                @if ($check_qrcode)
                    <div class="row form-group">
                        <label class="col-md-2 form-control-label">สถานะการเข้าร่วม </label>
                        <div class="col-md-3">
                            {{ Form::select('pop_status', $pop_role_list, $pop_status, [
                                'onchange' => 'setValue("pop_status", event.target.value)',
                                'class' => 'form-control select2',
                                'placeholder' => 'สถานะการเข้าร่วม',
                                'disabled',
                            ]) }}
                        </div>
                    </div>
                    @if ($pop_role != 1)
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">คำนำหน้า </label>
                            <div class="col-md-3">
                                {{ Form::select('pop_sname', $pop_sname_list, $pop_sname, [
                                    'onchange' => 'setValue("pop_sname", event.target.value)',
                                    'class' => 'form-control select2',
                                    'placeholder' => 'เลือกคำนำหน้า',
                                    'disabled',
                                ]) }}
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">ชื่อ</label>
                        <div class="col-md-3">
                            {{ form::text('pop_firstname', $pop_firstname, [
                                'wire:model' => 'pop_firstname',
                                'class' => 'form-control',
                                'placeholder' => 'ชื่อ',
                                'disabled',
                            ]) }}
                            @error('pop_firstname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label class="col-md-2 form-control-label">นามสกุล</label>
                        <div class="col-md-3">
                            {{ form::text('pop_lastname', $pop_lastname, [
                                'wire:model' => 'pop_lastname',
                                'class' => 'form-control',
                                'placeholder' => 'นามสกุล',
                                'disabled',
                            ]) }}
                            @error('pop_lastname')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">ประเภทกิจกรรม</label>
                        <div class="col-md-3">
                            {{ form::text('type_form', $type_form, [
                                'wire:model' => 'type_form',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">ประเภทแบบประเมิน</label>
                        <div class="col-md-3">
                            {{ form::text('topic_form', $topic_form, [
                                'wire:model' => 'topic_form',
                                'class' => 'form-control',
                                'disabled',
                            ]) }}
                        </div>
                    </div>

                    <div class="overflow row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <table
                                class="table table-bodered text-center border @error('child_array') border-danger @enderror my-table"
                                style="table-layout: fixed; overflow-wrap: break-word;">
                                <thead>
                                    <tr style="background: rgba(208, 213, 221, 0.1);">
                                        <th class="th50" style="">ประเด็นความเห็น</th>
                                        <th>มากที่สุด</th>
                                        <th>มาก</th>
                                        <th>ปานกลาง</th>
                                        <th>น้อย</th>
                                        <th>น้อยที่สุด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($type_R as $key => $value)
                                        <tr>
                                            <td style="text-align: left">
                                                <div style="margin-top: 1%">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $key + 1 }}.
                                                    {{ $value }}</div>
                                            </td>
                                            <td>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input name="status{{ $key }}"
                                                        id='status_5_key_{{ $key }}' type="radio"
                                                        value="5"
                                                        onclick='setRadio({{ $key }}, event.target.value)' />
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input name="status{{ $key }}"
                                                        id='status_4_key_{{ $key }}' type="radio"
                                                        value="4"
                                                        onclick='setRadio({{ $key }}, event.target.value)' />
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input name="status{{ $key }}"
                                                        id='status_3_key_{{ $key }}' type="radio"
                                                        value="3"
                                                        onclick='setRadio({{ $key }}, event.target.value)' />
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input name="status{{ $key }}"
                                                        id='status_2_key_{{ $key }}' type="radio"
                                                        value="2"
                                                        onclick='setRadio({{ $key }}, event.target.value)' />
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input name="status{{ $key }}"
                                                        id='status_1_key_{{ $key }}' type="radio"
                                                        value="1"
                                                        onclick='setRadio({{ $key }}, event.target.value)' />
                                                    <label></label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    @foreach ($type_O as $key => $val)
                                        <br>
                                        <div style="margin: 0;">
                                            <label>{{ $val }} </label>
                                            <div style="">
                                                {{ Form::textarea('type_O_ans' . $key . 'n', $type_O_ans[$key], ['onchange' => 'setTextArea(' . $key . ', event.target.value)', 'id' => 'type_O_ans' . $key . '', 'class' => 'form-control', 'placeholder' => 'กรอกรายละเอียดของงาน', 'rows' => '5', 'cols' => '50']) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            @if ($empty)
                                @if (auth()->user()->emp_type == 2)
                                    <button type="submit"
                                        class="w-full form-group btn btn-success col-sm-2">บันทึกข้อมูล</button>
                                @endif
                            @endif

                            <button type="button" class="w-full form-group btn btn-danger col-sm-2"
                                wire:click="callBack()">ยกเลิก</button>
                            &nbsp;
                        </div>
                    </div>
                @endif
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();

            Livewire.on('emits', async () => {
                $('.select2').select2();
            });
        });
    </script>

    <script>
        window.onload = function() {
            Livewire.on('popup', (num) => {
                if (num == 3) {
                    swal({
                            title: "กรุณากรอกแบบสอบถามให้ครบ",
                            type: "warning",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ตกลง",
                        },
                        function(isConfirm) {

                        });
                } else {
                    swal({
                            title: "บันทึกข้อมูลเรียบร้อย",
                            type: "success",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ตกลง",
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                if (num == 1) {
                                    window.livewire.emit('redirect-to');
                                }
                            }
                        });
                }
            });

            Livewire.on('callback', () => {
                    swal({
                    title: 'ต้องการออกจากแบบสอบถามใช่หรือไม่',
                    icon: 'close',
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
            });
        }

        $(document).ready(async function() {
            function checkedRatio(val, index) {
                $("#status_" + val + "_key_" + index).prop("checked", true);
            }
            if (@this.edit_flag_R == true) {
                var res = await @this.get_AccessLog_score();
                res.forEach(checkedRatio);
            }
        });

        function setValue(name, val) {

            @this.set(name, val);
        }

        function debugVariable() {

            @this.debugVariable();
        }

        function setRadio(key, val) {

            console.log("onclick radio" + key + val);
            @this.setTypeR_ans(key, val);
        }

        function setTextArea(key, val) {

            @this.setTypeO_ans(key, val);
        }

        function submit() {
            alert("submit");
        }

        // document.addEventListener('livewire:load', function() { // page on ready
        // });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.2/imask.min.js"></script>

    <script>
        async function applications_thai_format(id, text) {
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
                @this.set('pop_nationalid', text);
            }

            function checkedRatio(val, index) {
                $("#status_" + val + "_key_" + index).prop("checked", true);
            }
            if (@this.edit_flag_R == true) {
                var res = await @this.get_AccessLog_score();
                res.forEach(checkedRatio);
            } else {
                var res = await @this.get_AccessLog_score_0();
                res.forEach(checkedRatio);
            }

        }
    </script>

</div>
