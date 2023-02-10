<div>
    <div class="col-lg-12">
        <div class="panel-body">
            {!! Form::open(['wire:submit.prevent'=> 'submit()', 'autocomplete'=>'off',
            'class'=>'fv-form form-horizontal fv-form-bootstrap4']) !!}
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ชื่อ job : </label>
                <div class="col-md-7">
                    {!! Form::text('job_name', null,
                    ['wire:model'=>'job_name','id'=>'job_name','class' => 'form-control'
                    ,'autocomplete'=>'off','maxlength' => 100,'placeholder'=>'กรุณากรอกระดับตำแหน่ง']) !!}
                    @error('job_name')
                    <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">ตัวเลือกตั้ง job: </label>
                <div class="col-md-7">
                    <div class="col-md-7">
                        <input type="radio" wire:click="checkjobtype(1)" name="checkjobtype_rd"
                            {{$job_type==1?"checked":""}}>
                        <label class="col-md-7 form-control-label text-left">Run รายวัน </label>
                        @if ($job_type==1)
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">วัน:</label>
                                <div class="col-md-7">
                                    {!! Form::select('job_week' ,$dayname_select, null,
                                    ['wire:model' => 'job_week','class' => 'form-control', 'id' => 'job_week',
                                    'placeholder' => 'เลือกวัน']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">เวลา:</label>
                                <div class="col-md-7">
                                    {!! Form::select('job_hour' ,$time_hour_select, null,
                                    ['wire:model' => 'job_hour','class' => 'form-control', 'id' => 'job_hour',
                                    'placeholder' => 'เลือกเวลา']) !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <input type="radio" wire:click="checkjobtype(2)" name="checkjobtype_rd"
                            {{$job_type==2?"checked":""}}>
                        <label class="col-md-7 form-control-label text-left">Run รายเดือน</label>
                        @if ($job_type==2)
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">วันที่:</label>
                                <div class="col-md-7">
                                    {!! Form::select('daynumber' ,$daynumber_select, null,
                                    ['wire:model' => 'daynumber','class' => 'form-control', 'id' => 'daynumber',
                                    'placeholder' => 'เลือกวัน']) !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <input type="radio" wire:click="checkjobtype(3)" name="checkjobtype_rd"
                            {{$job_type==3?"checked":""}}>
                        <label class="col-md-7 form-control-label text-left">Run ครั้งเดียว</label>
                        @if ($job_type==3)
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{ Form::label('firstjob', 'วันที่', ['class' => 'col-3 col-form-label']) }}
                                {!! Form::text('firstjob', $firstjob, ['wire:model' => 'firstjob', 'id' => 'firstjob',
                                'class' => 'form-control col-7', 'data-provide' => 'datepicker', 'data-date-language' =>
                                'th-th']) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="reset" wire:click='thisReset()' class="btn btn-default btn-outline">ยกเลิก</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        Livewire.on('addemit', () => {
            $("#firstjob").datepicker({}).on('changeDate', function() {
                @this.set('firstjob', $(this).val());
            }).keydown(function(event) {
                return false;
            });
        })
    }
</script>

@push('js')
<script>
    $(document).ready(function(){
        $("#firstjob").datepicker({}).on('changeDate', function() {
            @this.set('firstjob', $(this).val());
        }).keydown(function(event) {
            return false;
        });
    });
</script>
@endpush
