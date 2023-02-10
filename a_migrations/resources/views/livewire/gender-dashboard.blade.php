<div>
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="gender"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="geo_data"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="gender_province"></div>
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
            window.livewire.on('genderchart', function(data) {
                gender(data['gender_data']);
                geo_data(data['geo_data']);
                gender_province(data['pop_province']);
            });
        })

        function gender(gender_data) {
            Highcharts.chart('gender', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    align: 'left',
                    text: 'เพศ'
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
                                    if (this.name == 'ชาย') {
                                        @this.pop_gender = 'ชาย';
                                        var pop_gender = 'ชาย';
                                    }
                                    if (this.name == 'หญิง') {
                                        @this.pop_gender = 'หญิง';
                                        var pop_gender = 'หญิง';
                                    }

                                    console.log(this.name, this.y);
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: {!! json_encode($gender_data) !!}
                }]
            });
        }

        function geo_data(geo_data) {
            Highcharts.chart('geo_data', {
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
                    name: 'Brands',
                    colorByPoint: true,
                    data: geo_data
                }]
            });
        }

        function gender_province(pop_province) {
            Highcharts.chart('gender_province', {
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
        Highcharts.chart('gender', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'เพศ'
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
                                if (this.name == 'ชาย') {
                                    @this.pop_gender = 'ชาย';
                                    var pop_gender = 'ชาย';
                                }
                                if (this.name == 'หญิง') {
                                    @this.pop_gender = 'หญิง';
                                    var pop_gender = 'หญิง';
                                }

                                console.log(this.name, this.y);
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: {!! json_encode($gender_data) !!}
            }]
        });

        Highcharts.chart('geo_data', {
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
                name: 'Brands',
                colorByPoint: true,
                data: {!! json_encode($geo_data) !!}
            }]
        });

        Highcharts.chart('gender_province', {
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
