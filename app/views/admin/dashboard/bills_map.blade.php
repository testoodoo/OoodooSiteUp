<script type="text/javascript">
    $(function () {

    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    // Build the chart
    $('#for_month').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '{{$first_month}}'
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
                {name: "Partially Paid", y:{{count($partially_paid)}} ,x:{{$partially_paid_amt}}},
                {
                    name: "Not Paid",
                    y: {{count($not_paid)}},
                    sliced: true,
                    selected: true,
                    x:{{$not_paid_amt}}
                },
                {name: "Paid", y: {{count($paid)}},x:{{$paid_amt}} }
            ]
        }]
    });
});                                         
</script>
<script type="text/javascript">
function monthrange(dat,for_month) {

    // Build the chart
    $('#third_month').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '' +for_month
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
                    format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                 
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: "List",
            data: [
                {name: "Partially Paid", y:dat['partially_paid'] ,x:dat['partially_paid_amt']},
                {
                    name: "Not_Paid",
                    y:dat['not_paid'],
                    sliced: true,
                    selected: true,
                    x:dat['not_paid_amt']
                },
                {name: "Paid", y: dat['paid'],x:dat['paid_amt']}
            ]
        }]
    });
}                                         
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

        $('.bills').click(function(){
        var for_month = $('select.for_months').val();
        if(for_month.length != 0) {
            $.ajax({
                url :'/admin/reports/report_bills',
                type : 'get',
                data :  {'for_month':for_month},
                dataType : 'json',
                  success : function(data) {                                  
                                monthrange(data,for_month);
                            }
    });

 }
  });
</script>