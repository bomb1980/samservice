<div>
    <div class="panel-body container-fluid">
        <div class="row row-lg">
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="age_period"></div>
                </figure>
            </div>
            <div class="col-md-4 text-center">
                <figure class="highcharts-figure">
                    <div id="geo_name"></div>
                </figure>
            </div>
            @if ($geo_id == 1)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_north"></div>
                    </figure>
                </div>
            @elseif ($geo_id == 2)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_center"></div>
                    </figure>
                </div>
            @elseif ($geo_id == 3)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_north_e"></div>
                    </figure>
                </div>
            @elseif ($geo_id == 4)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_west"></div>
                    </figure>
                </div>
            @elseif ($geo_id == 5)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_east"></div>
                    </figure>
                </div>
            @elseif ($geo_id == 6)
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_south"></div>
                    </figure>
                </div>
            @else
                <div class="col-md-4 text-center">
                    <figure class="highcharts-figure">
                        <div id="province_center"></div>
                    </figure>
                </div>
            @endif
        </div>
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('agechart', function(data) {
                console.log('data');
                age_period(data['youngAdult_val'], data['adult_val'], data['elder_val']);
                geo_name(data['geo_data']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_north', function(data) {
                province_north(data['pop_province']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_center', function(data) {
                province_center(data['pop_province']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_north_e', function(data) {
                province_north_e(data['pop_province']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_west', function(data) {
                province_west(data['pop_province']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_east', function(data) {
                province_east(data['pop_province']);
            });
        })

        document.addEventListener('livewire:load', function() {
            window.livewire.on('province_south', function(data) {
                province_south(data['pop_province']);
            });
        })

        function age_period(youngAdult_val, adult_val, elder_val) {
            Highcharts.chart('age_period', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'ช่วงอายุ'
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
                        text: 'Total percent market share'
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
                        },
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    if (this.name == '18-25') {
                                        var bottom_age = 18;
                                        var top_age = 25;
                                        @this.bottom_age = 18;
                                        @this.top_age = 25;
                                    }
                                    if (this.name == '26-40') {
                                        var bottom_age = 26;
                                        var top_age = 40;
                                        @this.bottom_age = 26;
                                        @this.top_age = 40;
                                    }
                                    if (this.name == '41-60') {
                                        var bottom_age = 41;
                                        var top_age = 60;
                                        @this.bottom_age = 41;
                                        @this.top_age = 60;
                                    }
                                    console.log(this.name, this.y);
                                }
                            }
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },

                series: [{
                    name: "ช่วงอายุ",
                    colorByPoint: true,
                    data: [{
                            name: "18-25",
                            y: {{ $youngAdult_val }},
                        },
                        {
                            name: "26-40",
                            y: {{ $adult_val }},
                        },
                        {
                            name: "41-60",
                            y: {{ $elder_val }},
                        }
                    ]
                }]
            });
        }

        function geo_name(geo_data) {
            Highcharts.chart('geo_name', {
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

        function province_north(pop_province) {
            Highcharts.chart('province_north', {
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

        function province_center(pop_province) {
            Highcharts.chart('province_center', {
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

        function province_north_e(pop_province) {
            Highcharts.chart('province_north_e', {
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

        function province_west(pop_province) {
            Highcharts.chart('province_west', {
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

        function province_east(pop_province) {
            Highcharts.chart('province_east', {
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

        function province_south(pop_province) {
            Highcharts.chart('province_south', {
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
        Highcharts.chart('age_period', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'ช่วงอายุ'
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
                    text: 'Total percent market share'
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
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                if (this.name == '18-25') {
                                    var bottom_age = 18;
                                    var top_age = 25;
                                    @this.bottom_age = 18;
                                    @this.top_age = 25;
                                }
                                if (this.name == '26-40') {
                                    var bottom_age = 26;
                                    var top_age = 40;
                                    @this.bottom_age = 26;
                                    @this.top_age = 40;
                                }
                                if (this.name == '41-60') {
                                    var bottom_age = 41;
                                    var top_age = 60;
                                    @this.bottom_age = 41;
                                    @this.top_age = 60;
                                }
                                console.log(this.name, this.y);
                            }
                        }
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
            },

            series: [{
                name: "ช่วงอายุ",
                colorByPoint: true,
                data: [{
                        name: "18-25",
                        y: {{ $youngAdult_val }},
                    },
                    {
                        name: "26-40",
                        y: {{ $adult_val }},
                    },
                    {
                        name: "41-60",
                        y: {{ $elder_val }},
                    }
                ]
            }]
        });

        Highcharts.chart('geo_name', {
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

        Highcharts.chart('province_center', {
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
                data: {!! json_encode($pop_province[2]) !!}
            }]
        });

        Highcharts.chart('province_north', {
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
                data: {!! json_encode($pop_province[1]) !!}
            }]
        });

        Highcharts.chart('province_north_e', {
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
                data: {!! json_encode($pop_province[3]) !!}
            }]
        });

        Highcharts.chart('province_west', {
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
                data: {!! json_encode($pop_province[4]) !!}
            }]
        });

        Highcharts.chart('province_east', {
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
                data: {!! json_encode($pop_province[5]) !!}
            }]
        });

        Highcharts.chart('province_south', {
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
                data: {!! json_encode($pop_province[6]) !!}
            }]
        });
    </script>
@endpush
