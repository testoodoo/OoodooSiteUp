<div class="header blue">
        <h3></h3>
</div>
{{ Form::open( array( 'route' => array('admin.users.pre_activation_post'),'method' => 'POST','class' => 'form-horizontal', 'role' => 'form')  ) }}
    {{ Form::hidden('customer_id',$customer->application_no) }}
    {{ Form::hidden('preactivation_status_id',$customer->application_no) }}
    <div class="col-xs-12 col-sm-5">
        <span  class="data feasible_radio btn btn-app btn-success btn-sm line-height-1 bigger-50">feasible</span>
        <input type="hidden" name="feasible" class="feasible" value="{{$preactivation_status->feasible}}" >
        <span  class="data not_feasible_radio btn btn-app btn-pink btn-sm line-height-1 bigger-50" style="width:100px">not feasible</span>
        <input type="hidden" class="not_feasible" value="0" >   
    </div>
    <div class="col-sm-12">
        <div class="pre-activation-inputs">
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <tbody>
                    <tr>
                      <th>Process</th>
                      <th>Update_at</th>
                      <th>operation</th>
                    </tr>
                    <td>
                        <span  class="play fiber_set btn btn-app btn-success btn-sm line-height-1 bigger-50">fiber</span>
                        <input type="hidden" name="fiber" class="fiber" value="{{$preactivation_status->fiber}}" >
                        @if(count($ticket))
                        @if($ticket->ticket_type_id == 17) <span class="red bolder"> <span class='fa fa-close fa-2x' ></span></span> @else @endif
                        @endif
                    </td>
                    <td>{{$preactivation_status->fiber_updated_at}}</td>
                    <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                                 view
                    </button></td>
                    <tr>
                    <td>
                        <span  class="play splicing_set btn btn-app btn-success btn-sm line-height-1 bigger-50" >splicing</span>    
                        <input type="hidden" name="splicing" class="splicing" value="{{$preactivation_status->splicing}}" readonly />
                        @if(count($ticket))
                        @if($ticket->ticket_type_id == 18) <span class="red bolder"> <span class='fa fa-close fa-2x' ></span></span> @else @endif
                        @endif
                    </td>
                     <td>{{$preactivation_status->splicing_updated_at}}</td>
                    <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                                 view
                    </button></td>
                    </tr>

                    <tr>
                    <td>
                        <span  class="play ethernet_set btn btn-app btn-success btn-sm line-height-1 bigger-50" >ethernet</span>    
                        <input type="hidden" name="ethernet" class="ethernet" value="{{$preactivation_status->ethernet}}" readonly />
                        @if(count($ticket))
                        @if($ticket->ticket_type_id == 19) <span class="red bolder"> <span class='fa fa-close fa-2x' ></span></span> @else @endif
                        @endif
                    </td>
                     <td>{{$preactivation_status->ethernet_updated_at}}</td>
                    <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                                 view
                    </button></td>
                    </tr>

                    <tr>
                    <td>
                        <span  class="play hutboxes_set btn btn-app btn-success btn-sm line-height-1 bigger-50">hutboxes</span>    
                        <input type="hidden" name="hut_boxes" class="hutboxes" value="{{$preactivation_status->hut_boxes}}" readonly />
                        @if(count($ticket))
                        @if($ticket->ticket_type_id == 20) <span class="red bolder"> <span class='fa fa-close fa-2x' ></span></span> @else @endif
                        @endif
                    </td>
                     <td>{{$preactivation_status->hut_boxes_updated_at}}</td>
                      <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                                 view
                      </button></td>
                    </tr>

                    <tr>
                    <td>
                        <span  class="play configuration_set btn btn-app btn-success btn-sm line-height-1 bigger-50" style="width:100px">configuration</span>    
                        <input type="hidden" name="configuration" class="configuration" value="{{$preactivation_status->configuration}}" readonly />
                        @if(count($ticket))
                        @if($ticket->ticket_type_id == 21) <span class="red bolder"> <span class='fa fa-close fa-2x' ></span></span> @else @endif
                        @endif
                    </td>
                     <td>{{$preactivation_status->configuration_updated_at}}</td>
                    <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                             view
                    </button></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Remark</span>
                </label>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                        <textarea rows="3" class="form-control requried" name="remarks"></textarea>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
        </div>
    </div>
{{Form::close();}}

<script type="text/javascript">
  $(document).ready(function(){
    var value= $('.feasible').val();
    if(value==1)
    {
        $('div.pre-activation-inputs').show();
	    }else{
		  $('div.pre-activation-inputs').hide();
		}

	   var fiber=$('.fiber').val();
       if(fiber != 1){
	    $('.fiber_set').addClass('btn btn-app btn-pink btn-sm')
	    $('.fiber').val(0);
       }
       var splicing=$('.splicing').val();
       if(splicing != 1){
	    $('.splicing_set').addClass('btn btn-app btn-pink btn-sm')
	    $('.splicing').val(0);
       }
       var ethernet=$('.ethernet').val();
       if(ethernet != 1){
	    $('.ethernet_set').addClass('btn btn-app btn-pink btn-sm')
	    $('.ethernet').val(0);
       }
       var hut_boxes=$('.hutboxes').val();
       if(hut_boxes != 1){
	    $('.hutboxes_set').addClass('btn btn-app btn-pink btn-sm')
	    $('.hutboxes').val(0);
       }
       var configuration=$('.configuration').val();
       if(configuration != 1){
	    $('.configuration_set').addClass('btn btn-app btn-pink btn-sm')
	    $('.configuration').val(0);
       }

       var feasible=$('.feasible').val();
       if(feasible != 1){
	    $('div.pre-activation-inputs').hide();
       }else{
       	$('div.pre-activation-inputs').show();
       }




 //preactivation
        $('.feasible_radio').click(function(){
            $('div.pre-activation-inputs').show();
             $('.feasible_radio').val("1");
        })

        $('.not_feasible_radio').click(function(){
            $('div.pre-activation-inputs').hide();
             $('.not_feasible_radio').val("0");
        })
 //raising tickets buttons
         	$('button.raise_ticket').click(function(){
		$(".ticket_form").slideToggle("slow");
	    });
    });
</script>
<script type="text/javascript">


   $(function(){$('.play').click(function() {
   	   var text=$(this).text();
       if($('.'+text).val() == "0"){
       $(this).removeClass('btn btn-app btn-pink btn-sm')
       $(this).addClass('btn btn-app btn-success btn-sm')
       $('.'+text).val("1");
       }else{
	    $(this).removeClass('btn btn-app btn-success btn-sm')
	    $(this).addClass('btn btn-app btn-pink btn-sm')
	    $('.'+text).val("0");
	   }
    });
   });
     $(function(){$('.data').click(function() {
     text=$(this).text();
       if('feasible' == text){
       $('.feasible').val("1");
       }else{
	    $('.feasible').val("0");
	   }
    });
   });
</script>



