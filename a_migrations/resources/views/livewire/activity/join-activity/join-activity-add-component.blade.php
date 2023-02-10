<div>
   <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
        <thead>
            <tr class="text-center">
                <th class="col-1">ลำดับ</th>
                <th class="col-2">ชื่อ-นามสกุล</th>
                <th class="col-2">มา/ขาด/ทดแทน</th>
                <th class="col-2">ชื่อทดแทน</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-1">1</td>
                <td class="col-2">นาย A</td>
                <td class="col-2">{!! Form::select('type_id' ,$type_select, $type_id,
                    ['class' => 'form-control', 'id' => 'type_id']) !!}</td>
                <td class="col-2">{{ Form::text('phone', null, [
                        'wire:model' => 'phone',
                        'id' => 'phone',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'placeholder' => 'รายชื่อทดแทน',
                    ]) }}</td>
            </tr>
            <tr>
                <td class="col-1">2</td>
                <td class="col-2">นาย B</td>
                <td class="col-2">{!! Form::select('type_id' ,$type_select, $type_id,
                    ['class' => 'form-control', 'id' => 'type_id1']) !!}</td>
                <td class="col-2">{{ Form::text('phone', null, [
                        'wire:model' => 'phone',
                        'id' => 'phone',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'placeholder' => 'รายชื่อทดแทน',
                    ]) }}</td>
            </tr>
            <tr>
                <td class="col-1">3</td>
                <td class="col-2">นาย A</td>
                <td class="col-2">{!! Form::select('type_id' ,$type_select, $type_id,
                    ['class' => 'form-control', 'id' => 'type_id2']) !!}</td>
                <td class="col-2">{{ Form::text('phone', null, [
                        'wire:model' => 'phone',
                        'id' => 'phone',
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'placeholder' => 'รายชื่อทดแทน',
                    ]) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center">
                <button type="button" wire:click='submit()'class="btn btn-primary">บันทึกข้อมูล</button>
                <button type="button" wire:click='redirect_to()' class="btn btn-default btn-outline">ยกเลิก</button>
    </div>
</div>
