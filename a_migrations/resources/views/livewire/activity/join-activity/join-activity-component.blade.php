<div>
    <div class="row row-lg">
        <div class="col-md-12">
            <div class="form-group row">
                <label class="col-md-1 form-control-label text-right">ปี <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('years', $years_select, $years, ['class' => 'form-control', 'id' => 'years']) !!}
                    @error('years')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-1 form-control-label text-right">หน่วยงาน <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('division', $division_select, $division, ['class' => 'form-control', 'id' => 'division']) !!}
                    @error('division')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-1 form-control-label text-right">ประเภท <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('project_type', $project_type_select, $project_type, [
                        'class' => 'form-control',
                        'id' => 'project_type',
                    ]) !!}
                    @error('project_type')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-1 form-control-label text-right">โครงการ <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    {!! Form::select('project', $project_select, $project, ['class' => 'form-control', 'id' => 'project']) !!}
                    @error('project')
                        <label class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    {{ link_to(route('activity.join_activity.create'), ' เพิ่ม', [
                        'class' => 'btn
                                        btn-primary btn-md
                                        float-right icon wb-plus',
                    ]) }}
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
        <thead>
            <tr class="text-center">
                <th class="col-1">วันที่</th>
                <th class="col-2">จำนวน</th>
                <th class="col-2">มา</th>
                <th class="col-2">ทดแทน</th>
                <th class="col-1">ขาด</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <th class="col-1">20/11/2565</th>
                <th class="col-2">50</th>
                <th class="col-2">45</th>
                <th class="col-2">0</th>
                <th class="col-1">5</th>
            </tr>
        </tbody>
    </table>
</div>
