 
<!-- basic scripts -->
        {{ HTML::script('/assets/dist/admin/js/jquery.min.js') }}

        
        {{ HTML::script('/assets/dist/admin/js/date-time/moment.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/date-time/daterangepicker.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/date-time/bootstrap-datepicker.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/date-time/bootstrap-datetimepicker.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/date-time/bootstrap-timepicker.min.js') }}

             
        <script type="text/javascript">
            window.jQuery || document.write("<script src='dist/js/jquery.min.js'>"+"<"+"/script>");
        </script>

       
        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        {{ HTML::script('/assets/dist/admin/js/bootstrap.min.js') }}
        <!-- {{ HTML::script('/assets/dist/admin/js/jquery.min.map')}} -->
        {{ HTML::script('/assets/dist/admin/js/datatable/jquery.dataTables.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/datatable/jquery.dataTables.bootstrap.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/datatable/dataTables.colVis.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/datatable/dataTables.tableTools.min.js') }}
         
        {{ HTML::script('/assets/dist/admin/js/datatable/fnReloadAjax.js') }} 



        {{ HTML::script('/assets/dist/admin/js/jquery.Jcrop.min.js') }}



        
        {{ HTML::script('/assets/dist/admin/js/multiselect/bootstrap-multiselect.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/multiselect/jquery.bootstrap-duallistbox.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/multiselect/jquery.raty.min.js') }} 
        
        {{ HTML::script('/assets/dist/admin/js/select2.min.js') }} 
        
        
        {{ HTML::script('/assets/dist/admin/js/jquery-ui.custom.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/jquery.ui.touch-punch.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/jquery.easypiechart.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/jquery.sparkline.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/flot/jquery.flot.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/flot/jquery.flot.pie.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/flot/jquery.flot.resize.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/jquery.validate.min.js') }} 

        {{ HTML::script('/assets/dist/admin/js/fuelux.wizard.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/additional-methods.min.js') }} 
         {{ HTML::script('/assets/dist/admin/js/bootbox.min.js') }} 
         {{ HTML::script('/assets/dist/admin/js/jquery.maskedinput.min.js') }} 


        {{ HTML::script('/assets/dist/admin/js/typeahead.jquery.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/jquery.slimscroll.min.js') }} 
        
    
<!-- ace scripts -->
        {{ HTML::script('/assets/dist/admin/js/ace-elements.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/ace.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/admin.js') }}
        
        {{ HTML::script('/assets/dist/admin/js/kendo/kendo.all.min.js') }}
         
        
        {{ HTML::script('/assets/dist/admin/js/bootstrap/bootstrapValidator.min.js') }}


        {{ HTML::script('/assets/dist/admin/js/highcharts.js') }} 
        {{ HTML::script('/assets/dist/admin/js/exporting.js') }} 
        {{ HTML::script('/assets/dist/admin/js/drilldown.js')}}
        {{ HTML::script('/assets/dist/admin/js/data.js')}}

        {{ HTML::script('/assets/dist/admin/js/spaced-out.js')}}


        {{ HTML::script('/assets/dist/admin/js/chosen.jquery.min.js')}}

        {{ HTML::script('/assets/dist/admin/js/markdown/markdown.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/markdown/bootstrap-markdown.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/markdown/jquery.hotkeys.min.js') }} 
        {{ HTML::script('/assets/dist/admin/js/markdown/bootbox.min.js') }} 

        

        <!-- {{ HTML::script('/assets/dist/admin/js/jquery.min.map')}} -->
       
        <!-- {{ HTML::script('/assets/dist/admin/js/navbar/Chart.min.js')}}
        {{ HTML::script('/assets/dist/admin/js/navbar/slick.min.js')}}
        {{ HTML::script('/assets/dist/admin/js/navbar/base_pages_dashboard.js')}} -->


       <!--  {{ HTML::script('/assets/dist/admin/js/dashboard/jquery.easing.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/pace.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/perfect-scrollbar.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/viewportchecker.js') }}

        {{ HTML::script('/assets/dist/admin/js/dashboard/d3.v3.min.js')}}
        {{ HTML::script('/assets/dist/admin/js/dashboard/Rickshaw.All.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/raphael-min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/morris.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/jquery-jvectormap-world-mill-en.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/jquery-jvectormap-2.0.1.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/gauge.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/icheck.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/dashboard.js') }}

        {{ HTML::script('/assets/dist/admin/js/dashboard/scripts.js') }}

        {{ HTML::script('/assets/dist/admin/js/dashboard/jquery.sparkline.min.js') }}
        {{ HTML::script('/assets/dist/admin/js/dashboard/chart-sparkline.js') }} -->





       




                       
<!--plan cost details  -->  

        
             <script type="text/javascript">
                function getSubs() {
                    var plan = $('select[name="type"]').val();
                    if (plan.length != 0) {
                      $.ajax({
                            url:'/admin/new-customers/planSubscripe',
                            type:'POST',
                            data: { type : plan},
                            dataType: 'json',
                            success: function( json ) {
                                $("#Fiber_subs").empty();
                                $("#Fiber_plans").empty();
                               $.each(json, function(i, optionHtml){
                                  $('#Fiber_subs').append(new Option(optionHtml,i));
                               });
                            }
                        });
                    }else{
                        $("#Fiber_subs").empty();
                        $("#Fiber_plans").empty();
                    }
                    };
                    
            function getPlans() {
                    var type = $('select[name="type"]').val();
                    var subsc = $('select[name="subscribe"]').val();
                    if (subsc.length != 0) {
                      $.ajax({
                            url:'/admin/new-customers/planDetail',
                            type:'POST',
                            data: { type: type, subs : subsc},
                            dataType: 'json',
                            success: function( json ) {
                                  $("#Fiber_plans").empty();
                               $.each(json, function(i, optionHtml){
                                  $('#Fiber_plans').append(new Option(optionHtml,i));
                               });
                            }
                        });
                    }
                    };
        </script>
