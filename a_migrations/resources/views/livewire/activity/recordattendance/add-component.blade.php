<div>
    {!! Form::open([
        'wire:submit.prevent' => 'submit()',
        'autocomplete' => 'off',
        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
    ]) !!}
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ปีงบประมาณ</label>
                <div class="col-md-2">
                    {{ Form::text('act_year', $act_year, [
                        'wire:model' => 'act_year',
                        'id' => 'act_year',
                        'class' => 'form-control',
                        'disabled',
                    ]) }}
                    @error('act_year')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">เลขที่คำขอ</label>
                <div class="col-md-2">
                    {{ Form::text('act_number', $act_number, [
                        'wire:model' => 'act_number',
                        'id' => 'act_number',
                        'class' => 'form-control',
                        'disabled',
                    ]) }}
                    @error('act_number')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
             {{--<hr>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อกิจกรรม <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    {{ Form::text('activity_name', $activity_name, [
                        'wire:model' => 'activity_name',
                        'id' => 'activity_name',
                        'class' => 'form-control',
                        'maxlength' => 400,
                    ]) }}
                    @error('activity_name')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div> --}}
            <hr>

            <div class="row form-group">
                <label class="col-md-3 form-control-label">ช่วงเวลา</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('activity_time_period_start', $activity_time_period_start, [
                            'onchange' => 'changeActTimePerStart(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'activity_time_period_start',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 form-control-label text-center">ถึง</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('activity_time_period_end', $activity_time_period_end, [
                            'onchange' => 'changeActTimePerEnd(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'activity_time_period_end',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 form-control-label">ช่วงรวบรวม</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('collection_allocation_start', $collection_allocation_start, [
                            'onchange' => 'changeAlloStart(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'collection_allocation_start',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 form-control-label text-center">ถึง</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('collection_allocation_end', $collection_allocation_end, [
                            'onchange' => 'changeAlloEnd(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'collection_allocation_end',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 form-control-label">ช่วงจัดสรร</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('collection_period_start', $collection_period_start, [
                            'onchange' => 'changeColPerStart(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'collection_period_startrt',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 form-control-label text-center">ถึง</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('collection_period_end', $collection_period_end, [
                            'onchange' => 'changeColPerEnd(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'collection_period_end',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 form-control-label">ช่วงปรับแผน</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('plan_adjustment_period_start', $plan_adjustment_period_start, [
                            'onchange' => 'changePlanAdjStart(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'plan_adjustment_period_start',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 form-control-label text-center">ถึง</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('plan_adjustment_period_end', $plan_adjustment_period_end, [
                            'onchange' => 'changePlanAdjEnd(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'plan_adjustment_period_end',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-md-3 form-control-label">ช่วงเริ่มกิจกรรม</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('activity_run_period_start', $activity_run_period_start, [
                            'onchange' => 'changeRunPerStart(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'activity_run_period_start',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <label class="col-md-2 form-control-label text-center">ถึง</label>
                <div class="col-md-2 form-group">
                    <div class="input-group">
                        {{ Form::text('activity_run_period_end', $activity_run_period_end, [
                            'onchange' => 'changeRunPerEnd(event.target.value)',
                            'class' => 'form-control datepicker',
                            'id' => 'activity_run_period_end',
                            'autocomplete' => 'close',
                        ]) }}
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="icon wb-calendar" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-md-12 text-center">
                    <button type="button" onclick="submit_click()" class="btn btn-primary">บันทึกข้อมูล</button>
                    {!! link_to(route('activity.recordattendance.index'), 'ยกเลิก', ['class' => 'btn btn-default btn-outline']) !!}
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}

    <script>
        document.addEventListener('livewire:load', function() {
            $(".datepicker").datepicker({
                language: 'th-th',
                format: 'dd/mm/yyyy',
                autoclose: true,
                orientation: "bottom"
            });
        });
    </script>
</div>

@push('js')
    <script>
        $(".datepicker").datepicker({
            language: 'th-th',
            format: 'dd/mm/yyyy',
            autoclose: true,
            orientation: "bottom"
        });

        function changeActTimePerStart(val) {
            @this.set('activity_time_period_start', val);
        }

        function changeActTimePerEnd(val) {
            @this.set('activity_time_period_end', val);
        }

        function changeAlloStart(val) {
            @this.set('collection_allocation_start', val);
        }

        function changeAlloEnd(val) {
            @this.set('collection_allocation_end', val);
        }

        function changeColPerStart(val) {
            @this.set('collection_period_start', val);
        }

        function changeColPerEnd(val) {
            @this.set('collection_period_end', val);
        }

        function changePlanAdjStart(val) {
            @this.set('plan_adjustment_period_start', val);
        }

        function changePlanAdjEnd(val) {
            @this.set('plan_adjustment_period_end', val);
        }

        function changeRunPerStart(val) {
            @this.set('activity_run_period_start', val);
        }

        function changeRunPerEnd(val) {
            @this.set('activity_run_period_end', val);
        }

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
                    @this.submit();
                }
            });
        }
    </script>
@endpush
