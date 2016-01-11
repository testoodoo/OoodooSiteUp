
<script type="text/javascript">
    $(function () {
    // Create the chart
    $('#cont').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Tickets Details'
        },
        subtitle: {
            text: 'Click To Status Wise'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.percentage:.1f}%'
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
                name: "New Connection",
                y: {{count($new_comp)}},
                drilldown: "New Connection"
            }, {
                name: "Technical Complaint",
                y: {{count($tech_comp)}},
                drilldown: "Technical Complaint"
            }, {
                name: "Billing Complaint",
                y: {{count($bill_comp)}},
                drilldown: "Billing Complaint"
            }]
        }],
        drilldown: {
            series: [
            @foreach($today as $value)
                {
                name: "{{$value->ticket_type}}",
                id: "{{$value->ticket_type}}",
                data: [
                        ["open",{{DB::table('ticket_details')->where("ticket_type",$value->ticket_type)->whereBetween('ticket_date',[$lastweek,$day])->sum('open')}}],
                        ["close",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->whereBetween('ticket_date',[$lastweek,$day])->sum('close')}}],
                        ["processing",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->whereBetween('ticket_date',[$lastweek,$day])->sum('processing')}}],
                        ["invaild",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->whereBetween('ticket_date',[$lastweek,$day])->sum('invaild')}}]
                ]
            }, 
            @endforeach
            ]
        }
    });
});
</script>
<script type="text/javascript">
    $(function () {
    // Create the chart
    $('#co').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Tickets Details Before Last Month'
        },
        subtitle: {
            text: 'Click To Status Wise'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.percentage:.1f}%'
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
                name: "New Connection",
                y: {{count($new_comp_till)}},
                drilldown: "New Connection"
            }, {
                name: "Technical Complaint",
                y: {{count($tech_comp_till)}},
                drilldown: "Technical Complaint"
            }, {
                name: "Billing Complaint",
                y: {{count($bill_comp_till)}},
                drilldown: "Billing Complaint"
            }]
        }],
        drilldown: {
            series: [
            @foreach($comp_till as $value)
                {
                name: "{{$value->ticket_type}}",
                id: "{{$value->ticket_type}}",
                data: [
                        ["open",{{DB::table('ticket_details')->where("ticket_type",$value->ticket_type)->sum('open')}}],
                        ["close",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->sum('close')}}],
                        ["processing",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->sum('processing')}}],
                        ["invaild",{{DB::table('ticket_details')->where('ticket_type',$value->ticket_type)->sum('invaild')}}]
                    ]
                }, 
            @endforeach
            ]
        }
    });
});
</script>
<script type="text/javascript">
function rangeticket(tick) {
    // Create the chart
    $('#cont').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: ''+tick['from']+' TO '+tick['to']
        },
        subtitle: {
            text: 'Click To Status Wise'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.percentage:.1f}%'
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
                name: "New Connection",
                y: tick['new'],
                drilldown: "New Connection"
            }, {
                name: "Technical Complaint",
                y: tick['tech'],
                drilldown: "Technical Complaint"
            }, {
                name: "Billing Complaint",
                y: tick['bill'],
                drilldown: "Billing Complaint"
            }]
        }],
        drilldown: {
            series: [
                {
                name: "New Connection",
                id: "New Connection",
                data: [["open",+tick["open"]["New Connection"]],["close",+tick["close"]["New Connection"]],["processing",+tick["processing"]["New Connection"]],["invaild",+tick["invaild"]["New Connection"]]]
                },{
                name: "Technical Complaint",
                id: "Technical Complaint",
                data: [["open",+tick["open"]["Technical Complaint"]],["close",+tick["close"]["Technical Complaint"]],["processing",+tick["processing"]["Technical Complaint"]],["invaild",+tick["invaild"]["Technical Complaint"]]]
                },{
                name: "Billing Complaint",
                id: "Billing Complaint",
                data: [["open",+tick["open"]["Billing Complaint"]],["close",+tick["close"]["Billing Complaint"]],["processing",+tick["processing"]["Billing Complaint"]],["invaild",+tick["invaild"]["Billing Complaint"]]]
                }
            ]
        }
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

        $('.from_to_ticktet').click(function(){
        var from = $('.from_ticket').val();
        var to   = $('.to_ticket').val();
        if(from.length != 0) {
            $.ajax({
                url :'/admin/reports/report_ticket',
                type : 'get',
                data :  {'from':from,'to':to},
                dataType : 'json',
                  success : function(data) {                                  
                                rangeticket(data);
                            }
    });

 }
  });
</script>