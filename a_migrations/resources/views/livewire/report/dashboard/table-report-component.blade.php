<div>
    @if ($fiscalyear_code)
    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <table class="table table-bordered table-hover table-striped dataTable text-center" id="Datatables">
                <thead>
                    <tr>
                        <td class="text-center col-1">งวด</td>
                        <td class="text-center col-1">งบ</td>
                        <td class="text-center col-1">เบิกจ่าย</td>
                        <td class="text-center col-1">กิจกรรมจ้างงานเร่งด่วน</td>
                        <td class="text-center col-1">กิจกรรมฝึกทักษะฝีมือแรงงาน</td>
                        <td class="text-center col-1">คงเหลือ</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($BudgetProjectplanPeriod as $key =>$val)
                    <tr>
                        <td class="text-center">{{$val['periodno']}}</td>
                        <td class="text-right">{{number_format($val['budgetperiod'] + $val['budgetbalance'], 2)}}</td>
                        <td class="text-right">{{number_format($val['pay_amt'], 2) ?? 0}}</td>
                        <td class="text-right">{{number_format($val['pay_urgentamt'], 2) ?? 0}}</td>
                        <td class="text-right">{{number_format($val['pay_trainamt'], 2) ?? 0}}</td>
                        <td class="text-right">{{number_format($val['budgetperiod'] + $val['budgetbalance'] - $val['pay_amt'], 2) ?? 0}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
