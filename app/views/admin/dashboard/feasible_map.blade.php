<script type="text/javascript">
    // Create the chart
    $('#new_map').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '@if(count($from_date)!=0) {{date("Y-m-d",strtotime($from_date))}} TO {{date("Y-m-d",strtotime($to_date))}} @endif'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent'
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
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [{
                name: "fiber",
                y:{{$fiber}},
                drilldown: "fiber"
            }, {
                name: "splicing",
                y: {{$splicing}},
                drilldown: "splicing"
            }, {
                name: "ethernet",
                y: {{$ethernet}},
                drilldown: "ethernet"
            }, {
                name: "hut_boxes",
                y: {{$hut_boxes}},
                drilldown: "hut_boxes"
            }, {
                name: "configuration",
                y: {{$configuration}},
                drilldown: "configuration"
            }]
        }],
        drilldown: {
            series: [{
                name: "fiber",
                id: "fiber",
                data: [
                @foreach($feasible as $key)
                    [
                    "{{$key->area}}",
                        @if(count($from_date)!=0)
                        {{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('fiber')}}
                        @else
                        {{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('fiber')}}
                        @endif
                    ],
                @endforeach
                ]
            }, {
                name: "splicing",
                id: "splicing",
                data: [
                    @foreach($feasible as $key)
                    [
                    "{{$key->area}}",
                        @if(count($from_date)!=0)
                        {{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('splicing')}}
                        @else
                        {{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('splicing')}}
                        @endif
                    ],
                    @endforeach
                ]
            },{
                name: "ethernet",
                id: "ethernet",
                data: [
                    @foreach($feasible as $key)
                    [
                    "{{$key->area}}",
                        @if(count($from_date)!=0)
                        {{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('ethernet')}}
                        @else
                        {{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('ethernet')}}
                        @endif
                    ],
                    @endforeach
                ]
            },{
                name: "hut_boxes",
                id: "hut_boxes",
                data: [
                    @foreach($feasible as $key)
                    [
                    "{{$key->area}}",
                        @if(count($from_date)!=0)
                        {{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('hut_boxes')}}
                        @else
                        {{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('hut_boxes')}}
                        @endif
                    ],
                    @endforeach
                ]
            }, {
                name: "configuration",
                id: "configuration",
                data: [
                    @foreach($feasible as $key)
                    [
                    "{{$key->area}}",
                        @if(count($from_date)!=0)
                        {{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('configuration')}}
                        @else
                        {{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('configuration')}}
                        @endif
                    ],
                    @endforeach
                ]
            }]
        }
    });
</script>
<script type="text/javascript">
    // Create the chart
    $('#mani').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent'
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
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [{
                name: "fiber",
                y:{{$fiber_1}},
                drilldown: "fiber"
            }, {
                name: "splicing",
                y: {{$splicing_1}},
                drilldown: "splicing"
            }, {
                name: "ethernet",
                y: {{$ethernet_1}},
                drilldown: "ethernet"
            }, {
                name: "hut_boxes",
                y: {{$hut_boxes_1}},
                drilldown: "hut_boxes"
            }, {
                name: "configuration",
                y: {{$configuration_1}},
                drilldown: "configuration"
            }]
        }],
        drilldown: {
            series: [{
                name: "fiber",
                id: "fiber",
                data: [
                @foreach($feasible_1 as $key)
                    [
                    "{{$key->area}}",
                    {{DB::table('feasible_details')->where('area',$key->area)->sum('fiber')}}
                    ],
                @endforeach
                ]
            }, {
                name: "splicing",
                id: "splicing",
                data: [
                    @foreach($feasible_1 as $key)
                    [
                    "{{$key->area}}",
                    {{DB::table('feasible_details')->where('area',$key->area)->sum('splicing')}}
                    ],
                    @endforeach
                ]
            },{
                name: "ethernet",
                id: "ethernet",
                data: [
                    @foreach($feasible_1 as $key)
                    [
                    "{{$key->area}}",
                    {{DB::table('feasible_details')->where('area',$key->area)->sum('ethernet')}}
                    ],
                    @endforeach
                ]
            },{
                name: "hut_boxes",
                id: "hut_boxes",
                data: [
                    @foreach($feasible_1 as $key)
                    [
                    "{{$key->area}}",
                    {{DB::table('feasible_details')->where('area',$key->area)->sum('hut_boxes')}}
                    ],
                    @endforeach
                ]
            }, {
                name: "configuration",
                id: "configuration",
                data: [
                    @foreach($feasible_1 as $key)
                    [
                    "{{$key->area}}",
                    {{DB::table('feasible_details')->where('area',$key->area)->sum('configuration')}}
                    ],
                    @endforeach
                ]
            }]
        }
    });
</script>
<script type="text/javascript">
  $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true
        })
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({autoclose:true});

        $('.from_to').click(function(){
        var from = $('.from').val();
        var to   = $('.to').val();
        alert(from);
        if(from.length != 0) {
            $.ajax({
                url :'/admin/reports/report',
                type : 'get',
                data :  {'from':from,'to':to},
                dataType : 'json',
                  success : function(data) {                                  
                                range(data);
                            }
    });

 }
  });
</script>
<script type="text/javascript">
function range(d) {
    // Create the chart
    $('#new_map').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Browser market shares. January, 2015 to May, 2015'
        },
        subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
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
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [{
                name: "Microsoft Internet Explorer",
                y: 56.33,
                drilldown: "Microsoft Internet Explorer"
            }, {
                name: "Chrome",
                y: 24.03,
                drilldown: "Chrome"
            }, {
                name: "Firefox",
                y: 10.38,
                drilldown: "Firefox"
            }, {
                name: "Safari",
                y: 4.77,
                drilldown: "Safari"
            }, {
                name: "Opera",
                y: 0.91,
                drilldown: "Opera"
            }, {
                name: "Proprietary or Undetectable",
                y: 0.2,
                drilldown: null
            }]
        }],
        drilldown: {
            series: [{
                name: "Microsoft Internet Explorer",
                id: "Microsoft Internet Explorer",
                data: [
                        $.each(d['fiber'],function(argument) {
                            
                        })
                    ]
            }, {
                name: "Chrome",
                id: "Chrome",
                data: [
                    [
                        "v40.0",
                        5
                    ],
                    [
                        "v41.0",
                        4.32
                    ],
                    [
                        "v42.0",
                        3.68
                    ],
                    [
                        "v39.0",
                        2.96
                    ],
                    [
                        "v36.0",
                        2.53
                    ],
                    [
                        "v43.0",
                        1.45
                    ],
                    [
                        "v31.0",
                        1.24
                    ],
                    [
                        "v35.0",
                        0.85
                    ],
                    [
                        "v38.0",
                        0.6
                    ],
                    [
                        "v32.0",
                        0.55
                    ],
                    [
                        "v37.0",
                        0.38
                    ],
                    [
                        "v33.0",
                        0.19
                    ],
                    [
                        "v34.0",
                        0.14
                    ],
                    [
                        "v30.0",
                        0.14
                    ]
                ]
            }, {
                name: "Firefox",
                id: "Firefox",
                data: [
                    [
                        "v35",
                        2.76
                    ],
                    [
                        "v36",
                        2.32
                    ],
                    [
                        "v37",
                        2.31
                    ],
                    [
                        "v34",
                        1.27
                    ],
                    [
                        "v38",
                        1.02
                    ],
                    [
                        "v31",
                        0.33
                    ],
                    [
                        "v33",
                        0.22
                    ],
                    [
                        "v32",
                        0.15
                    ]
                ]
            }, {
                name: "Safari",
                id: "Safari",
                data: [
                    [
                        "v8.0",
                        2.56
                    ],
                    [
                        "v7.1",
                        0.77
                    ],
                    [
                        "v5.1",
                        0.42
                    ],
                    [
                        "v5.0",
                        0.3
                    ],
                    [
                        "v6.1",
                        0.29
                    ],
                    [
                        "v7.0",
                        0.26
                    ],
                    [
                        "v6.2",
                        0.17
                    ]
                ]
            }, {
                name: "Opera",
                id: "Opera",
                data: [
                    [
                        "v12.x",
                        0.34
                    ],
                    [
                        "v28",
                        0.24
                    ],
                    [
                        "v27",
                        0.17
                    ],
                    [
                        "v29",
                        0.16
                    ]
                ]
            }]
        }
    });
}
</script>