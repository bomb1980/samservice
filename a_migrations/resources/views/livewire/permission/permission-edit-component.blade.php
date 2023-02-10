<div>
    <div class="panel-body">
        <div class="form-group row">
            <label class="col-md-1 form-control-label text-center">ชื่อ-นามสกุล : <span
                    class="text-danger">*</span></label>


            {{-- @if ($form_status == 'edit') --}}
                <div class="col-md-4">
                    <input list="brow" class="form-control" wire:model="name_search" disabled>

                    @error('name_search')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror

                </div>
            {{-- @else --}}
                {{-- <div class="col-md-4">
                    <input id="brow_list" list="brow" class="form-control" onChange="test()">
                    <datalist id="brow">
                        @foreach ($employee_list as $key => $val)
                            @php
                                $dept_or_divi = $val['dept_name_th'] ? $val['dept_name_th'] : $val['division_name'];
                            @endphp

                            @if ($dept_or_divi)
                                <option data-value="{{ $val['em_citizen_id'] }}"
                                    value="{{ $val['prefix_name_th'] . ' ' . $val['em_name_th'] . ' ' . $val['em_surname_th'] . ' (' . $dept_or_divi . ')' }}">
                                </option>
                            @else
                                <option data-value="{{ $val['em_citizen_id'] }}"
                                    value="{{ $val['prefix_name_th'] . ' ' . $val['em_name_th'] . ' ' . $val['em_surname_th'] }}">
                                </option>
                            @endif
                        @endforeach
                    </datalist>
                    @error('name_search')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            @endif --}}




            <label class="col-md-1 form-control-label text-center">กลุ่มผู้ใช้งาน: <span
                    class="text-danger">*</span></label>
            <div class="col-md-4">
                {!! Form::select('role_id', $Role, $role_id, [
                    'wire:change' => 'changeRole($event.target.value)',
                    'class' => 'form-control',
                    'id' => 'role_id',
                    'placeholder' => 'กรุณาเลือก กลุ่มผู้ใช้งาน',
                ]) !!}
                @error('role_id')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-md-2">
                <input type="checkbox"  id="change_checkbox" wire:model="change_checkbox">
                <label class="form-control-label" for="change_checkbox">กำหนดสิทธิ์เอง</label>
            </div>
        </div>
        <div class="text-right">
            <input type="checkbox" wire:click="allrow()" id="selectall" wire:model="selectall">
            <label for="selectall">เลือกทั้งหมด</label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">ฟังก์ชั่นหลัก</th>
                            <th class="text-center">ฟังก์ชั่นย่อย</th>
                            <th class="text-center">ดูข้อมูล</th>
                            <th class="text-center">เพิ่มข้อมูล</th>
                            <th class="text-center">แก้ไขข้อมูล</th>
                            <th class="text-center">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menulist as $key => $val)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-left">{{ $val->menu_name }}</td>
                            <td class="text-left">{{ $val->submenu_name }}</td>
                            <td class="text-center"><input type="checkbox"
                                    wire:model="view_data.{{$val->submenu_id}}"
                                    {{ $change_checkbox == 0 ? 'disabled' : '' }}></td>
                            <td class="text-center"><input type="checkbox"
                                    wire:model="insert_data.{{$val->submenu_id}}"
                                    {{ $change_checkbox == 0 ? 'disabled' : '' }}></td>
                            <td class="text-center"><input type="checkbox"
                                    wire:model="update_data.{{$val->submenu_id}}"
                                    {{ $change_checkbox == 0 ? 'disabled' : '' }}></td>
                            <td class="text-center"><input type="checkbox"
                                    wire:model="delete_data.{{$val->submenu_id}}"
                                    {{ $change_checkbox == 0 ? 'disabled' : '' }}></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <div class="col-md-12">
                    <button type="button" wire:click='submit()' class="btn btn-primary">บันทึก</button>
                    <button type="button" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        function test() {
            var value = $('#brow_list').val();

            if (value) {
                //alert( value );
                window.livewire.emit('redirect-to-name_search', {
                    data: $('#brow [value="' + value + '"]').data('value')
                });
            } else {
                window.livewire.emit('redirect-to-name_search', {
                    data: 'false'
                });
            }
        }
    </script>
@endpush
