<div>
    <div class="row row-lg">
        <div class="col-md-12">
            <div class="form-group row">
                <label class="col-md-1 form-control-label text-right">กลุ่มหลักสูตร </label>
                <div class="col-md-3">
                    {!!
                    Form::select('courseno', $coursenoSelect, null
                    ,['class' => 'form-control', 'id' => 'courseno'
                    ,'placeholder' => 'กรุณาเลือก กลุ่มหลักสูตร'
                    ,'onchange' => 'callAjax(this.value)'])
                    !!}
                </div>
                <label class="col-md-1 form-control-label text-right">กลุ่มสาขาอาชีพ </label>
                <div class="col-md-3">
                    <select name="carreerno" id="carreerno" class="form-control" onchange="change_data()"></select>
                </div>
            </div>
            <div class="page-header-actions">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-primary btn-md float-right icon wb-plus" onclick="create_data()">เพิ่มคอร์สหลักสูตร</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ลำดับ</th>
                        <th class="text-center">ชื่อกลุ่มหลักสูตร</th>
                        <th class="text-center">ชื่อกลุ่มอาชีพ</th>
                        <th class="col-2 text-center">รหัส</th>
                        <th class="text-center">ชื่อคอร์สหลักสูตร</th>
                        <th class="col-1">แก้ไข</th>
                        <th class="col-1">ลบ</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

