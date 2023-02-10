<div>
    {{ Form::open([
    'wire:submit.prevent' => 'submit()',
    'autocomplete' => 'off',
    'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) }}
    <div class="form-group row">
        <label class="form-control-label col-md-1">ปีงบประมาณ</label>
        {!! Form::select('year', $fiscalyear_list_modal, $year, [
        // 'id' => 'fiscalyear_list_modal',
        'wire:change' => 'setYear($event.target.value)',
        'class' => 'form-control col-md-2',
        'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}

        <label class="form-control-label col-md-1">ประเภทกิจกรรม</label>
        {!! Form::select('acttype_id', $acttype_list, null, [
        'id' => 'acttype_id',
        'wire:change' => 'setAct($event.target.value)',
        'class' => 'form-control col-md-2',
        'placeholder' => '--เลือกประเภทกิจกรรม--',
        ]) !!}
        @error('acttype_id')
        <label class="text-danger">{{ $message }}</label>
        @enderror

        @if ($year)
        <label class="form-control-label col-md-1">เลขที่คำขออ้างอิง</label>
        {!! Form::select('req_number', $ref_number_list, $req_number, [
        'id' => 'req_number',
        'wire:change' => 'setReq($event.target.value)',
        'class' => 'form-control col-md-2',
        'placeholder' => '--เลขที่คำขออ้างอิง--',
        ]) !!}
        {{-- @error('req_number')
        <label class="text-danger">{{ $message }}</label>
        @enderror --}}
        @else
        <div class="col-md-3"></div>
        @endif

        <div class="col-md-3 d-flex justify-content-end">
            {{-- <div class="col-md-9 input-group">
                <input type="input" wire:keyup="search($event.target.value)" wire:change="search($event.target.value)"
                    id="search" class="form-control" placeholder="คำค้น keyword" />
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div> --}}

            <div class="col-md-8 input-group form-group">
                <input type="search" wire:keyup="search($event.target.value)" wire:change="search($event.target.value)" id="search" class="form-control" placeholder="คำค้น keyword" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        @if ($year)
        @error('act_number')
        <label class="text-danger offset-7">{{ $message }}</label>
        @enderror
        @else
        @error('year')
        <label class="text-danger offset-1">{{ $message }}</label>
        @enderror
        @endif
    </div>

    <div class="form-group">
        <div class="table-responsive" id="parenTable">
            <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables2">
                <thead>
                    <tr style="background-color: rgb(111, 190, 255)">
                        <th class="text-center">
                            {{-- <input type="checkbox" wire:click="allrow()" id="selectall" wire:model="selectall">
                            --}}
                        </th>
                        <th class="text-center">เลขที่คำขอ</th>
                        <th class="text-center">ประเภทกิจกรรม</th>
                        <th class="text-center">ชื่อกิจกรรม</th>
                        <th class="text-center">อำเภอ</th>
                        <th class="text-center">ตำบล</th>
                        <th class="text-center">หมู่</th>
                        <th class="text-center">รวมค่าใช้จ่าย</th>
                        <th class="text-center">รายละเอียด</th>
                    </tr>
                </thead>
                @if ($year)
                <tbody>
                    @foreach ($req_list as $key => $val)
                    <tr>
                        <td class="text-center">
                            {!! Form::radio('req_clone{{$key}}', $val['req_id'], false, [
                            'wire:model' => 'req_clone',
                            'style' => 'cursor: pointer'])
                            !!}
                        </td>
                        <td>{{ $req_list[$key]['req_number'] }}</td>
                        <td>{{ $req_list[$key]['name'] }}</td>
                        <td>{{ $req_list[$key]['req_shortname'] }}</td>
                        <td>{{ $req_list[$key]['amphur_name'] }}</td>
                        <td>{{ $req_list[$key]['tambon_name'] }}</td>
                        <td>{{ $req_list[$key]['req_moo'] }}</td>
                        <td>{{ number_format($req_list[$key]['req_amount']) }}</td>
                        <td>{{ $req_list[$key]['req_remark'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>
    </div>
    @error('req_clone')
    <label class="text-danger">{{ $message }}</label>
    @enderror

    <div class="row mt-4">
        <div class="col-12 text-center">
            <button class="btn btn-default" wire:click.prevent="cancel()">ยกเลิก</button>
            {{-- <button class="btn btn-primary ml-4" wire:click.prevent="addAct()">คัดลอกรายการ</button> --}}
            <button type="button" onclick="submit_click()" class="btn btn-primary">คัดลอกรายการ</button>
        </div>
    </div>
    {{ Form::close() }}
</div>

@push('js')
<script>
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
                @this.addAct();
            }
        });
    }

    // Livewire.on('popup', () => {
    //         swal({
    //                 title: "คัดลอกข้อมูลเรียบร้อย",
    //                 type: "success",
    //                 confirmButtonColor: "#DD6B55",
    //                 confirmButtonText: "OK",
    //             },
    //             function(isConfirm) {
    //                 if (isConfirm) {
    //                     window.livewire.emit('redirect-to');
    //                 }
    //             });
    //     });
</script>
@endpush
