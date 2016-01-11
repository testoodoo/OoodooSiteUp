<script type="text/javascript">
$(function () {
    $('#pay1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '{{$first_month}}'
        },
        xAxis: {
            categories: ['Cheque', 'Card', 'Cash','Cash Online','Cash Offline','Cash Online Acpay','Cash Online Anpay']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Counts Of Payments'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [
         @if(count($pay_map)!=0)
        {
            name: 'failed',
            data: [@if(count($failed)!=0)
            {{$failed->cheque}},{{$failed->card}},{{$failed->cash}},{{$failed->cash_online}},{{$failed->cash_offline}},{{$failed->cash_online_acpay}},{{$failed->cash_online_anpay}}
            @endif]
        }, {
            name: 'failure',
            data: [@if(count($failure)!=0)
            {{$failure->cheque}},{{$failure->card}},{{$failure->cash}},{{$failure->cash_online}},{{$failure->cash_offline}},{{$failure->cash_online_acpay}},{{$failure->cash_online_anpay}}
             @endif]
        }, {
            name: 'success',
            data: [@if(count($success)!=0)
            {{$success->cheque}},{{$success->card}},{{$success->cash}},{{$success->cash_online}},{{$success->cash_offline}},{{$success->cash_online_acpay}},{{$success->cash_online_anpay}}
             @endif]
        },{
            name: 'pending',
            data: [@if(count($pending)!=0)
            {{$pending->cheque}},{{$pending->card}},{{$pending->cash}},{{$pending->cash_online}},{{$pending->cash_offline}},{{$pending->cash_online_acpay}},{{$pending->cash_online_anpay}}
             @endif]
        },{
            name: 'cancelled',
            data: [@if(count($cancelled)!=0)
            {{$cancelled->cheque}},{{$cancelled->card}},{{$cancelled->cash}},{{$cancelled->cash_online}},{{$cancelled->cash_offline}},{{$cancelled->cash_online_acpay}},{{$cancelled->cash_online_anpay}}
             @endif]
        }
        @endif
        ]
    });
    $('.highcharts-button').hide();
});
</script>
<script type="text/javascript">
function rangepay(da,for_month) {
    $('#pay3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Payment Details ' +for_month
        },
        xAxis: {
            categories: ['Cheque', 'Card', 'Cash','Cash Online','Cash Offline','Cash Online Acpay','Cash Online Anpay']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Counts Of Payments'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [
        {
            name: 'failed',
            data: [+da['failed'].t,+da['failed'].a,+da['failed'].m,+da['failed'].i,+da['failed'].l,+da['failed'].n,+da['failed'].a],
        }, {
            name: 'failure',
            data: [+da['failure'].t,+da['failure'].a,+da['failure'].m,+da['failure'].i,+da['failure'].l,+da['failure'].n,+da['failure'].a],
        }, {
            name: 'success',
            data: [+da['success'].t,+da['success'].a,+da['success'].m,+da['success'].i,+da['success'].l,+da['success'].n,+da['success'].a],
        },{
            name: 'pending',
            data: [+da['pending'].t,+da['pending'].a,+da['pending'].m,+da['pending'].i,+da['pending'].l,+da['pending'].n,+da['pending'].a],
        },{
            name: 'cancelled',
            data: [+da['cancelled'].t,+da['cancelled'].a,+da['cancelled'].m,+da['cancelled'].i,+da['cancelled'].l,+da['cancelled'].n,+da['cancelled'].a],
        }
        ]
    });
    $('.highcharts-button').hide();
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

        $('.pay').click(function(){
        var for_month = $('select.for_month').val();
        if(for_month.length != 0) {
            $.ajax({
                url :'/admin/reports/report_payment',
                type : 'get',
                data :  {'for_month':for_month},
                dataType : 'json',
                  success : function(data) {                                  
                                rangepay(data,for_month);
                            }
    });

 }
  });
</script>
