<div>
    @if ($fiscalyear_code)
    <div class="panel form-group">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                <div class="col-md-12 text-center">
                    <figure class="highcharts-figure">
                        <div id="installment"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('installment', function(data) {
                installment(data['installment'],data['budget'],data['withdraw']);
            });
        })

        function installment(installment,budget,withdraw) {
            Highcharts.chart('installment', {
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
                    enabled: false
                },
                xAxis: {
                    categories: installment,
                    crosshair: true
                },
                // plotOptions: {
                //     series: {
                //         borderWidth: 0,
                //         dataLabels: {
                //             enabled: true,
                //             format: '{point.y:.1f}%'
                //         }
                //     }
                // },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },
                series: [{
                    name: 'งบ',
                    data: budget
                },
                {
                    name: 'เบิกจ่าย',
                    data: withdraw
                }]
            });
        }
    </script>
</div>

@push('js')
<script>
    Highcharts.chart('installment', {
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
            enabled: false
        },
        xAxis: {
            categories: {!! json_encode($installment) !!},
            crosshair: true
        },
        // plotOptions: {
        //     series: {
        //         borderWidth: 0,
        //         dataLabels: {
        //             enabled: true,
        //             format: '{point.y:.1f}%'
        //         }
        //     }
        // },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
        },
        series: [{
            name: 'งบ',
            data: {!! json_encode($budget) !!}
        },
        {
            name: 'เบิกจ่าย',
            data: {!! json_encode($withdraw) !!}
        }]
    });
</script>
@endpush
