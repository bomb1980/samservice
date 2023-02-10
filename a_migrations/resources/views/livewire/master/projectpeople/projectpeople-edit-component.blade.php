<div>
    <div class="row" data-plugin="matchHeight" data-by-row="true">
        <div class="col-lg-12">
            <div class="panel-body text-center">
                {!! Form::open(['wire:submit.prevent' => 'submit()', 'autocomplete' => 'off', 'class' =>
                'form-horizontal fv-form fv-form-bootstrap4', 'id' => 'exampleStandardForm']) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="cardTab1" role="tabpanel">
                        <div class="row form-group">
                            <div class="col-md-2 text-left">
                                <label class='form-control-label grey-800'>รหัสบัตรประชาชน</label>
                                {!! Form::text('peoid', null, [
                                'wire:model' => 'peoid',
                                'id' => 'peoid',
                                'class' => 'form-control
                                form-control-success',
                                'maxlength' => 13,
                                ]) !!}
                                @error('peoid')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1 text-left"></div>
                            <div class="col-md-2 text-left">
                                <label class='form-control-label grey-800'>ชื่อ</label>
                                {!! Form::text('peoname', null, [
                                'wire:model' => 'peoname',
                                'id' => 'peoname',
                                'class' => 'form-control
                                form-control-success',
                                ]) !!}
                                @error('peoname')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1 text-left"></div>
                            <div class="col-md-2 text-left">
                                <label class='form-control-label grey-800'>นามสกุล</label>
                                {!! Form::text('peosurname', null, [
                                'wire:model' => 'peosurname',
                                'id' => 'peosurname',
                                'class' => 'form-control
                                form-control-success',
                                ]) !!}
                                @error('peosurname')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2 hidden-sm-down">
                                <div style=" position:absolute">
                                    @error('pathfilepeoname_new')
                                    <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    <input type="file" wire:model="pathfilepeoname_new" id="getimage" class="btn-secondary" accept="image/*">
                                    <img id="preview-image" style="height: 200px;width: 300px;" wire:ignore
                                    @if ($pathfilepeoname!='')
                                        src="/storage{{ $pathfilepeoname }}"
                                    @else
                                        src="https://www.bedrockcity.com/content/images/thumbs/default-image_550.png"
                                    @endif)
                                        alt="preview image">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 text-left">
                                <label class='form-control-label grey-800'>ว/ด/ป เกิด</label>
                                {!! Form::text('peobirthdate', $peobirthdate, ['wire:model' => 'peobirthdate', 'id' =>
                                'peobirthdate', 'class' => 'form-control', 'data-provide' => 'datepicker',
                                'data-date-language' => 'th-th']) !!}
                                @error('peobirthdate')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1 text-left"></div>
                            <div class="col-md-2 text-left">
                                {{-- <label class='form-control-label grey-800'>นามสกุล</label> --}}
                                <label class='form-control-label grey-800'>การศึกษา</label>
                                {!! Form::text('peoeducation', null, [
                                'wire:model' => 'peoeducation',
                                'id' => 'peoeducation',
                                'class' => 'form-control
                                form-control-success',
                                ]) !!}
                                @error('peoeducation')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-1 text-left"></div>
                            <div class="col-md-2 text-left">
                                <label class='form-control-label grey-800'>สถานะผู้เข้าร่วมโครงการ</label>
                                {!! Form::select('peostatusname', $peostatusname_select, $peostatus, ['wire:change' =>
                                'changePeoStatus($event.target.value)', 'class' => 'form-control', 'id' =>
                                'peostatusname']) !!}
                                @error('peostatusname')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ตำแหน่งปัจจุบัน</label>
                            {!! Form::text('peoposition', null, [
                            'wire:model' => 'peoposition',
                            'id' => 'peoposition',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoposition')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-1 text-left"></div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>อายุ</label>
                            {!! Form::number('peoage', null, [
                            'wire:model' => 'peoage',
                            'id' => 'peoage',
                            'class' => 'form-control
                            form-control-success text-center',
                            ]) !!}
                            @error('peoage')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ภูมิลำเนา</label>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-1 text-left">
                            <label class='form-control-label grey-800'>เลขที่</label>
                            {!! Form::text('peoaddress_no', null, [
                            'wire:model' => 'peoaddress_no',
                            'id' => 'peoaddress_no',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoaddress_no')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-1 text-left">
                            <label class='form-control-label grey-800'>หมู่ที่</label>
                            {!! Form::text('peoaddress_moo', null, [
                            'wire:model' => 'peoaddress_moo',
                            'id' => 'peoaddress_moo',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoaddress_moo')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ตำบล</label>
                            {!! Form::text('peoaddress_tambon', null, [
                            'wire:model' => 'peoaddress_tambon',
                            'id' => 'peoaddress_tambon',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoaddress_tambon')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>อำเภอ</label>
                            {!! Form::text('peoaddress_aumphur', null, [
                            'wire:model' => 'peoaddress_aumphur',
                            'id' => 'peoaddress_aumphur',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoaddress_aumphur')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>จังหวัด</label>
                            {!! Form::text('peoaddress_province', null, [
                            'wire:model' => 'peoaddress_province',
                            'id' => 'peoaddress_province',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoaddress_province')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ไปรษณีย์</label>
                            {!! Form::text('peoaddress_zip', null, [
                            'wire:model' => 'peoaddress_zip',
                            'id' => 'peoaddress_zip',
                            'class' => 'form-control
                            form-control-success',
                            'maxlength' => 5,
                            ]) !!}
                            @error('peoaddress_zip')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-4 text-left">
                            {{ Form::checkbox('peoaddress_used', false, false, ['wire:model' => 'peoaddress_used']) }}
                            <label class='form-control-label grey-800'>ที่อยู่ปัจจุบันที่สามารถติดต่อได้-ใช้เป็นที่อยู่เดียวกันกับภูมิลำเนา</label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-1 text-left">
                            <label class='form-control-label grey-800'>เลขที่</label>
                            {!! Form::text('peocurlecaddress_no', null, [
                            'wire:model' => 'peocurlecaddress_no',
                            'id' => 'peocurlecaddress_no',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peocurlecaddress_no')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-1 text-left">
                            <label class='form-control-label grey-800'>หมู่ที่</label>
                            {!! Form::text('peocurlecaddress_moo', null, [
                            'wire:model' => 'peocurlecaddress_moo',
                            'id' => 'peocurlecaddress_moo',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peocurlecaddress_moo')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ตำบล</label>
                            {!! Form::text('peocurlecaddress_tambon', null, [
                            'wire:model' => 'peocurlecaddress_tambon',
                            'id' => 'peocurlecaddress_tambon',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peocurlecaddress_tambon')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>อำเภอ</label>
                            {!! Form::text('peocurlecaddress_aumphur', null, [
                            'wire:model' => 'peocurlecaddress_aumphur',
                            'id' => 'peocurlecaddress_aumphur',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peocurlecaddress_aumphur')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>จังหวัด</label>
                            {!! Form::text('peocurlecaddress_province', null, [
                            'wire:model' => 'peocurlecaddress_province',
                            'id' => 'peocurlecaddress_province',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peocurlecaddress_province')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>ไปรษณีย์</label>
                            {!! Form::text('peocurlecaddress_zip', null, [
                            'wire:model' => 'peocurlecaddress_zip',
                            'id' => 'peocurlecaddress_zip',
                            'class' => 'form-control
                            form-control-success',
                            'maxlength' => 5,
                            ]) !!}
                            @error('peocurlecaddress_zip')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                        </div>
                        <div class="col-md-2 text-left">
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>โทรศัพท์</label>
                            {!! Form::text('peolectel', null, [
                            'wire:model' => 'peolectel',
                            'id' => 'peolectel',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peolectel')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>โทรสาร</label>
                            {!! Form::text('peolecfax', null, [
                            'wire:model' => 'peolecfax',
                            'id' => 'peolecfax',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peolecfax')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-2 text-left">
                            <label class='form-control-label grey-800'>โทรศัพท์มือถือ</label>
                            {!! Form::text('peolecmobile', null, [
                            'wire:model' => 'peolecmobile',
                            'id' => 'peolecmobile',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peolecmobile')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 text-left">
                            <label class='form-control-label grey-800'>Email</label>
                            {!! Form::text('peolecemail', null, [
                            'wire:model' => 'peolecemail',
                            'id' => 'peolecemail',
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peolecemail')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 text-left">
                            <label class='form-control-label grey-800'>ประวัติการศึกษา</label>
                            {!! Form::textarea('peoleceducation', null, [
                            'wire:model' => 'peoleceducation',
                            'id' => 'peoleceducation',
                            'rows' => 3,
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peoleceducation')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 text-left">
                            <label class='form-control-label grey-800'>ประสบการณ์อบรม</label>
                            {!! Form::textarea('peolecexperience', null, [
                            'wire:model' => 'peolecexperience',
                            'id' => 'peolecexperience',
                            'rows' => 3,
                            'class' => 'form-control
                            form-control-success',
                            ]) !!}
                            @error('peolecexperience')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="hidden-sm-up form-group">
                        @error('pathfilepeoname_new')
                        <label class="text-danger">{{ $message }}</label>
                        @enderror
                        <input type="file" wire:model="pathfilepeoname_new" id="getimage" class="btn-secondary col-md-12">
                        <img id="preview-image" style="width: 100%;"  accept="image/*" wire:ignore
                        @if ($pathfilepeoname!='')
                            src="/storage{{ $pathfilepeoname }}"
                        @else
                            src="https://www.bedrockcity.com/content/images/thumbs/default-image_550.png"
                        @endif)
                            alt="preview image">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="validateButton2">ยืนยัน</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>
@push('js')
<script>
    $(document).ready(function () {
        $("#peobirthdate").datepicker({
            orientation: "bottom"
        }).on('changeDate', function () {
            @this.set('peobirthdate', $(this).val());
        }).keydown(function (event) {
            return false;
        });
    });

    $('#getimage').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

</script>
@endpush
