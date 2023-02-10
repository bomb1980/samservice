<div>
    <div class="row">


        <div class="col-md-3" style="display: flex; align-items: center; gap: 20px;">

            <span>ปีงบประมาณ</span>
            {{ Form::select('budgetyear', $fiscalyear_select, NULL, ['class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) }}

        </div>
    </div>

</div>
@push('js')
    <script>
        document.addEventListener('livewire:load', function() {

            $(".select2").select2()
                .on('change', function(e) {

                    let name = $(this).attr('name');

                    if (name == 'budgetyear') {

                        let route = '{{ route( $redirect_route, ['id' => 'ddddddddddddd']) }}';

                        let redirect = route.replace("ddddddddddddd", $(this).val());

                        window.location = redirect;
                    }

                });

            window.livewire.on('loadJquery', () => {

                $(".month-picker").datepicker({
                    format: "mm/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                });

                $(".date-picker").datepicker({
                    format: "dd/mm/yyyy",

                    autoclose: true
                }).on('change', function(e) {

                    let name = $(this).attr('data-name');

                    @this.set(name, $(this).val());

                });
            });
        });

        function setValue(name, val) {
            @this.set(name, val);
        }
        Livewire.on('popup', () => {
            swal({
                    title: "บันทึกข้อมูลเรียบร้อย",
                    type: "success",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.reload();
                        //window.livewire.emit('redirect-to');
                    }
                });
        });

        function submit() {
            swal({
                title: 'ยืนยันการบันทึกข้อมูล ได้รับงบประมาณ ?',
                icon: 'close',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#00BCD4',
                cancelButtonColor: '#DD6B55'
            }, function(isConfirm) {
                if (isConfirm) {
                    @this.submit();
                }
            });
        }
    </script>
@endpush
