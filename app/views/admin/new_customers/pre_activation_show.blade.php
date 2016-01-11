@extends ('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/admin/index">Home</a>
        </li>
         <li class="active">
            <a href="/admin/new-customers/list">newcustomers_list</a>
        </li>
        <li class="active">
            <a href="/admin/new-customers/{{$customer->id}}/show">Show</a>
        </li>
    </ul>
</div>
<div class="page-header">
<h1>
    NewCustomers 
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Show
    </small>
  </h1>
</div>
<div class="col-sm-10"></div>
<a href="/admin/new-customers/customer-activation-process/{{$customer->id}}" class="btn btn-success">Activation</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/admin/new-customers/{{$customer->id}}/edit" class="btn btn-primary">Edit</a> 
        <div>
            <ul class="steps">
                <li data-step="1" class="active">
                    <span class="step">1</span>
                    <span class="title">Pre Activation</span>
                </li>
                <li data-step="2">
                    <span class="step">2</span>
                    <span class="title">Activation</span>
                </li>
                <li data-step="3">
                    <span class="step">3</span>
                    <span class="title">Post Activation</span>
                </li>
            </ul>
        </div>
<div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="hr dotted"></div>
    <div class="">
        <div id="user-profile-1" class="user-profile row">
            <div class="col-xs-12 col-sm-3 center">
                <div>
                    <span class="profile-picture">
                        @if(!is_null($photo_view))
                        <div>{{ HTML::image($photo_view->file_name,'') }}</div>
                        @else
                        <img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Alex's Avatar" src="/assets/dist/admin/css/multiselect/select2.png"></img>
                        @endif
                    </span>
                    <div class="space-4"></div>
                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                        <div class="inline position-relative">
                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                <i class="ace-icon fa fa-circle light-green"></i>
                                &nbsp;
                                <span class="white">{{$customer->first_name}} {{$customer->last_name}}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
            </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="space-12"></div>
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> CRF NO </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->request_id}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Name </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->first_name}} {{$customer->last_name}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Email </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->email}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Phone </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->phone}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Address </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">
                                {{$customer->address1}},{{$customer->address2}},{{$customer->address3}}
                        </span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> DOB </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->dob}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Application Date </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$customer->application_date}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Plan </div>
                            <div class="profile-info-value">
                            <?php $plan_name=PlanCostDetail::where('plan_code','=',$customer->plan_code)->get()->first()->plan; ?>
                                <span class="editable editable-click" id="username">{{$plan_name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- PAGE CONTENT ENDS -->
    </div>
    <h5 class="blue bolder">->Customers Details</h5>
    <div class="row">
        <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
            <div class="tabbable">
                <ul class="nav nav-tabs padding-30 tab-size-bigger-100" id="myTab">
                    <li class="">
                        <a data-toggle="tab" href="#faq-tab-1" aria-expanded="false">
                            <i class="blue ace-icon fa fa-question-circle bigger-120"></i>
                                            Feasible
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#faq-tab-2" aria-expanded="false">
                            <i class="green ace-icon fa fa-user bigger-120"></i>
                                     Document upload       
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#faq-tab-3" aria-expanded="false">
                            <i class="orange ace-icon fa fa-credit-card bigger-120"></i>
                                            Payments section
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#faq-tab-5" aria-expanded="false">
                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                            Tickets for complaint
                        </a>
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="faq-tab-1" class="tab-pane fade">
                        <h4 class="blue">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            FEASIBLE DETAILS
                        </h4>
                        <div class="space-8"></div>
                        <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    @include('admin.new_customers.pre_activation_status')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="faq-tab-2" class="tab-pane fade">
                        <h4 class="blue">
                            <i class="green ace-icon fa fa-user bigger-110"></i>
                            DOCUMENT UPLOAD
                        </h4>
                        <div class="space-8"></div>
	                        <div id="faq-list-2" class="panel-group accordion-style1 accordion-style2">
	                            <div class="panel panel-default">
	                                <div class="panel-heading">
	                                @include('admin.documents.create')
                                    </div>
	                             </div>
                           </div>
                    </div><!-- faq-1 -->
	                <div id="faq-tab-3" class="tab-pane fade active in ">
                          <a href="/admin/payments/pay-offline-bill" class="btn btn-white btn-info btn-bold pull-right">
                            pay bill
                           </a>
                        <h4 class="blue">
                            <i class="orange ace-icon fa fa-credit-card bigger-110"></i>
                            PAYMENT DETAILS
                        </h4>
	                    <div class="space-8"></div>
	                    <div id="faq-list-3" class="panel-group accordion-style1 accordion-style2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
	                             @if(count($customer->transactions())!=0)  
                                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Bill No</th>
                                                    <th>Amount</th>
                                                    <th>Transaction Code</th>
                                                    <th>Transaction Type</th>
                                                    <th>Payment Type</th>
                                                    <th>Status</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                <tr>
                                                @foreach($customer->transactions() as $customers)
                                                    <td>{{$customers->id}}</td>
                                                    <td>{{$customers->bill_no}}</td>
                                                    <td>{{$customers->amount}}</td>
                                                    <td>{{$customers->transaction_code}}</td>
                                                    <td>{{$customers->transaction_type}}</td>
                                                    <td>{{$customers->payment_type}}</td>
                                                    <td>{{$customers->status}}</td>
                                                    <td>{{$customers->remarks}}</td>
                                                    
                                                </tr>
                                                 @endforeach
                                            </tbody>
                                        </table> 
                                    @else
                                        <h5>No Records Found</h5>
                                    @endif
	                            </div>
	                        </div>
	                    </div>
	                </div><!-- faq-2 -->
                    <div id="faq-tab-5" class="tab-pane fade">
                        <button class="btn btn-white btn-info btn-bold pull-right raise_ticket">
                            <i class="ace-icon fa fa-comments bigger-120 blue"></i>
						      Raise Ticket
                        </button>
                        <h4 class="blue">
                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                TICKETS
                        </h4>
                        <div class="space-8"></div>
                        <div id="faq-list-5" class="panel-group accordion-style1 accordion-style2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
			                        <!-- Ticket Form starts -->
										@include('admin.new_customers.ticket_form')
							        <div class="col-xs-11">
										@if(!is_null($ticket))
											@include('admin.new_customers.ticket_status_history')
										@endif
								    </div>
			                    </div>
                            </div>
                       </div>
                    </div><!-- faq-3 -->
                </div><!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div>
    </div>
</div>                        
<script type="text/javascript">
    function tickets() {
        window.open("<?php public_path() ?>/admin/new-customers/{{$customer->id}}/pre-activation-ticket-popup", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }
</script>
   


@stop