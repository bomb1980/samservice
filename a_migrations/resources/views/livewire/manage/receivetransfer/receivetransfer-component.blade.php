<div>
    <br>
    <div class="row form-group">


        @if ( empty( $delete_budget_id ) )

        <div class="col-md-2">
            {!! Form::select('fiscalyear_code', $fiscalyear_list, $fiscalyear_code, [
                'onchange' => 'setSearch()',
                'id' => 'fiscalyear_code',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกปีงบประมาณ--',
            ]) !!}
            @error('fiscalyear_code')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
        @else


        @endif
    </div>

    {!! Form::open([
        'wire:submit.prevent' => 'submit(Object.fromEntries(new FormData($event.target)))',
        'autocomplete' => 'off',
        'class' => 'fv-form form-horizontal fv-form-bootstrap4',
    ]) !!}


    <table class="table table-bordered table-hover table-striped" id="Datatables">
        <thead>
            <tr>
                @php

                    foreach ($columns as $kc => $vc) {
                        $className = 'text-center';
                        if (isset($vc['className'])) {
                            $className = $vc['className'];
                        }
                        echo '<th class="' . $className . '">' . $vc['label'] . '</th>';
                    }
                @endphp

            </tr>
        </thead>
    </table>

    @if (!empty($delete_budget_id))
        <button style="display: none;" type="submit" class="btn btn-primary afddfddsfdsfsfdsd">{!! getIcon('save') !!} บันทึกงบประมาณ</button>


        <div style="text-align: center;" id="select_submit">
            <div class="btn btn-primary" onclick="send_submit()">
                ลบข้อมูล
            </div>

            <a href="{{ route('manage.receivetransfer.index') }}" class="btn btn-default btn-outline">ยกเลิก</a>
        </div>

    @endif
    {!! Form::close() !!}

</div>

@push('js')
    <script>
        function send_submit(id) {

            swal({
                title: 'โปรดกดยืนยันการลบรายการ',
                icon: 'close',
                type: "warning",
                showCancelButton: false,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#00BCD4',
            }, function(isConfirm) {
                if (isConfirm) {

                    $('.afddfddsfdsfsfdsd').trigger('click');

                    // location.reload();
                    window.location = '{{route('manage.receivetransfer.index')}}';
                    // $('#delete_form' + id).submit();
                } else {
                    console.log('reject');
                }
            });



        }
        $(function() {


            call_datatable('');
        });

        function setSearch() {


            $('#Datatables').DataTable().destroy();
            call_datatable();
            return false;
        }

        function call_datatable() {

            var table = $('#Datatables').DataTable({
                processing: false,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.manage.receivetransfer.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        fiscalyear_code: $("#fiscalyear_code").val(),
                        delete_budget_id: {!! json_encode($delete_budget_id) !!}
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columns: [
                    @php
                        foreach ($columns as $kc => $vc) {
                            $className = 'text-center';
                            if (isset($vc['className'])) {
                                $className = $vc['className'];
                            }

                            echo '{
                                data: \'' .
                                $vc['name'] .
                                '\',
                                name: \'' .
                                $vc['name'] .
                                '\',
                                className: "' .
                                $className .
                                '",
                                orderable: true,
                            },';
                        }
                    @endphp
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai.json',
                },
                paging: true,
                pageLength: 10,
                ordering: false,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });

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
                    $('#delete_form' + id).submit();
                } else {
                    console.log('reject delete');
                }
            });
        }
    </script>
@endpush
