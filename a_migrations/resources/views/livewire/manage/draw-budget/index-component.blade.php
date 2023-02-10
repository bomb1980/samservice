<div>
    <div class = "row mb-4">
        <div class = "col-md-2">
            {!! Form::select('fiscalyear_code', ['2566','2565'], null, ['onchange' => 'setValue("fiscalyear_code",event.target.value)', 'class' => 'form-control select2', 'placeholder' => '--เลือกปีงบประมาณ--']) !!}
        </div>
    </div>
    <form class="form-horizontal">
        <div class="form-group row">
            <div class="col-md-2">
                <label class="form-control-label">คำขอจ้างงาน</label>
                <input type="text" class="form-control text-right" name="name" value="16,200,000.00" disabled="">
            </div>
            <div class="col-md-2">
                <label class="form-control-label">คำขออบรม</label>
                <input type="text" class="form-control text-right" name="name" value="20,000,000.00" disabled="">
            </div>
            <div class="col-md-2">
                <label class="form-control-label">รวมคำขอ</label>
                <input type="text" class="form-control text-right" name="name" value="18,000,000.00" disabled="">
            </div>
            <div class="col-md-2">
                <label class="form-control-label">เสนองบ</label>
                <input type="text" class="form-control text-right" name="name" value="18,000,000.00" disabled="">
            </div>
            <div class="col-md-2">
                <label class="form-control-label">ได้รับงบ</label>
                <input type="text" class="form-control text-right" name="name" value="18,000,000.00" disabled="">
            </div>
        </div>
    </form>
    <table class="table table-bordered table-hover table-striped w-full dataTable" id="Datatables">
        <thead>
            <tr>
                <th class="text-center" rowspan="2">งวดที่</th>
                <th class="text-center" rowspan="2">เงินงบประมาณ</th>
                <th class="text-center" rowspan="2">รับโอน</th>
                <th class="text-center" rowspan="2">รอโอน</th>
                <th class="text-center bg-pink-100" colspan="3">ส่วนกลาง</th>
                <th class="text-center bg-purple-100" colspan="4">ภูมิภาค</th>
                <th class="text-center" rowspan="2">เบิกจ่าย</th>
                <th class="text-center" rowspan="2">คงเหลือ</th>
            </tr>
            <tr>
                <th class="text-center bg-pink-100">ค่าบริหารส่วนกลาง</th>
                <th class="text-center bg-pink-100">เบิกจ่าย</th>
                <th class="text-center bg-pink-100">คงเหลือ</th>
                <th class="text-center bg-purple-100">จัดสรร</th>
                <th class="text-center bg-purple-100">รับโอน</th>
                <th class="text-center bg-purple-100">เบิกจ่าย</th>
                <th class="text-center bg-purple-100">โอนคืน</th>
                {{-- <th class="text-center bg-purple-100">คงเหลือ</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="text-right">9,000,000.00</td>
                <td class="text-right">5,000,000.00</td>
                <td class="text-right">4,000,000.00</td>
                <td class="text-right">1,000,000.00</td>
                <td class="text-right">500,000.00</td>
                <td class="text-right">500,000.00</td>
                <td class="text-right">4,000,000.00</td>
                <td class="text-right">4,000,000.00</td>
                <td class="text-right">3,000,000.00</td>
                <td class="text-right">1,000,000.00</td>
                <td class="text-right">3,000,000.00</td>
                <td class="text-right">1,000,000.00</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="text-right">9,000,000.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
                <td class="text-right">0.00</td>
            </tr>
        </tbody>
    </table>
    {{-- <br>
    <div class = "text-center">
        <button class="btn btn-primary">บันทึก</button>
        <button class="btn btn-default btn-outline">ยกเลิก</button>
    </div> --}}
</div>


