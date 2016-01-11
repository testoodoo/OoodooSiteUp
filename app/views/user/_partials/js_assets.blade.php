<script type="text/javascript">

                function Plandet() 
                   {
                   var month_sub = $('select[name="monthly_subs"]').val();
                    if (month_sub.length != 0) {
                      $.ajax({
                            url:'/plan_change/month_sub',
                            type:'POST',
                            data: {month_sub : month_sub},
                            dataType: 'json',
                            success : function(json) {
                                
                                   }
                              });

                            }
                    };

                function plan_change() {
                    var plan = $('select[name="plan_code"]').val();
                    if (plan.length != 0) {
                      $.ajax({
                            url:'plan_change/fetch_plan_det',
                            type:'GET',
                            data: { plan_code : plan},
                            success : function(data) {
                                if (data["found"] == "false") {
                                    alert('Plan not Found');
           
                                } else {
                                    $('.plan_desc').val(data['plan_desc']);
                                    $('.plan_cost').val(data['plan_cost']);
                                    $('.plan_amt').val(data['plan_amt']);
                                    $('.payable_amt').val(data['payable_amt']);
                                    $('.prorata_cost').val(data['prorata_cost']);
                                    $('.prorata_dis').val(data['prorata_dis']);
                                    $('.old_plan_code').val(data['old_plan_code']);
                                    
                                    
                                }
                            }
                        });
                    }
                    };


</script>