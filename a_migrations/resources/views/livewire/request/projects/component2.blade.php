<div>
    <div class="page-header">
        <h1 class="page-title">บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="keychainify-checked">หน้าแรก</a></li>

            <li class="breadcrumb-item active">บันทึกผลการพิจารณาคำขอรับการจัดสรรงบประมาณ</li>
        </ol>

    </div>
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                {{ Form::select('years_code', $years_list, $years_code, [
                                    'id' => 'years_code',
                                    'onchange' => 'setSearch( \'years_code\' )',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--เลือกปีงบประมาณ--',
                                ]) }}

                            </div>

                            <div class="col-md-2 form-group">
                                {{ Form::select('divi_code', $divi_list, $divi_code, [
                                    'id' => 'divi_code',
                                    'onchange' => 'setSearch( \'divi_code\' )',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--หน่วยงาน--',
                                ]) }}

                            </div>
                            <div class="col-md-2 form-group">
                                {{ Form::select('req_acttype', $acttype_list, $req_acttype, [
                                    'id' => 'req_acttype',
                                    'onchange' => 'setSearch(\'req_acttype\')',
                                    'class' => 'form-control select2',
                                    'placeholder' => '--ประเภทกิจกรรม--',
                                ]) }}
                            </div>
                            <div class="col-md-2 offset-md-4 input-group form-group">
                                <input value="" type="search" class="form-control" id="serachbox"
                                    oninput="setSearch( 'serachbox')" placeholder="คำค้น (Keyword)" />
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="onRoom" onRoom="รวม" class="row">


                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md" style="margin-bottom: 30px">
                                        <div data-click-state=0 name="selecter" id="select_2"
                                            onclick="onclick_select('#select_2', '#F79009', 'selecter_2_text', 'รอพิจารณา', 2)"
                                            class="bomb-bt select-status2" style="border-radius: 25px;">
                                            <div class="card-block text-center">
                                                <h1 class="card-title"><img src="{{ asset('assets/images/2.png') }}"
                                                        width="60px;" alt="">
                                                </h1>
                                                <p glob_name="selecter_text" name="selecter_2_text"
                                                    class="h4 font-weight-bold", style="">รอพิจารณา</p>
                                                <p glob_name="selecter_text" name="selecter_2_text"
                                                    class="h5 font-weight-bold", style=""><span
                                                        id="selecC2">{{ $selecterC2 }}</span>
                                                    รายการ</p>
                                                <p glob_name="selecter_text" name="selecter_2_text"
                                                    class="h5 font-weight-bold", style="">จำนวนเงิน <span
                                                        id="selecS2">{{ $selecterS2 }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md" style="margin-bottom: 30px">
                                        <div data-click-state=0 name="selecter" id="select_3"
                                            onclick="onclick_select('#select_3', '#27AE60', 'selecter_3_text', 'ผ่านการพิจารณา', 3)"
                                            class="bomb-bt select-status3" style="border-radius: 25px;">
                                            <div class="card-block text-center">
                                                <h1 class="card-title"><img src="{{ asset('assets/images/3.png') }}"
                                                        width="60px;" alt="">
                                                </h1>
                                                <p glob_name="selecter_text" name="selecter_3_text"
                                                    class="h4 font-weight-bold", style="">ผ่านการพิจารณา</p>
                                                <p glob_name="selecter_text" name="selecter_3_text"
                                                    class="h5 font-weight-bold" style=""><span
                                                        id="selecC3">{{ $selecterC3 }}</span> รายการ</p>
                                                <p glob_name="selecter_text" name="selecter_3_text"
                                                    class="h5 font-weight-bold" style="">จำนวนเงิน <span
                                                        id="selecS3">{{ $selecterS3 }}</span></p>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md" style="margin-bottom: 30px">
                                        <div data-click-state=0 name="selecter" id="select_4"
                                            onclick="onclick_select('#select_4', '#F04438', 'selecter_4_text','ไม่ผ่านการพิจารณา', 4)"
                                            class="bomb-bt select-status4" style="border-radius: 25px;">
                                            <div class="card-block text-center">
                                                <h1 class="card-title"><img src="{{ asset('assets/images/8.png') }}"
                                                        width="60px;" alt="">
                                                </h1>
                                                <p glob_name="selecter_text" name="selecter_4_text"
                                                    class="h4 font-weight-bold" style="">ไม่ผ่านการพิจารณา</p>
                                                <p glob_name="selecter_text" name="selecter_4_text"
                                                    class="h5 font-weight-bold" style=""><span
                                                        id="selecC4">{{ $selecterC4 }}</span> รายการ</p>
                                                <p glob_name="selecter_text" name="selecter_4_text"
                                                    class="h5 font-weight-bold" style="">จำนวนเงิน <span
                                                        id="selecS4">{{ $selecterS4 }}</span></p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md" style="margin-bottom: 30px">
                                        <div data-click-state=0 name="selecter" id="select_5"
                                            onclick="onclick_select('#select_5', '#4F8FEF', 'selecter_5_text', 'รวม', 0)"
                                            class="bomb-bt select-status5" style="border-radius: 25px;">
                                            <div class="card-block text-center">
                                                <h1 class="card-title"><img src="{{ asset('assets/images/7.png') }}"
                                                        width="60px;" alt="">
                                                </h1>
                                                <p glob_name="selecter_text" name="selecter_5_text"
                                                    class="h4 font-weight-bold" style="">รวม</p>
                                                <p glob_name="selecter_text" name="selecter_5_text"
                                                    class="h5 font-weight-bold" style=""><span
                                                        id="selecC5">{{ $selecterC5 }}</span> รายการ</p>
                                                <p glob_name="selecter_text" name="selecter_5_text"
                                                    class="h5 font-weight-bold" style="">จำนวนเงิน <span
                                                        id="selecS5">{{ $selecterS5 }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div name="selector" class="time-progess-content" id="alert">
                            <div class="time-progess"
                                style="background-color: {{ $arr['alert'] }};  width: {{ $arr['per'] }}%;"></div>

                            <div class="my-text-in-progress">

                                <div class="show-on-window"><strong>สำนักงานจังหวัด : </strong><span
                                        id="division">{{ $division }}</span></div>
                                <div  class="show-on-window"><strong>ช่วงวันที่รวบรวมคำขอ : {{ $arr['st'] }} - {{ $arr['en'] }}</strong>
                                </div>
                                <div><Strong>{{ $text_desc }}</Strong></div>
                            </div>
                        </div>


                        <div class="my-text-in-hide-on-window" style="text-align: center;">

                            <div><strong>สำนักงานจังหวัด : </strong><span id="division">{{ $division }}</span>
                            </div>

                            <div><strong>ช่วงวันที่รวบรวมคำขอ : {{ $arr['st'] }} - {{ $arr['en'] }}</strong>
                            </div>
                            {{-- <br>
                            <div><Strong>{{ $text_desc }}</Strong></div> --}}

                        </div>

                        <div style="margin-top: 30px;" class='row' wire:ignore>
                            <div class='col-md-12'>
                                <div class="table-responsive" id="parenTable">
                                    <table class="table table-bordered table-hover table-striped w-full dataTable"
                                        id="Datatables">
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
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var del_visibility = true;

        var table;

        var status = 0;
        // search = '';
        document.addEventListener('livewire:load', function() {

            $('.select2').select2();

            $('body').on('click', '#checkedAll', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle', rows).prop('checked', this.checked);
            });


            call_datatable('');
            window.livewire.on('loadJquery', () => {
                $('.select2').select2();

                call_datatable('');


            });

            @if (session()->get('send_error') != null)
                swal('', '{{ session()->get('send_error') }}', 'error');
            @elseif (session()->get('pending_room') != null)
                swal('', '{{ session()->get('pending_room') }}', 'success');
            @endif
        });

        function onclick_select(id, class_name, name_text, selecter, my_status) {

            $('.bomb-bt').removeClass('active');

            $(id).addClass('active');

            status = my_status;
            call_datatable('');
        }

        function setSearch(name) {
            @this.years_code = $("#years_code").val();
            @this.req_acttype = $("#req_acttype").val();
            @this.divi_code = $("#divi_code").val();


            if (name != 'serachbox') {
                $('#serachbox').val('');

            }

            @this.serachbox = $('#serachbox').val();


            @this.setArea(name);
            status = 0;

            return false;
        }

        function call_datatable(search) {

            q = {};
            q.token = '{{ csrf_token() }}';
            q.req_year = $('#years_code').val();
            q.req_acttype = $('#req_acttype').val();
            q.serachbox = $('#serachbox').val();
            q.divi_code = $('#divi_code').val();
            q.status = status;

            // console.log(status);

            $('#Datatables').DataTable().destroy();
            table = $('#Datatables').DataTable({
                pageLength: 20,
                ordering: true,
                order: [
                    [2, 'desc']
                ],
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
                                orderable: false,
                            },';
                        }
                    @endphp
                ],
                language: {
                    url: '{{ asset('assets') }}/js/datatable-thai2.json',
                },
                paging: true,

                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);

                    $('span.switchery').remove();
                    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                    elems.forEach(function(html) {

                        var switchery = new Switchery(html);
                    });
                    $('.js-switch').change(function() {
                        let is_active = $(this).prop('checked') === true ? 1 : 0;
                        let id = $(this).data('id');
                        if (id) {
                            $('#status_form' + id).submit();
                        }
                    });
                }
            });

            // table.on('order.dt search.dt', function() {
            //     let i = 1;

            //     table.cells(null, 1, {
            //         search: 'applied',
            //         order: 'applied'
            //     }).every(function(cell) {
            //         this.data(i++);
            //     });
            // });
            // table.on('order.dt', function() {}).search(search).draw();
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
                    // @this.del(id, $("#years_code").val());
                    $('#delete_form' + id).submit();
                } else {
                    console.log('reject delete');
                }
            });
        }

        function send_submit(id) {
            let a = [];
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('.checkSingle', rows).each(function() {
                if ($(this).prop("checked") == true) {
                    a.push(this.value);;
                }
            });

            if (a.length == 0) {
                swal({
                    title: 'โปรดเลือดรายการคำขออย่างน้อย 1 รายการ',
                    icon: 'close',
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#00BCD4',
                }, function(isConfirm) {
                    if (isConfirm) {
                        // $('#delete_form' + id).submit();
                    } else {
                        console.log('reject');
                    }
                });
            } else {
                swal({
                    title: 'ยืนยันส่งคำขอพิจารณาใช่หรือไม่',
                    icon: 'close',
                    html: true,
                    // text: "<p onclick='exel()', style='cursor:pointer; color:blue;'>โหลดไฟล์ exel คลิกที่นี้</p>",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#00BCD4',
                    cancelButtonText: 'ยกเลิก',
                    cancelButtonColor: '#00BCD4',
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#Datatables').DataTable().destroy();
                        // var str = $("#years_code").val();
                        // @this.years_code = str;
                        @this.select_record_list = a;
                        @this.save($("#years_code").val());
                    } else {
                        console.log('reject');
                    }
                });
            }
        }
    </script>
@endpush
