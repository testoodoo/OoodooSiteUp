<script type="text/javascript">
    $(function () {

    // Build the chart
    $('#date1').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '@if(count($from_date)!=0) {{date("Y-m-d",strtotime($from_date))}} TO {{date("Y-m-d",strtotime($to_date))}} @endif'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: "List",
            data: [
                @if(count($feasible)==0)
                    'NULL'
                @endif
                @foreach($feasible as $key)
                @if(count($from_date)!=0)
                {name: "{{$key->area}}", y:{{DB::table('feasible_details')->whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('cust_count_in_area')}}},
                @else
                {name: "{{$key->area}}", y:{{DB::table('feasible_details')->where('area',$key->area)->whereBetween('feasible_date',[$lastweek,$day])->sum('cust_count_in_area')}}},
                @endif
                @endforeach
            ]
        }]
    });
});                                         
</script>
<script type="text/javascript">
    $(function () {

    // Build the chart
    $('#date3').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: "List",
            data: [
                @foreach($feasible_1 as $key)
                {name: "{{$key->area}}", y:{{DB::table('feasible_details')->where('area',$key->area)->sum('cust_count_in_area')}}},
                @endforeach
            ]
        }]
    });
});                                         
</script>