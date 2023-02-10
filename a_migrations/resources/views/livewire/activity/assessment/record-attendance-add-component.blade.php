<div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4">ตั้งแต่</label>
        <div class="input-group col-md-2">
            <div class="input-group">
                <input type="text" class="form-control" data-provide="datepicker" wire:model="stdate"
                    data-date-language="th-th" placeholder="วันที่">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </div>
        <label class="form-control-label">ถึง</label>
        <div class="input-group col-md-2">
            <div class="input-group">
                <input type="text" class="form-control" data-provide="datepicker" wire:model="endate"
                    data-date-language="th-th" placeholder="วันที่">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 text-right pr-4"></label>
        <table class="table table-bordered table-hover table-striped dataTable" id="Datatables">
            <thead>
                <tr>
                    <td class="text-left">ชื่อ-สกุล</td>
                    <td class="text-center">มา</td>
                    <td class="text-center">ขาด</td>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($resultReq as $key => $value)
                    <tr>
                        <td>{{ $value->customer_fname }} {{ $value->customer_lname }}</td>
                        <td class="text-center"><input type="radio" name="radio{{ $key }}"></td>
                        <td class="text-center"><input type="radio" name="radio{{ $key }}"></td>
                        <td class="text-center"><input type="radio" name="radio{{ $key }}"></td>
                        <td>{{ Form::text($key, null, ['class' => 'form-control']) }}
                    </tr>
                @endforeach
            </tbody> --}}
            <tbody>

                <tr>
                    <td class="text-left">นาย กำพล บุตรพุ่ม</td>
                    <td class="text-center"><input type="radio" name="radio1"></td>
                    <td class="text-center"><input type="radio" name="radio1"></td>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">นาง สนอง จิระวัฒนผลิน</td>
                    <td class="text-center"><input type="radio" name="radio2"></td>
                    <td class="text-center"><input type="radio" name="radio2"></td>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">นาย ภูชิต จิระวัฒนผลิน</td>
                    <td class="text-center"><input type="radio" name="radio3"></td>
                    <td class="text-center"><input type="radio" name="radio3"></td>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">นาย อาทร บริรักษ์ปฐมวี</td>
                    <td class="text-center"><input type="radio" name="radio4"></td>
                    <td class="text-center"><input type="radio" name="radio4"></td>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group text-center">
        <button class="btn btn-primary">บันทึก</button>
        <button class="btn btn-danger">ย้อนกลับ</button>
    </div>
</div>
