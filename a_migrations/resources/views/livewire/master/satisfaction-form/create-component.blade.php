<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทกิจกรรม: <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('activity_types_id', $activity_types_list, $activity_types_id, [
                        'class' => 'form-control select2',
                        'wire:change' => 'changeActivityType($event.target.value)',
                        'placeholder' => 'กรุณาเลือกประเภทกิจกรรม',
                    ]) !!}
                    @error('activity_types_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ประเภทแบบประเมิน: <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {!! Form::select('assessment_types_id', $assessment_types_list, $assessment_types_id, [
                        'class' => 'form-control select2',
                        'wire:change' => 'changeAssessmentType($event.target.value)',
                        'placeholder' => 'กรุณาเลือกประเภทแบบประเมิน',
                    ]) !!}
                    @error('assessment_types_id')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label"> </label>
                <label class="col-md-6 form-control-label text-left">ชุดคำถามแบบให้คะแนน (1 น้อยสุด - 5 มากสุด)</label>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label"> </label>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover table-striped w-full dataTable"
                        id="Datatables">
                        <thead>
                            <tr>
                                <th class="col-1 text-center">ลำดับ</th>
                                <th class="text-left">คำถาม</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-1 text-center">1</td>
                                <td>
                                    {{ Form::text('assess_type.0', null, [
                                        'wire:model' => 'assess_type.0',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off',
                                    ]) }}
                                </td>
                                <td class="text-center"><button type="button" wire:click.prevent="add1()"
                                        class="btn btn-pure btn-success icon wb-plus"></button></td>
                            </tr>
                            @foreach ($question_arr1 as $key => $val)
                                @if ($key != 0)
                                    <tr>
                                        <td class="col-1 text-center">{{ $key + 1 }}</td>
                                        <td>
                                            {{ Form::text('assess_type.' . $key, null, [
                                                'wire:model' => 'assess_type.' . $key,
                                                'class' => 'form-control',
                                                'autocomplete' => 'off',
                                            ]) }}
                                        </td>
                                        <td class="text-center">
                                            <i onclick="change_delete1({{ $key }})"
                                                id="remove_item1{{ $key }}"
                                                class="icon wb-trash btn btn-pure btn-danger pull-left"
                                                aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label"> </label>
                <label class="col-md-6 form-control-label text-left">ชุดคำถามแบบอธิบาย</label>
            </div>

            <div class="form-group row">
                <label class="col-md-3 form-control-label"> </label>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover table-striped w-full dataTable"
                        id="Datatables">
                        <thead>
                            <tr>
                                <th class="col-1 text-center">ลำดับ</th>
                                <th class="text-left">คำถาม</th>
                                <th class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-1 text-center">1</td>
                                <td>
                                    {{ Form::text('assess_hdr.0', null, [
                                        'wire:model' => 'assess_hdr.0',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off',
                                    ]) }}
                                </td>
                                <td class="text-center"><button type="button" wire:click.prevent="add2()"
                                        class="btn btn-pure btn-success icon wb-plus"></button></td>
                            </tr>
                            @foreach ($question_arr2 as $key => $val)
                                @if ($key != 0)
                                    <tr>
                                        <td class="col-1 text-center">{{ $key + 1 }}</td>
                                        <td>
                                            {{ Form::text('assess_hdr.' . $key, null, [
                                                'wire:model' => 'assess_hdr.' . $key,
                                                'class' => 'form-control',
                                                'autocomplete' => 'off',
                                            ]) }}
                                        </td>
                                        <td class="text-center">
                                            <i onclick="change_delete2({{ $key }})"
                                                id="remove_item2{{ $key }}"
                                                class="icon wb-trash btn btn-pure btn-danger pull-left"
                                                aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                {!! link_to(route('master.coursetype.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>

@push('js')
    <script>
        $('.select2').select2();

        function submit_click() {
            swal({
                title: 'ยืนยันการ บันทึก ข้อมูล ?',
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

        function change_delete1(id) {
            swal({
                title: 'ยืนยันการ ลบ รายการข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.remove1(id);
                } else {
                    console.log('reject delete');
                }
            });
        }

        function change_delete2(id) {
            swal({
                title: 'ยืนยันการ ลบ รายการข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.remove2(id);
                } else {
                    console.log('reject delete');
                }
            });
        }
    </script>
@endpush
