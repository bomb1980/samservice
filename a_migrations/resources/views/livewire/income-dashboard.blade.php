<div>
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="income"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="income_geo"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="income_province"></div>
                </figure>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('incomechart', function(data) {
                income(data['pop_income_male'],data['pop_income_female']);
                income_geo(data['geo_data']);
                income_province(data['pop_province']);
            });
        })

        function income(pop_income_male,pop_income_female) {
            Highcharts.chart('income', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'รายได้'
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
                    categories: [
                        'รายได้'
                    ],
                    crosshair: true
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },
                series: [{
                    name: 'ค่าเฉลี่ยเพศ ชาย',
                    data: [pop_income_male]

                }, {
                    name: 'ค่าเฉลี่ยเพศ หญิง',
                    data: [pop_income_female]

                }]
            });
        }

        function income_geo(geo_data) {
            Highcharts.chart('income_geo', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    align: 'left',
                    text: 'ภูมิภาค'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    if (this.name == 'ภาคเหนือ') {
                                        @this.geo_id = 1;
                                        var geo_id = 1;
                                    }
                                    if (this.name == 'ภาคกลาง') {
                                        @this.geo_id = 2;
                                        var geo_id = 2;
                                    }
                                    if (this.name == 'ภาคตะวันออกเฉียงเหนือ') {
                                        @this.geo_id = 3;
                                        var geo_id = 3;
                                    }
                                    if (this.name == 'ภาคตะวันตก') {
                                        @this.geo_id = 4;
                                        var geo_id = 4;
                                    }
                                    if (this.name == 'ภาคตะวันออก') {
                                        @this.geo_id = 5;
                                        var geo_id = 5;
                                    }
                                    if (this.name == 'ภาคใต้') {
                                        @this.geo_id = 6;
                                        var geo_id = 6;
                                    }
                                    console.log(this.name, this.y, geo_id);
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'สัญญา',
                    colorByPoint: true,
                    data: geo_data
                }]
            });
        }

        function income_province(pop_province) {
            Highcharts.chart('income_province', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'จังหวัด'
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
                    // title: {
                    //     text: 'จำนวนสัญญา'
                    // }
                },
                yAxis: {
                    title: {
                        text: 'สัญญา'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },

                series: [{
                    name: "จังหวัด",
                    colorByPoint: true,
                    data: pop_province
                }]
            });
        }
    </script>
</div>

@push('js')
    <script>
        Highcharts.chart('income', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'รายได้'
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
                categories: ['รายได้'],
                crosshair: true
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
            },
            series: [{
                name: 'ค่าเฉลี่ยเพศ ชาย',
                data: [{!! json_encode($pop_income_male) !!}]

            }, {
                name: 'ค่าเฉลี่ยเพศ หญิง',
                data: [{!! json_encode($pop_income_female) !!}]

            }]
        });

        Highcharts.chart('income_geo', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'ภูมิภาค'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                },
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                if (this.name == 'ภาคเหนือ') {
                                    @this.geo_id = 1;
                                    var geo_id = 1;
                                }
                                if (this.name == 'ภาคกลาง') {
                                    @this.geo_id = 2;
                                    var geo_id = 2;
                                }
                                if (this.name == 'ภาคตะวันออกเฉียงเหนือ') {
                                    @this.geo_id = 3;
                                    var geo_id = 3;
                                }
                                if (this.name == 'ภาคตะวันตก') {
                                    @this.geo_id = 4;
                                    var geo_id = 4;
                                }
                                if (this.name == 'ภาคตะวันออก') {
                                    @this.geo_id = 5;
                                    var geo_id = 5;
                                }
                                if (this.name == 'ภาคใต้') {
                                    @this.geo_id = 6;
                                    var geo_id = 6;
                                }
                                console.log(this.name, this.y, geo_id);
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'สัญญา',
                colorByPoint: true,
                data: {!! json_encode($geo_data) !!}
            }]
        });

        Highcharts.chart('income_province', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'จังหวัด'
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
                // title: {
                //     text: 'จำนวนสัญญา'
                // }
            },
            yAxis: {
                title: {
                    text: 'สัญญา'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
            },

            series: [{
                name: "จังหวัด",
                colorByPoint: true,
                data: {!! json_encode($pop_province) !!}
            }]
        });
    </script>
@endpush
