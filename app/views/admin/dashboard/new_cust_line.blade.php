<script type="text/javascript">
    
$(function () {
    $('.g.highcharts-button').hide();
    $('#vannan').highcharts({
        title: {
            text: 'NewCustomer Details',
            x: -20 //center
        },
        subtitle: {
            text: 'Application Proeccing Last 7 days',
            x: -20
        },
        xAxis: {
            categories: [            
            @foreach($seven_date as $date)
                    '{{$date}}',
            @endforeach
            ]
        },
        yAxis: {
            title: {
                text: 'Count In Application'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'AppicationIn',
            data: [
                @foreach($seven_date as $date)
                    {{count(DB::table('new_customers')->where('application_date',$date)->get())}},
                @endforeach
            ]
        }, {
            name: 'AppicationDone',
            data: [
                @foreach($seven_date as $date)
                    {{count(DB::table('cust_det')->whereBetween('created_at',[date('Y-m-d 00:00:00',strtotime($date)),date('Y-m-d 00:00:00',strtotime($date.' + 1 day'))])->get())}},
                @endforeach
            ]
        }]
    });
});
</script>