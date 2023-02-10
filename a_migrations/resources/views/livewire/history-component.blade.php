<div>

    <div class="row row-lg">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-full table-striped dataTable" id="Datatables">
                    <thead>

                        <tr>
                            @php

                                foreach ($columns as $kc => $vc) {
                                    echo '<th class="text-center">' . $vc['label'] . '</th>';
                                }
                            @endphp

                        </tr>




                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



@push('js')
    <script>
        $(function() {
            call_datatable();
        });

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function set_search() {

            delay(function() {

                $('#Datatables').DataTable().destroy();
                call_datatable();
                return false;
            }, 1000);
        }


        function call_datatable() {


            q = {};

            q.token = '{{ csrf_token() }}';
            q.search_ = $('#search').val();


            var table = $('#Datatables').DataTable({
                processing: true,
                serverSide: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route($api) }}',
                    type: 'GET',
                    data: q,
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

        function change_data() {
            $('#Datatables').DataTable().destroy();
            call_datatable();
            return false;
        }

        function change_status(id) {
            $('#status_form' + id).submit();
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
