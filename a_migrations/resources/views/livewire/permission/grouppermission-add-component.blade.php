<div>
    {{-- {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' => 'form-horizontal fv-form fv-form-bootstrap4']) !!} --}}
    <div class="form-group row">
        <label class="col-md-1 form-control-label text-right">กลุ่มผู้ใช้งาน: <span
                class="text-danger">*</span></label>
        <div class="col-md-5">
            {!! Form::select('role_id', $Role, null, ['wire:change' => 'changeRole($event.target.value)', 'class' => 'form-control', 'id' => 'role_id', 'placeholder' => 'กรุณาเลือก กลุ่มผู้ใช้งาน']) !!}
            @error('role_id')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <br>
        <div class="text-right">
            <input type="checkbox" wire:click="allrow()" id="selectall" wire:model="selectall">
            <label for="selectall">เลือกทั้งหมด</label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                    <thead>
                        <tr>
                            <th class="text-center col-1">ลำดับ</th>
                            <th class="text-center col-3">เมนูหลัก</th>
                            <th class="text-center col-3">เมนูย่อย</th>
                            <th class="text-center col-1">ดูข้อมูล</th>
                            <th class="text-center col-1">เพิ่มข้อมูล</th>
                            <th class="text-center col-1">แก้ไขข้อมูล</th>
                            <th class="text-center col-1">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sub_menu)>0)
                        @foreach ($sub_menu as $key => $val)

                        {{-- @if ($val->admin == 1 && $this->role_id == 3)


                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-left">{{ $sub_menu[$key]['menu_name'] }}</td>
                            <td class="text-left">{{ $sub_menu[$key]['submenu_name'] }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        @else --}}

                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-left">{{ $val->menu_name }}</td>
                            <td class="text-left">{{ $val->submenu_name }}</td>
                            <td class="text-center"><input type="checkbox" wire:model="view_data.{{ $val->submenu_id }}"></td>
                            <td class="text-center"><input type="checkbox" wire:model="insert_data.{{ $val->submenu_id }}"></td>
                            <td class="text-center"><input type="checkbox" wire:model="update_data.{{ $val->submenu_id }}"></td>
                            <td class="text-center"><input type="checkbox" wire:model="delete_data.{{ $val->submenu_id }}"></td>
                        </tr>
                        {{-- @endif --}}
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="5"></td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div class="col-md-12">
                        <button type="button" wire:click='save_menu()' class="btn btn-primary">บันทึก</button>
                        <button type="button" wire:click='redirect_to()' class="btn btn-default btn-outline">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- {!! Form::close() !!} --}}
    <script>
        window.onload = function() {
            Livewire.on('popup', () => {
                swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                    },
                    function(isConfirm){
                        if (isConfirm) {
                           // window.livewire.emit('redirect-to');
                    }
                });
            });
        }
    </script>
</div>
