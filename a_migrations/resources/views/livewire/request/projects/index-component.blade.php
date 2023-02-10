<div>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-2">

            {{ Form::select('years_code', $years_list, $years_code, [
                'id' => 'years_code',
                'onchange' => 'setYear()',
                'class' => 'form-control select2',
                'placeholder' => '--เลือกปีงบประมาณ--',
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
        <div class="col-md-2 input-group form-group">
            <input type="search" class="form-control" id="serachbox" oninput="setSearch()"
                placeholder="คำค้น (Keyword)" />
            <button type="button" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div id="onRoom" onRoom="รวม" class="row">

        <div class="col-md-1"></div>
        <div class="col-md-2">
            <div data-click-state=0 name="selecter" id="select_1" onclick="onclick_select('#select_1', '#2F3644', 'selecter_1_text', 'บันทึกแบบร่าง')" class="", style="border-radius: 25px; margin-bottom: 30px">
                <div class="card-block text-center">
                    <h1 class="card-title"><img src="{{ asset('assets/images/9.png') }}" width="60px;" alt="">
                    </h1>
                    <p glob_name="selecter_text" name="selecter_1_text" class="h4 font-weight-bold", style="color: black;">บันทึกร่าง</p>
                    <p glob_name="selecter_text" name="selecter_1_text" class="h5 font-weight-bold", style="color: black;"><span id="selecC1"></span> รายการ</p>
                    <p glob_name="selecter_text" name="selecter_1_text" class="h5 font-weight-bold", style="color: black;">จำนวนเงิน <span id="selecS1"></span></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
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
        <div class="col-md-2">
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
        <div class="col-md-2">
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
        <div class="col-md-2">
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
    <div name="selector" class="col-10 offset-1 row form-group" id="alert", style="background-color: rgb(196, 211, 255);border-radius: 15px; padding-top:7px">
        <div class="col-md-4 pt-2">
            <p><strong>สำนักงานจังหวัด : </strong><span id="division">{{$division}}</span></p>
        </div>
        <div class="col-md-4 pt-2">
            <p style="margin-left: 20%"><strong>ช่วงวันที่รวบรวมคำขอ : </strong> <span id="time_length">-</span></p>
        </div>
        <div class="col-md-4 pt-2 text-right">
            <p><strong>เหลือระยะเวลาอีก : </strong><span id="left_time_length">-</span></p>
        </div>
    </div>
    <div class="table-responsive" id="parenTable">
        <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
            <thead>
                <tr>
                    <th class="text-center"><input type="checkbox" name="checkedAll" id="checkedAll"/></th>
                    <th class="text-center">ลำดับ</th>
                    <th class="text-center">ปีที่</th>
                    <th class="text-center">เลขที่คำขอ</th>
                    <th class="text-center">ประเภทกิจกรรม</th>
                    <th class="text-center">อำเภอ</th>
                    <th class="text-center">ตำบล</th>
                    <th class="text-center">หมู่บ้าน</th>
                    <th class="text-center">ระยะเวลาดำเนินการ</th>
                    <th class="text-center">จำนวนวัน</th>
                    <th class="text-center">เป้าหมาย(คน)</th>
                    <th class="text-center">รวมค่าใช้จ่าย</th>
                    <th class="text-center">สถานะใบคำขอ</th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    {{-- <th class="text-center" id='del_switch'>กดกกดกดดกกกดกหกหดฟ</th> --}}

                </tr>

            </thead>
        </table>
    </div>
    <div style="text-align: center;" id="select_submit">
        <div class="btn btn-primary" onclick="send_submit()">
            ส่งพิจารณา
        </div>
    </div>
    <a id="exelExport" href="{{ route('request.exel.request2_3.index', ['arr'=>'pop']) }}", style="visibility: hidden">Exel</a>
</div>

@push('js')
    <script>
        $('.select2').select2();
        var del_visibility = true;
        $(document).ready(function() {
            console.log("ready");
            setSelectHover();
            setInitialSelect();
            call_datatable('');
            setUp();
            setYear();

            Livewire.on('emits', () => {
                $('.select2').select2();
                setUp();
                call_datatable('');
            });
            Livewire.on('submit', () => {
                $('.select2').select2();
                setUp();
                call_datatable('');
                swal('', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success');

                $("#onRoom").attr('onRoom', 'รอพิจารณา')

                setYear();
                onclick_select('#select_2', '#F79009', 'selecter_2_text', 'รอพิจารณา')
            });

            @if (session()->get('pending_room') != null)
                console.log("pending room");
                swal('', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success');

                $("#onRoom").attr('onRoom', 'รอพิจารณา')

                // setYear();
                onclick_select('#select_2', '#F79009', 'selecter_2_text', 'รอพิจารณา')
            @endif

            @if (session()->get('message_edit'))
                swal('', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success');
            @endif
            @if (session()->get('message_delete1'))
                swal('', 'ลบข้อมูล เรียบร้อยแล้ว', 'success');
            @endif

            @if (session()->get('message_delete') != null)
                swal('', 'ลบข้อมูล เรียบร้อยแล้ว', 'success');

                $("#onRoom").attr('onRoom', 'บันทึกแบบร่าง')

                // setYear();
                onclick_select('#select_1', '#2F3644', 'selecter_1_text', 'บันทึกแบบร่าง')
            @endif

        });
        function setUp(){
            if(@this.initial == 5){
                helper_open_checkboxAndDelField(true);
                // helper_set_select('#select_1', '#2F3644', 'selecter_1_text');
                helper_set_select('#select_5', '#4F8FEF', 'selecter_5_text');

                $("#onRoom").attr('onRoom', 'รวม')
            }else{//@this.initial == 2
                helper_open_checkboxAndDelField(false);
                helper_set_select('#select_2', '#F79009', 'selecter_2_text');

                $("#onRoom").attr('onRoom', 'รอพิจารณา')
            }
        }
        //jquery selecter
        function onclick_select(id, class_name, name_text, selecter){
            $("#onRoom").attr('onRoom', selecter);
            if(id != '#select_1' && id != '#select_5'){
                helper_open_checkboxAndDelField(false);
            }
            else{
                helper_open_checkboxAndDelField(true);
            }

            setSearch();

            if($(id).attr('data-click-state') != 1){
                helper_set_select(id, class_name, name_text);
            }
        }

        function setYear(){
            if( @this.years_list[$("#years_code").val()] == undefined || @this.years_list[$("#years_code").val()]== null ){
                $("#time_length").text('-');
                $("#left_time_length").text('-');

                $("#selecC1").text(@this.selecterC1['all']);
                $("#selecS1").text(@this.selecterS1['all']);

                $("#selecC2").text(@this.selecterC2['all']);
                $("#selecS2").text(@this.selecterS2['all']);

                $("#selecC3").text(@this.selecterC3['all']);
                $("#selecS3").text(@this.selecterS3['all']);

                $("#selecC4").text(@this.selecterC4['all']);
                $("#selecS4").text(@this.selecterS4['all']);

                $("#selecC5").text(@this.selecterC5['all']);
                $("#selecS5").text(@this.selecterS5['all']);
            }else{
                $("#time_length").text(@this.fiscalyear_list[@this.years_list[$("#years_code").val()]] ?? '-');

                let lefOf = @this.left_fiscalyear_list[@this.years_list[$("#years_code").val()]];
                if(typeof(lefOf) == 'string'){
                    $("#left_time_length").text(lefOf);
                }
                else if(typeof(lefOf) == 'number'){
                    $("#left_time_length").text(lefOf+" วัน");
                }else{
                    $("#left_time_length").text("-");
                }

                $("#selecC1").text(@this.selecterC1[@this.years_list[$("#years_code").val()]]);
                $("#selecS1").text(@this.selecterS1[@this.years_list[$("#years_code").val()]]);

                $("#selecC2").text(@this.selecterC2[@this.years_list[$("#years_code").val()]]);
                $("#selecS2").text(@this.selecterS2[@this.years_list[$("#years_code").val()]]);

                $("#selecC3").text(@this.selecterC3[@this.years_list[$("#years_code").val()]]);
                $("#selecS3").text(@this.selecterS3[@this.years_list[$("#years_code").val()]]);

                $("#selecC4").text(@this.selecterC4[@this.years_list[$("#years_code").val()]]);
                $("#selecS4").text(@this.selecterS4[@this.years_list[$("#years_code").val()]]);

                $("#selecC5").text(@this.selecterC5[@this.years_list[$("#years_code").val()]]);
                $("#selecS5").text(@this.selecterS5[@this.years_list[$("#years_code").val()]]);
            }
            setSearch();
            return false;
        }

        function setSearch() {
            try {
                table.search( $("#serachbox").val() ?? '' );
                table.columns(2).search(@this.years_list[$("#years_code").val()] ?? '')
                table.columns(4).search($("#acttype_code").val() ?? '')

                if($("#onRoom").attr('onRoom') != "รวม"){
                    var onroom = $("#onRoom").attr('onRoom');

                    if(onroom =='บันทึกแบบร่าง'){
                        table.columns(12).search('ส่งคำขอกลับ|'+onroom,true,false);
                    }
                    else{
                        table.columns(12).search('^' + onroom + '$', true, false );
                    }
                }else{
                    table.columns(12).search('');
                }

                table.draw();
            } catch (error) {
                table.search( $("#serachbox").val() ?? '' );
                table.draw();
            }

            return false;
        }

        var table;
        function call_datatable(search) {
            table = $('#Datatables').DataTable({
                processing: true,
                dom: 'rtp<"bottom"i>',
                ajax: {
                    url: '{{ route('api.request.projects.list') }}',
                    type: 'GET',
                    data: {
                        token: '{{ csrf_token() }}',
                        division_id: @this.division_id,
                    },
                    headers: {
                        'Authorization': 'Bearer {{ system_key() }}'
                    }
                },
                columnDefs: [
                    {
                        searchable: false,
                        orderable: false,
                        targets: 1,
                    },
                ],
                order: [[1, 'asc']],
                columns: [
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        className: "text-center",
                        orderable: false
                    },
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
                    {
                        data: 'del',
                        name: 'del',
                        className: "text-center",
                        orderable: false,
                        visible: del_visibility
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

                table.cells(null, 1, { search: 'applied', order: 'applied' }).every(function (cell) {
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
                    // @this.del(id, $("#years_code").val());
                    $('#delete_form' + id).submit();
                } else {
                    console.log('reject delete');
                }
            });
        }

        function exel(){
            let a = [];
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('.checkSingle', rows).each(function () {
                if($(this).prop("checked") == true){
                    a.push(this.value);;
                }
            });
            var pop = $("#exelExport").attr("href");
            pop = pop.split("/");
            var last_element = pop.length - 1;
            a = a.join('_');
            pop[last_element] = a;
            pop = pop.join('/');
            $("#exelExport").attr("href",pop);
            $('#exelExport')[0].click();
        }

        function send_submit(id) {
            let a = [];
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('.checkSingle', rows).each(function () {
                if($(this).prop("checked") == true){
                    a.push(this.value);;
                }
            });

            if(a.length == 0){
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
            }
            else{
                swal({
                    title: 'ยืนยันส่งคำขอพิจารณาใช่หรือไม่',
                    icon: 'close',
                    html: true,
                    text: "<p onclick='exel()', style='cursor:pointer; color:blue;'>โหลดไฟล์ exel คลิกที่นี้</p>",
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




        function helper_open_checkboxAndDelField(open){
            if(open == true){
                $( "#checkedAll" ).prop( "disabled", false );
                $('#del_switch').show();
                del_visibility = true;
                try {
                    table.columns(14).visible( del_visibility );
                }
                catch(err) {
                }
            }else{
                $( "#checkedAll" ).prop( "disabled", true );
                $('#del_switch').hide();
                del_visibility = false;
                try {
                    table.columns(14).visible( del_visibility );
                }
                catch(err) {
                }
            }
        }
        function helper_set_select(id, color, name_text){
            //reset every selecter to defualt
            $("[name='selecter']").attr('data-click-state', 0)
            setInitialSelect();
            //
            $(id).attr('data-click-state', 1)
            $(id).css('background-color', color);
            // $(id).css('border', "")
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
