<div class="page-content container-fluid">
    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12">
                    {!! Form::open([
                        'wire:submit.prevent' => 'exportExcel()',
                        'autocomplete' => 'off',
                        'class' => 'form-horizontal fv-form fv-form-bootstrap4',
                    ]) !!}
                    <div class="form-group row">
                        <label class="col-md-1 form-control-label">ปีงบประมาณ </label>
                        <div class="col-md-2">


                            {!! Form::select('year_list', $year_list, null, [
                                'class' => 'form-control',
                                'wire:model' => 'year_select',
                                'wire:change' => 'clearArea("year_select")',
                            ]) !!}
                        </div>


                        <label class="col-md-1 form-control-label">ภาค </label>
                        <div class="col-md-2">
                            {!! Form::select('region_list', $region_list, null, [
                                'class' => 'form-control',
                                'wire:model' => 'region_select',
                                'wire:change' => 'clearArea("region_select")',
                            ]) !!}
                        </div>

                        <label class="col-md-1 form-control-label">จังหวัด </label>
                        <div class="col-md-2">
                            {!! Form::select('province_list', $province_list, null, [
                                'class' => 'form-control',
                                'wire:model' => 'province_select',
                                'wire:change' => 'clearArea("province_select")',
                            ]) !!}
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" wire:click="exportExcel">{!! getIcon('excel') !!} รายงาน
                                Excel</button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12 text-center">
                    <figure class="highcharts-figure">
                        <div id="chart1"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <table class="table table-bordered table-hover table-striped dataTable text-center" id="Datatables">
                <thead>
                    <tr>
                        <td class="text-center">ปี</td>
                        <td class="text-center">งวด</td>
                        <td class="text-center">ภูมิภาค</td>
                        <td class="text-center">จังหวัด</td>
                        <td class="text-center">กลุ่มหลักสูตร</td>
                        <td class="text-center">จำนวนกิจกรรมที่จัด</td>
                        <td class="text-center">จำนวนคนที่เข้าร่วม</td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($clone_datas as $ka => $va)
                        <tr>
                            <td class="text-center">{{ $va['budgetyear'] }}</td>
                            <td class="text-center">{{ $va['periodno'] }}</td>
                            <td class="text-center">{{ $va['region'] }}</td>
                            <td class="text-center">{{ $va['province'] }}</td>
                            <td class="text-center">{{ $va['name'] }}</td>
                            <td class="text-right">{{ $va['t'] }}</td>
                            <td class="text-right">{{ $va['total_people_checkin'] }}</td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>


@push('js')
    <script src="js/highcharts/highcharts.js"></script>
    <script src="js/highcharts/exporting.js"></script>
    <script src="js/highcharts/export-data.js"></script>
    <script src="js/highcharts/accessibility.js"></script>




    <script>
        document.addEventListener('livewire:load', function() {


            call_charts({!! $data_chart !!});

            window.livewire.on('loadJquery', () => {

            });

            window.livewire.on('dsddfdfasdfadsfds', (res) => {

                call_charts(res);
            });
        });

        function setValue(name, value) {
            @this.set(name, value);
        }

        function call_charts(data) {

            options1 = {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: ''
                },
                subtitle: {
                    align: 'left',
                    text: ''
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'จำนวน'
                    }

                },
                legend: {
                    enabled: true
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },
                xAxis: {
                    categories: data.categories,
                    crosshair: true
                },
                title: {
                    text: data.title
                },
                series: data.datas
            };

            Highcharts.chart('chart1', options1);

        }
    </script>
@endpush
