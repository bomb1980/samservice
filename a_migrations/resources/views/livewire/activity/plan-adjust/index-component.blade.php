<div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
            'id' => 'fiscalyear_code',
            'onchange' => 'setValue("fiscalyear_code",event.target.value)',
            'class' => 'form-control col-md-2 select2',
            'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}
        @error('fiscalyear_code')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <label class="form-control-label col-md-1 text-right pr-4">หน่วยงาน</label>
        {!! Form::select('dept', $dept_list, $dept, [
            'onchange' => 'setValue("dept",event.target.value)',
            'class' => 'form-control col-md-2 select2',
            'placeholder' => '--เลือกหน่วยงาน--',
        ]) !!}
        @error('dept')
            <label class="text-danger">{{ $message }}</label>
        @enderror
    </div>

    <hr>

    <div class="form-group row col-md-12">
        <div class="form-group row pt-4 pb-1 bg-info col-md-8">
            <div class="row">
                <label class="col-md-2 form-control-label text-left ml-4">
                    <h6><b>จำนวนเงินที่ได้รับจัดสรร</b></h6>
                </label>
                <div class="col-md-3">
                    {!! Form::text('total_amt_all', number_format($total_amt_all), [
                        'id' => 'total_amt_all',
                        'wire:chang' => 'total_amt_all',
                        'class' => 'form-control text-right',
                        'disabled',
                    ]) !!}
                </div>
                <label class="col-md-2 form-control-label text-left ml-4">
                    <h6><b>จำนวนเงินที่ปรับแผน</b></h6>
                </label>
                <div class="col-md-3">
                    {!! Form::text('total_amt', number_format($total_amt), [
                        'id' => 'total_amt',
                        'wire:chang' => 'total_amt',
                        'class' => 'form-control text-right',
                        'disabled',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4 text-right mt-4">
            <a href="{{ route('activity.plan_adjust.hire') }}" class="btn btn-primary icon wb-plus">
                เพิ่มกิจกรรมจ้างงานเร่งด่วน</a>
            <a href="{{ route('activity.plan_adjust.train') }}" class="btn btn-primary icon wb-plus">
                เพิ่มกิจกรรมทักษะฝีมือแรงงาน</a>
        </div>
    </div>

    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ประเภทกิจกรรม</label>
        {!! Form::select('acttype', $acttype_list, $acttype, [
            'onchange' => 'setValue("acttype",event.target.value)',
            'class' => 'form-control col-md-2 select2',
            'placeholder' => '--เลือกประเภทกิจกรรม--',
        ]) !!}
        @error('acttype')
            <label class="text-danger">{{ $message }}</label>
        @enderror

        <div class="col-md-2 input-group form-group ml-4 pl-4">
            <input type="search" id="searchBox" class="form-control" wire:model="txt_search"
                placeholder="คำค้น keyword" />
        </div>

        {{-- <div class="col-md-2">
            <button class="btn btn-primary" wire:click="searchData()">
                <i class="fas fa-search"></i>
            </button>
        </div> --}}
    </div>

    <div class="form-group">
        <table class="table table-bordered table-hover table-striped dataTable">
            <thead>
                <tr>
                    <th class="text-center">ลำดับ</th>
                    <th class="text-center">เลขที่คำขอ</th>
                    <th class="text-center">หน่วยงาน</th>
                    <th class="text-center">ชื่อประเภทกิจกรรม</th>
                    <th class="text-center">อำเภอ</th>
                    <th class="text-center">ตำบล</th>
                    <th class="text-center">หมู่บ้าน</th>
                    <th class="text-center">จำนวนวัน</th>
                    <th class="text-center">จำนวนคน</th>
                    <th class="text-center">รวม</th>
                    {{-- <th class="text-center">สถานะใบคำขอ</th> --}}
                    <th class="text-center">แก้ไข</th>
                    <th class="text-center">ลบ</th>
                </tr>
            </thead>
            <tbody>
                @if ($resultActivities->count())
                    @foreach ($resultActivities as $key => $data)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td class="text-center">{{ $data->act_number }}</td>
                            <td class="text-center">{{ $data->division_name }}</td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->amphur_name }}</td>
                            <td class="text-center">{{ $data->tambon_name }}</td>
                            <td class="text-center">{{ $data->act_moo }}</td>
                            <td class="text-center">{{ $data->act_numofday }}</td>
                            <td class="text-center">{{ $data->act_numofpeople }}</td>
                            <td class="text-center">{{ number_format($data->act_amount, 2) }}</td>
                            <td class="text-center">
                                <div class="icondemo vertical-align-middle p-2">
                                    @if ($data->act_acttype == 1)
                                        <a href="/activity/plan_adjust/hire/{{ $data->act_id }}/edit"><i
                                                class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>
                                    @elseif($data->act_acttype == 2)
                                        <a href="/activity/plan_adjust/train/{{ $data->act_id }}/edit"><i
                                                class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="icondemo vertical-align-middle p-2">
                                    <button type="button" class="btn btn-pure btn-danger icon wb-trash"
                                        onclick="change_delete({{ $data->act_id }})" title="ลบ"></button>
                                    <form action="/activity/ready_confirm/{{ $data->act_id }}"
                                        id="delete_form{{ $data->act_id }}" method="post">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>

        </table>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();

            Livewire.on('emits', () => {
                $('.select2').select2();
            });
        });

        window.onload = function() {
            Livewire.on('popup2', ($act_number) => {
                swal({
                        title: "ลบข้อมูลเสร็จสิ้น",
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.livewire.emit('redirect-to');
                        }
                    });
            });
        }

    </script>
</div>

@push('js')
    <script>
        function setValue(name, val) {
            @this.set(name, val);
        }

        function change_delete(id) {

            swal({
                title: 'ยืนยันการ ลบ ข้อมูล ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit_cancel(id);
                } else {
                    console.log('reject delete');
                }
            });
        }
    </script>
@endpush
