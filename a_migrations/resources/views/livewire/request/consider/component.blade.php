<div>
    <div class="row">
        <div class="col-md-2 offset-md-1">
            {{-- <select class="form-control form-group select2">
                <option value="">--เลือกปีงบประมาณ--</option>
            </select> --}}
            {{ Form::select('years_code', $years_list, $years_code, [
                'id' => 'years_code',
                'onchange' => 'setYear()',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกปีงบประมาณ--',
            ]) }}

        </div>
        <div class="col-md-2">
            {{ Form::select('divi_code', $divi_list, $divi_code, [
                'id' => 'divi_code',
                'onchange' => 'setSearch()',
                'class' => 'form-control select2',
                'placeholder' => '--หน่วยงาน--',
            ]) }}

        </div>
        <div class="col-md-2">
            {{ Form::select('acttype_code', $acttype_list, $acttype_code, [
                'id' => 'acttype_code',
                'onchange' => 'setSearch()',
                'class' => 'form-control select2',
                'placeholder' => '--ประเภทกิจกรรม--',
            ]) }}
        </div>
        <div class="col-md-2 offset-md-2 input-group form-group">
            <input type="search" class="form-control" id="serachbox" oninput="setSearch()"
                placeholder="คำค้น (Keyword)" />
            <button type="button" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div id="onRoom" onRoom="รวม" class="row">
        {{-- <div class="col-2 text-center bg-green-100">
            <p><strong>ช่วงวันที่รวบรวมคำขอ</strong></p>
            <p>01/10/2565 - 30/03/2566</p>
            <p>เหลือระยะเวลาอีก</p>
            <p>60 วัน</p>
        </div> --}}
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md">
                    <div data-click-state=0 name="selecter" id="select_2" onclick="onclick_select('#select_2', '#F79009', 'selecter_2_text', 'รอพิจารณา')" class="",  style="border-radius: 25px;">
                        <div class="card-block text-center">
                            <h1 class="card-title"><img src="{{ asset('assets/images/2.png') }}" width="60px;" alt="">
                            </h1>
                            <p glob_name="selecter_text" name="selecter_2_text" class="h4 font-weight-bold", style="color: black;">รอพิจารณา</p>
                            <p glob_name="selecter_text" name="selecter_2_text" class="h5 font-weight-bold", style="color: black;"><span id="selecC2"></span> รายการ</p>
                            <p glob_name="selecter_text" name="selecter_2_text" class="h5 font-weight-bold", style="color: black;">จำนวนเงิน <span id="selecS2"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div data-click-state=0 name="selecter" id="select_3" onclick="onclick_select('#select_3', '#27AE60', 'selecter_3_text', 'ผ่านการพิจารณา')" class="",  style="border-radius: 25px;">
                        <div class="card-block text-center">
                            <h1 class="card-title"><img src="{{ asset('assets/images/3.png') }}" width="60px;" alt="">
                            </h1>
                            <p glob_name="selecter_text" name="selecter_3_text" class="h4 font-weight-bold", style="color: black;">ผ่านการพิจารณา</p>
                            <p glob_name="selecter_text" name="selecter_3_text" class="h5 font-weight-bold", style="color: black;"><span id="selecC3"></span> รายการ</p>
                            <p glob_name="selecter_text" name="selecter_3_text" class="h5 font-weight-bold", style="color: black;">จำนวนเงิน <span id="selecS3"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div data-click-state=0 name="selecter" id="select_4" onclick="onclick_select('#select_4', '#F04438', 'selecter_4_text','ไม่ผ่านการพิจารณา')" class="",  style="border-radius: 25px;">
                        <div class="card-block text-center">
                            <h1 class="card-title"><img src="{{ asset('assets/images/8.png') }}" width="60px;" alt="">
                            </h1>
                            <p glob_name="selecter_text" name="selecter_4_text" class="h4 font-weight-bold", style="color: black;">ไม่ผ่านการพิจารณา</p>
                            <p glob_name="selecter_text" name="selecter_4_text" class="h5 font-weight-bold", style="color: black;"><span id="selecC4"></span> รายการ</p>
                            <p glob_name="selecter_text" name="selecter_4_text" class="h5 font-weight-bold", style="color: black;">จำนวนเงิน <span id="selecS4"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div data-click-state=0 name="selecter" id="select_5" onclick="onclick_select('#select_5', '#4F8FEF', 'selecter_5_text', 'รวม')" class="",  style="border-radius: 25px;">
                        <div class="card-block text-center">
                            <h1 class="card-title"><img src="{{ asset('assets/images/7.png') }}" width="60px;" alt="">
                            </h1>
                            <p glob_name="selecter_text" name="selecter_5_text" class="h4 font-weight-bold", style="color: black;">รวม</p>
                            <p glob_name="selecter_text" name="selecter_5_text" class="h5 font-weight-bold", style="color: black;"><span id="selecC5"></span> รายการ</p>
                            <p glob_name="selecter_text" name="selecter_5_text" class="h5 font-weight-bold", style="color: black;">จำนวนเงิน <span id="selecS5"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-10 offset-md-1">
            <div class="table-responsive" id="parenTable">
                <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">ปีที่</th>
                            <th class="text-center">เลขที่คำขอ</th>
                            <th class="text-center">หน่วยงาน</th>
                            <th class="text-center">ประเภทกิจกรรม</th>
                            <th class="text-center">อำเภอ</th>
                            <th class="text-center">ตำบล</th>
                            <th class="text-center">หมู่</th>
                            <th class="text-center">ระยะเวลาดำเนินการ</th>
                            <th class="text-center">จำนวนวัน</th>
                            <th class="text-center">เป้าหมาย(คน)</th>
                            <th class="text-center">รวมค่าใช้จ่าย</th>
                            <th class="text-center">สถานะใบคำขอ</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            setInitialSelect();
            setSelectHover();
            setUp();
            call_datatable('');

            Livewire.on('emits', () => {
                $('.select2').select2();
                setUp();
                call_datatable('');
            });
        });
        function setUp(){
            helper_set_select('#select_5', '#4F8FEF', 'selecter_5_text');

            $("#onRoom").attr('onRoom', 'รวม')

            helper_set_year_all();
        }

        //jquery selecter
        function onclick_select(id, class_name, name_text, selecter){
            $("#onRoom").attr('onRoom', selecter)
            setSearch();
            if($(id).attr('data-click-state') != 1){
                helper_set_select(id, class_name, name_text);
            }
        }

        function setYear(){
            if( @this.years_list[$("#years_code").val()] == '' || @this.years_list[$("#years_code").val()]==null ){
                //
                helper_set_year_all();

                setSearch(true);
            }else{
                //

                $("#selecC2").text(@this.selecterC2[@this.years_list[$("#years_code").val()]]);
                $("#selecS2").text(@this.selecterS2[@this.years_list[$("#years_code").val()]]);

                $("#selecC3").text(@this.selecterC3[@this.years_list[$("#years_code").val()]]);
                $("#selecS3").text(@this.selecterS3[@this.years_list[$("#years_code").val()]]);

                $("#selecC4").text(@this.selecterC4[@this.years_list[$("#years_code").val()]]);
                $("#selecS4").text(@this.selecterS4[@this.years_list[$("#years_code").val()]]);

                $("#selecC5").text(@this.selecterC5[@this.years_list[$("#years_code").val()]]);
                $("#selecS5").text(@this.selecterS5[@this.years_list[$("#years_code").val()]]);
                setSearch(false);
            }
            return false;
        }

        function setSearch(allYear) {
            if(allYear == true){
                table.search( $("#serachbox").val() );
                table.columns(12).search('');
                table.columns(1).search('');
                table.columns(4).search('')
                table.columns(3).search('');

                if($("#onRoom").attr('onRoom') != "รวม"){
                    var onroom = $("#onRoom").attr('onRoom');
                    table.columns(12).search('^' + onroom + '$', true, false );
                }else{
                    table.columns(12).search('');
                }
            }else{
                table.search( $("#serachbox").val() );
                table.columns(1).search(@this.years_list[$("#years_code").val()]);
                table.columns(4).search($("#acttype_code").val())
                table.columns(3).search($("#divi_code").val())

                if($("#onRoom").attr('onRoom') != "รวม"){
                    var onroom = $("#onRoom").attr('onRoom');
                    table.columns(12).search('^' + onroom + '$', true, false );
                }else{
                    table.columns(12).search('');
                }
            }

            table.draw();

            return false;
        }

        var table;
        function call_datatable(search) {
            table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.request.consider.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                order: [[0, 'asc']],
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_year',
                        name: 'req_year',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_number',
                        name: 'req_number',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'division',
                        name: 'division',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'amphur_name',
                        name: 'amphur_name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'tambon_name',
                        name: 'tambon_name',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_moo',
                        name: 'req_moo',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_startmonth_format',
                        name: 'req_startmonth_format',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_numofday',
                        name: 'req_numofday',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_numofpeople',
                        name: 'req_numofpeople',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'req_amount_format',
                        name: 'req_amount_format',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'status_confirm',
                        name: 'status_confirm',
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        className: "text-center",
                        orderable: false
                    },
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
            table.on('order.dt search.dt', function() {
                let i = 1;

                table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).search(search)
            table.draw();

            $('#checkedAll').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('.checkSingle', rows).prop('checked', this.checked);
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



        function helper_set_year_all(){
            $("#selecC2").text(@this.selecterC2["all"]);
            $("#selecS2").text(@this.selecterS2["all"]);

            $("#selecC3").text(@this.selecterC3["all"]);
            $("#selecS3").text(@this.selecterS3["all"]);

            $("#selecC4").text(@this.selecterC4["all"]);
            $("#selecS4").text(@this.selecterS4["all"]);

            $("#selecC5").text(@this.selecterC5["all"]);
            $("#selecS5").text(@this.selecterS5["all"]);
        }

        function helper_set_select(id, color, name_text){
            //reset every selecter to defualt
            $("[name='selecter']").attr('data-click-state', 0)
            setInitialSelect();
            //
            $(id).attr('data-click-state', 1)
            $(id).css('background-color', color);
            $(id).toggleClass( "card card-inverse" )
            $("[name="+name_text+"]").css('color', 'white');
        }

        function setSelectHover(){
            $( "#select_1" ).hover(
                function() {
                    if($( "#select_1" ).attr('data-click-state') == 0){
                        $( this ).addClass( "card card-inverse" );
                        $( this ).css('background-color','rgba(47, 54, 68, .6)');
                        $("[name='selecter_1_text']").css('color', 'white');
                        $( this ).css('cursor','pointer');
                    }
                }, function() {
                    if($( "#select_1" ).attr('data-click-state') == 0){
                        $("[name='selecter_1_text']").css('color', 'black');
                        $( this ).css('background-color','rgba(47, 54, 68, .3)');
                    }else{
                        $( this ).css('background-color','rgba(47, 54, 68)');
                    }
                }
            );
            $( "#select_2" ).hover(
                function() {
                    if($( "#select_2" ).attr('data-click-state') == 0){
                        $( this ).addClass( "card card-inverse" );
                        $( this ).css('background-color','rgba(247, 144, 9, .6)');
                        $("[name='selecter_2_text']").css('color', 'white');
                        $( this ).css('cursor','pointer');
                    }
                }, function() {
                    if($( "#select_2" ).attr('data-click-state') == 0){
                        $("[name='selecter_2_text']").css('color', 'black');
                        $( this ).css('background-color','rgba(247, 144, 9, .3)');
                    }else{
                        $( this ).css('background-color','rgba(247, 144, 9)');
                    }
                }
            );
            $( "#select_3" ).hover(
                function() {
                    if($( "#select_3" ).attr('data-click-state') == 0){
                        $( this ).addClass( "card card-inverse" );
                        $( this ).css('background-color','rgba(39, 174, 96, .6)');
                        $("[name='selecter_3_text']").css('color', 'white');
                        $( this ).css('cursor','pointer');
                    }
                }, function() {
                    if($( "#select_3" ).attr('data-click-state') == 0){
                        $("[name='selecter_3_text']").css('color', 'black');
                        $( this ).css('background-color','rgba(39, 174, 96, .3)');
                    }else{
                        $( this ).css('background-color','rgba(39, 174, 96)');
                    }
                }
            );
            $( "#select_4" ).hover(
                function() {
                    if($( "#select_4" ).attr('data-click-state') == 0){
                        $( this ).addClass( "card card-inverse" );
                        $( this ).css('background-color','rgba(240, 68, 56, .6)');
                        $("[name='selecter_4_text']").css('color', 'white');
                        $( this ).css('cursor','pointer');
                    }
                }, function() {
                    if($( "#select_4" ).attr('data-click-state') == 0){
                        $("[name='selecter_4_text']").css('color', 'black');
                        $( this ).css('background-color','rgba(240, 68, 56, .3)');
                    }else{
                        $( this ).css('background-color','rgba(240, 68, 56)');
                    }
                }
            );
            $( "#select_5" ).hover(
                function() {
                    if($( "#select_5" ).attr('data-click-state') == 0){
                        $( this ).addClass( "card card-inverse" );
                        $( this ).css('background-color','rgba(79, 143, 239, .6)');
                        $("[name='selecter_5_text']").css('color', 'white');
                        $( this ).css('cursor','pointer');
                    }
                }, function() {
                    if($( "#select_5" ).attr('data-click-state') == 0){
                        $("[name='selecter_5_text']").css('color', 'black');
                        $( this ).css('background-color','rgba(79, 143, 239, .3)');
                    }else{
                        $( this ).css('background-color','rgba(79, 143, 239)');
                    }
                }
            );
        }

        function setInitialSelect(){
            $( '#select_1' ).css('background-color','rgba(47, 54, 68, .3)');
            $("[name='selecter_1_text']").css('color', 'black');
            $( '#select_1' ).css('cursor','pointer');

            $( "#select_2" ).css('background-color','rgba(247, 144, 9, .3)');
            $("[name='selecter_2_text']").css('color', 'black');
            $( "#select_2" ).css('cursor','pointer');

            $( "#select_3" ).css('background-color','rgba(39, 174, 96, .3)');
            $("[name='selecter_3_text']").css('color', 'black');
            $( "#select_3" ).css('cursor','pointer');

            $( "#select_4" ).css('background-color','rgba(240, 68, 56, .3)');
            $("[name='selecter_4_text']").css('color', 'black');
            $( "#select_4" ).css('cursor','pointer');

            $( "#select_5" ).css('background-color','rgba(79, 143, 239, .3)');
            $("[name='selecter_5_text']").css('color', 'black');
            $( "#select_5" ).css('cursor','pointer');
        }
    </script>
@endpush
