<div>
    <div class="form-group row">
        {{-- เลขที่คำขอ หน่วยงาน ชื่อประเภทกิจกรรม --}}
        <div class="col-1 text-right">
            <label class="form-control-label">ปีงบประมาณ</label>
        </div>
        <div class="col-2">
            {{ Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
                'onchange' => 'setValue("fiscalyear_code",event.target.value)',
                'id' => 'fiscalyear_code',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกปีงบประมาณ--',
            ]) }}
            @error('fiscalyear_code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
        <div class="col-1 text-right">
            <label class="form-control-label">หน่วยงาน</label>
        </div>
        <div class="col-2">
            {{ Form::select('dept_id', $dept_list, $dept_id, [
                'onchange' => 'setValue("dept_id",event.target.value)',
                'id' => 'dept_id',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกหน่วยงาน--',
            ]) }}
            @error('dept_id')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right">
            <label class="form-control-label">ประเภทกิจกรรม</label>
        </div>
        <div class="col-2">
            {{ Form::select('acttype_id', $acttype_list, $acttype_id, [
                'onchange' => 'setValue("acttype_id",event.target.value)',
                'id' => 'acttype_id',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกประเภทกิจกรรม--',
            ]) }}
            @error('acttype_id')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right">
            <label class="form-control-label">เลขที่คำขอ</label>
        </div>
        <div class="col-2">
            {{ Form::select('reqform_id', $reqform_no_list, $reqform_id, [
                'onchange' => 'setValue("reqform_id",event.target.value)',
                'id' => 'reqform_id',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกประเภทกิจกรรม--',
            ]) }}
            @error('reqform_id')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
        @if ($reqform_id > 0)
            <div class="col-3 offset-6">
                <div class="row">
                    <div class="col">
                        @if ($c_status)
                            <a target="_blank"
                                href="{{ route('population.create', ['act_id' => $reqform_id, 'act_number' => $reqform_no_list[$reqform_id], 'role' => 2]) }}"
                                class="btn btn-primary mx-1 w-full">เพิ่มข้อมูลผู้เข้าร่วม</a>
                        @else
                            <button type="button" class="btn btn-primary btn-md" disabled>
                                เพิ่มข้อมูลผู้เข้าร่วม</button>
                        @endif
                    </div>
                    <div class="col">
                        @if ($c_status)
                            <a target="_blank"
                                href="{{ route('population.create_lecturer', ['act_id' => $reqform_id]) }}"
                                class="btn btn-primary mx-1 w-full">เพิ่มวิทยากร</a>
                        @else
                            <button type="button" class="btn btn-primary btn-md" disabled>
                                เพิ่มวิทยากร</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
    <hr>
    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered border table-hover table-striped w-full dataTable text-center"
                id="Datatables">
                <thead>
                    <tr>
                        <td>ชื่อ-นามสกุล</td>
                        <td>อายุ</td>
                        <td>ตำบล</td>
                        <td>อำเภอ</td>
                        <td>จังหวัด</td>
                        <td>สถานะ</td>
                        <td>รายละเอียด</td>
                    </tr>
                </thead>
                @if ($reqform_id > 0)
                    <tbody>
                        @foreach ($resultPop as $value)
                            <tr>
                                <td>{{ titlename($value->pop_title) }} {{ $value->pop_firstname }}
                                    {{ $value->pop_lastname }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->pop_birthday)->age }}</td>
                                <td>{{ $value->tambon_name }}</td>
                                <td>{{ $value->amphur_name }}</td>
                                <td>{{ $value->province_name }}</td>
                                @if ($value->pop_role == 1)
                                    <td> วิทยากร </td>
                                @elseif ($value->pop_role == 2)
                                    <td> ผู้เข้าร่วม </td>
                                @else
                                    <td> ผู้นำชุมชน </td>
                                @endif
                                <td><a href="/population/{{ $reqform_id }}/{{ $value->pop_id }}/edit"
                                        target="_blank"><i class="icon wb-edit" aria-hidden="true"
                                            title="รายละเอียด"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
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
</div>

@push('js')
    <script>
        function setValue(name, val) {
            @this.set(name, val);
        }

        $(function() {
            @if (session()->get('message_create'))
                swal('', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
            @endif

            @if (session()->get('message_edit'))
                swal('', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success');
            @endif

            @if (session()->get('message_delete'))
                swal('', 'ลบข้อมูล เรียบร้อยแล้ว', 'success');
            @endif
        });
    </script>
@endpush
