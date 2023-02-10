<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {{ Form::open([
                'wire:submit.prevent' => 'submit()',
                'autocomplete' => 'off',
                'class' => 'form-horizontal fv-form fv-form-bootstrap4',
            ]) }}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทกิจกรรม </label>
                {{-- <span class="text-danger">*</span> --}}
                <div class="col-md-6">
                    {{ Form::select('acttype_id', $acttype_list, $acttype_id, [
                        'onchange' => 'setValue("acttype_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'acttype_id',
                        'placeholder' => 'กรุณาเลือกประเภทกิจกรรม',
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('acttype_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::select('coursegroup_id', $coursegroup_list, $coursegroup_id, [
                        'onchange' => 'setValue("coursegroup_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'coursegroup_id',
                        'placeholder' => 'กรุณาเลือกกลุ่มหลักสูตร',
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('coursegroup_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">กลุ่มสาขาอาชีพ </label>
                <div class="col-md-6">
                    {{ Form::select('coursesubgroup_id', $coursesubgroup_list, $coursesubgroup_id, [
                        'onchange' => 'setValue("coursesubgroup_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'coursesubgroup_id',
                        'placeholder' => 'ไม่ระบุ',
                        'disabled' => $formdisabled,
                    ]) }}
                    {{-- @error('coursesubgroup_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror --}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทหลักสูตร </label>
                <div class="col-md-6">
                    {{ Form::select('coursetype_id', $coursetype_list, $coursetype_id, [
                        'onchange' => 'setValue("coursetype_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'coursetype_id',
                        'placeholder' => 'ไม่ระบุ',
                        'disabled' => $formdisabled,
                    ]) }}
                    {{-- @error('coursetype_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror --}}
                </div>
            </div>
            <div class="form-group row {{ (!empty($datas)) ? '' : 'd-none' }}">
                <label class="col-md-3 form-control-label">รหัสหลักสูตรอบรม </label>
                <div class="col-md-2">
                    {{ Form::text('code', null, [
                        'wire:model' => 'code',
                        'id' => 'code',
                        'class' => 'form-control',
                        'maxlength' => 20,
                        'readonly' => 'true',
                    ]) }}
                    @error('code')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อหลักสูตรอบรม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('name', null, [
                        'wire:model' => 'name',
                        'id' => 'name',
                        'class' => 'form-control',
                        'maxlength' => 1000,
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อย่อ <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('shortname', null, [
                        'wire:model' => 'shortname',
                        'id' => 'shortname',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('shortname')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียด <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::textarea('descp', null, [
                        'wire:model' => 'descp',
                        'id' => 'descp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('descp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">แหล่งที่มาของหลักสูตร <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::select('ownertype_id', $ownertype_list, $ownertype_id, [
                        'onchange' => 'setValue("ownertype_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'ownertype_id',
                        'placeholder' => 'กรุณาเลือกแหล่งที่มาของหลักสูตร',
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('ownertype_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">รายละเอียดแหล่งที่มาหลักสูตร <span
                        class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::textarea('ownerdescp', null, [
                        'wire:model' => 'ownerdescp',
                        'id' => 'ownerdescp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('ownerdescp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">หน่วยงาน เจ้าของหลักสูตร <span
                        class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::select('dept_id', $dept_list, $dept_id, [
                        'onchange' => 'setValue("dept_id",event.target.value)',
                        'class' => 'form-control select2',
                        'id' => 'dept_id',
                        'placeholder' => 'กรุณาเลือกหน่วยงาน',
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('dept_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ระยะเวลาการฝึก (จำนวนชั่วโมง) <span
                        class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::number('hour_descp', null, [
                        'wire:model' => 'hour_descp',
                        'id' => 'hour_descp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'min' => 0,
                        'oninput' => "this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null",
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('hour_descp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนวัน <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::number('day_descp', null, [
                        'wire:model' => 'day_descp',
                        'id' => 'day_descp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'min' => 0,
                        'oninput' => "this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null",
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('day_descp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนกลุ่มเป้าหมาย (คน) <span
                        class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::number('people_descp', null, [
                        'wire:model' => 'people_descp',
                        'id' => 'people_descp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'min' => 0,
                        'oninput' => "this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null",
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('people_descp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">จำนวนวิทยากร <span class="text-danger">*</span></label>
                <div class="col-md-2">
                    {{ Form::number('trainer_descp', null, [
                        'wire:model' => 'trainer_descp',
                        'id' => 'trainer_descp',
                        'class' => 'form-control',
                        'maxlength' => 200,
                        'min' => 0,
                        'oninput' => "this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null",
                        'disabled' => $formdisabled,
                    ]) }}
                    @error('trainer_descp')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <!-- Panel Form Elements -->
            <div class="form-group row">
                <label class="col-md-3 form-control-label">แนบไฟล์ </label>
                <div class="col-md-6">
                    <div class="row">
                        <div class="input-group col-md-9 input-group-file" data-plugin="inputGroupFile">
                            <input type="text" class="form-control" readonly="">
                            <button class="btn bg-blue-grey-300 btn-file" {{ $button_status }}>
                                <i class="icon wb-file" aria-hidden="true"></i>
                                เลือกไฟล์
                                <input type="file" wire:model="files" accept=".xlsx,.xls, .doc,.docx, .ppt,.pptx, .txt, .pdf,.mp4,image/*">
                            </button>
                            <br>

                            @error('files')
                                <small class="text-danger col-md-12">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col-md-1">
                            {{-- <button type="button" class="btn btn-success offset-md-1" wire:click="submit_file_array" {{ $files == null ? 'disabled' : '' }}>
                                <i class="icon wb-upload" aria-hidden="true"></i> อัพโหลดไฟล์
                            </button> --}}
                            <button type="button" class="btn btn-success offset-md-1" wire:click="submit_file_array"
                                {{ $files == null ? 'disabled' : '' }}>
                                <i class="icon wb-upload" aria-hidden="true"></i> อัพโหลดไฟล์
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <small class="col-md-12 text-danger">รองรับไฟล์ image, doc, excel และ pdf ขนาดไฟล์ไม่เกิน 20
                            MB/ไฟล์</small>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อไฟล์</th>
                                <th>ประเภทไฟล์</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($file_array_old as $key => $val)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-left"><a
                                            href="{{ url('/storage' . $val['files_path'] . '/' . $val['files_gen']) }}"
                                            title="คลิกเพื่อดาวน์โหลด" download>{{ $val['files_ori'] }}</a></td>
                                    <td>{!! showMimeIcon($val['files_type']) !!}</td>
                                    <td><button type="button" class="btn btn-pure btn-danger"
                                            onclick="destroy_old_array({{ $key }})"><i
                                                class="icon wb-trash"></i></button></td>
                                </tr>
                            @endforeach
                            @foreach ($file_array as $key => $val)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-left">{{ $val->getClientOriginalName() }}</td>
                                    <td>{!! showMimeIcon($val->getMimeType()) !!}</td>
                                    <td><button type="button" class="btn btn-pure btn-danger"
                                            onclick="destroy_array({{ $key }})"><i
                                                class="icon wb-trash"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Panel Form Elements -->
            <div class="form-group row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" onclick="submit_click()" class="btn btn-primary" {{ $button_status }}>บันทึกข้อมูล</button>
                    <button type="button" wire:click="redirectToMain()" class="btn btn-default btn-outline">ยกเลิก</button>
                </div>
            </div>
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('duplicate_file', function() {
                swal('', 'ชื่อไฟล์นี้มีอยู่แล้ว', 'error');
            });

            window.livewire.on('save_success', function() {
                swal({
                        title: '',
                        text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        type: 'success',
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'OK',
                    },
                    function() {
                        @this.redirectToMain();
                    });
            });
        });

        $('.select2').select2();

        function setValue(name, val) {
            @this.set(name, val);
        }

        Livewire.on('emits', () => {
            $('.select2').select2();
        });

        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.livewire.emit('redirectToMain');
                    }
                });
        });


        function submit_click() {
            swal({
                title: 'ยืนยันการ แก้ไข ข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit();
                }
            });
        }

        function destroy_array(key) {
            swal({
                title: 'ยืนยันการ  ลบไฟล์ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.destroy_array(key);
                }
            });
        }

        function destroy_old_array(key) {
            swal({
                title: 'ยืนยันการ  ลบไฟล์ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.destroy_old_array(key);
                }
            });
        }
    </script>
@endpush
