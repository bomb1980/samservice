<div>
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <div class="col-2 form-control-label text-right">ปี</div>
                <div class="col-4">
                    {{ Form::select('year', [2565], null, ['class' => 'form-control']) }}
                </div>
                <div class="col-2 form-control-label text-right">หน่วยงาน</div>
                <div class="col-4">
                    {{ Form::select('department', ['หน่วยงาน 1', 'หน่วยงาน 2', 'หน่วยงาน 3'], null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 form-control-label text-right">ประเภท</div>
                <div class="col-5">
                    {{ Form::select('type', ['ประเภท 1', 'ประเภท 2', 'ประเภท 3'], null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 form-control-label text-right">โครงการ</div>
                <div class="col-5">
                    {{ Form::text('project', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <div class="col-12 text-right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">เพิ่ม</button>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-4 text-right">วันที่</div>
                                <div class="col-5 input-group">
                                    <input type="text" class="form-control datepicker" data-date-language="th-th" wire:model.defer="date" placeholder="วันที่" id="date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon wb-calendar" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4 text-right">รายการ</div>
                                <div class="col-5">
                                    <input class="form-control" type="text" wire:model.defer="name">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4 text-right">จำนวนเงิน</div>
                                <div class="col-5">
                                    <input class="form-control" type="number" wire:model.defer="amount">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-4 text-right">หมายเหตุ</div>
                                <div class="col-5">
                                    <textarea class="form-control" wire:model.defer="remark" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" onclick="addItem()">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-1"></div>
                <div class="col-10">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr style="background: #cce2fe; color: #3e8efe">
                                <th width="25%">วันที่</th>
                                <th width="50%">รายการ</th>
                                <th width="25%">จำนวนเงิน</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($items as $key => $item)
                            <tr class="text-center">
                                <td>{{ $item['date'] }}</td>
                                <td class="text-left">{{ $item['name'] }}</td>
                                <td>{{ number_format($item['amount']) }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <button wire:click="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('activity.other_expense.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            window.livewire.on('add_item', function() {
                closeModal();
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
                    @this.redirectTo();
                });
            });
        });
    </script>
</div>

@push('js')
    <script>
        function addItem() {
            let date = $('#date').val();
            @this.set('date', date);
            @this.addItem();
        }

        function closeModal() {
            $('#exampleModal').modal('hide');
        }

        $(function() {
            $('.datepicker').datepicker({
                orientation: 'auto bottom'
            });
        });
    </script>
@endpush
