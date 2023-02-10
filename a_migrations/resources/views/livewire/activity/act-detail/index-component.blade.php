<div>
    <div class="form-group row">
        <label class="form-control-label col-md-1 text-right pr-4">ปีงบประมาณ</label>
        {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
            'class' => 'form-control col-md-2 select2',
            'onchange' => 'changeFiscalyear(event.target.value)',
            'placeholder' => '--เลือกปีงบประมาณ--',
        ]) !!}
    </div>
    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped text-center" id="Datatables">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ลำดับ</th>
                        <th class="text-center">ปีงบประมาณ</th>
                        <th class="text-center">เลขที่คำขอ</th>
                        <th class="text-center">ชื่อกิจกรรม</th>
                        <th class="text-center">ประเภทกิจกรรม</th>
                        <th class="col-1 text-center">รายละเอียด</th>
                        <th class="col-1 text-center">ปรับปรุงระยะเวลา</th>
                    </tr>
                </thead>
                @if ($fiscalyear_code > 0)
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($resultact as $value)
                            <tr>
                                <td> {{ $i++ }} </td>
                                <td>{{ $value->act_year }}</td>
                                <td>{{ $value->act_number }}</td>
                                <td>{{ $value->act_shortname }}</td>
                                <td>{{ $value->act_acttype == 1 ? 'กิจกรรมจ้างงานเร่งด่วน' : 'กิจกรรมทักษะฝีมือแรงงาน' }}
                                </td>
                                <td>
                                    @if ($value->act_acttype == 2)
                                        <a
                                            href="{{ route('operate.result_train.detail', ['id' => $value->act_id, 'p_id' => 1]) }}"><i
                                                class="icon wb-eye" aria-hidden="true" title="รายละเอียด"></i></a>
                                    @else
                                        <a href="{{ route('operate.emer_employ.detail', ['id' => $value->act_id, 'p_id' => 1]) }}"><i
                                                class="icon wb-eye" aria-hidden="true" title="รายละเอียด"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('activity.act_detail.create', ['act_id' => $value->act_id]) }}"><i
                                            class="icon wb-edit" aria-hidden="true" title="ปรับปรุง"></i></a>
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
        $(function() {
            @if (session('success'))
                swal({
                    title: "บันทึกปรับปรุงระยะเวลาเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif


            @if (session('success_del'))

                swal({
                    title: "ลบข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                });
            @endif

        });

        function changeFiscalyear(val) {
            @this.set('fiscalyear_code', val);
        }
    </script>
@endpush
