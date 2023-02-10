<div>
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="act"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="act_region"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="act_province"></div>
                </figure>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('act_list', function(data) {
                act_list(data['act_val']);
                act_geo(data['geo_data']);
                act_province(data['act_province']);
            });
        })

        function act_list(act_val) {
            Highcharts.chart('act', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    align: 'left',
                    text: 'กิจกรรม'
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
                                    if (this.name == 'กิจกรรมจ้างงานเร่งด่วน') {
                                        @this.acttype_id = 1;
                                        var acttype_id = 1;
                                    }
                                    if (this.name == 'กิจกรรมทักษะฝีมือแรงงาน') {
                                        @this.acttype_id = 2;
                                        var acttype_id = 2;
                                    }
                                    console.log(this.name, this.y, acttype_id);
                                }
                            }
                        }
                    }
                },

                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: act_val
                }]
            });
        }

        function act_geo(geo_data) {
            Highcharts.chart('act_region', {
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

        function act_province(act_province) {
            Highcharts.chart('act_province', {
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
                    data: act_province
                }]
            });
        }
    </script>
</div>

@push('js')
    <script>
        Highcharts.setOptions({
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263',
                '#6AF9C4'
            ]
        });

        Highcharts.chart('act', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'กิจกรรม'
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
                                if (this.name == 'กิจกรรมจ้างงานเร่งด่วน') {
                                    @this.acttype_id = 1;
                                    var acttype_id = 1;
                                }
                                if (this.name == 'กิจกรรมทักษะฝีมือแรงงาน') {
                                    @this.acttype_id = 2;
                                    var acttype_id = 2;
                                }
                                console.log(this.name, this.y, acttype_id);
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: {!! json_encode($act_val) !!}
            }]
        });

        Highcharts.chart('act_region', {
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

        Highcharts.chart('act_province', {
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
                data: {!! json_encode($act_province) !!}
            }]
        });
    </script>
@endpush
