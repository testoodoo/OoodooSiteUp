<?php 
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

    

Route::group( array('domain' => 'test.heat.oodoo.co.in' ), function() {


    Route::get('/',   array('as' => 'admin.login',       'uses' => 'admin\\AuthController@getLogin'));
    Route::get('/admin',   array('as' => 'admin.login',       'uses' => 'admin\\AuthController@getLogin'));
    //admin authentication
    //Admin login, logout and password reset routes
    Route::get('admin/logout',   array('as' => 'admin.logout',      'uses' => 'admin\\AuthController@getLogout'));
    Route::get('admin/login',    array('as' => 'admin.login',       'uses' => 'admin\\AuthController@getLogin'));
    Route::post('admin/login',   array('as' => 'admin.login',       'uses' => 'admin\\AuthController@postLogin'));
    Route::get('admin/forgotpass',array('as' => 'admin.forgot',       'uses' => 'admin\\AuthController@getForgotPass'));
    
    Route::post('admin/request-forget-password', array('as' => 'admin.requestForgetPassword','uses' => 'admin\\AuthController@requestForgetPassword'));
    Route::get('admin/reset-password-request',   array('as' => 'admin.resetPasswordRequest','uses' => 'admin\\AuthController@resetPasswordRequest'));
    Route::post('admin/reset-password',   array('as' => 'admin.resetPassword','uses' => 'admin\\AuthController@resetPassword'));

  
    Route::group( array('prefix' => 'admin', 'before' => 'auth.admin'), function() {
    
       //index...
        Route::get('/index', array('as' => 'admin.index', 'uses' => 'admin\\DashboardController@index'));
        Route::get('navbar/nav', array('as' => 'admin.navbar.nav', 'uses' => 'admin\\DashboardController@Navbar'));

        Route::get('/reports', array('as' => 'admin.reports', 'uses' => 'admin\\ReportsController@Reports'));
        Route::get('reports/report', array('as' => 'report', 'uses' => 'admin\\ReportsController@Report'));
        Route::get('reports/report_bills', array('as' => 'report_bills', 'uses' => 'admin\\ReportsController@ReportBill'));
        Route::get('reports/report_payment', array('as' => 'report_payment', 'uses' => 'admin\\ReportsController@ReportPayment'));
        Route::get('reports/report_ticket', array('as' => 'report_ticket', 'uses' => 'admin\\ReportsController@ReportTicket'));
        Route::get('reports/employee_work',array('as' => 'admin.reports.employee_work', 'uses' => 'admin\\FeasibleController@ShowEmployeeGet'));
        Route::get('reports/employee_work_ajax',array('as' => 'admin.reports.employee_work_ajax', 'uses' => 'admin\\FeasibleController@ShowEmployeeAjax'));
        Route::get('reports/ticket_details', array('as' => 'reports_ticket_details', 'uses' => 'admin\\ReportsController@TicketReports'));
        Route::get('reports/ticket_details_ajax', array('as' => 'reports_ticket_details_ajax', 'uses' => 'admin\\ReportsController@TicketReportsAjax'));
        Route::get('reports/account_report_details', array('as' => 'reports.account_report_details', 'uses' => 'admin\\ReportsController@AccountReportDetails'));
        Route::get('reports/send_reports', array('as' => 'reports.send_reports', 'uses' => 'admin\\ReportsController@SendReportDetails'));
        Route::post('reports/send_reports_post', array('as' => 'reports.send_reports_post', 'uses' => 'admin\\ReportsController@PostSendReportDetails'));
        Route::get('reports/account_ajax_reports', array('as' => 'reports.account_ajax_reports', 'uses' => 'admin\\ReportsController@AccountAjaxDetails'));


        //registration..for costumers
        Route::get('new-customers/registration',          array('as' => 'admin.users.registration', 'uses' => 'admin\\UserController@getRegistration'));
        Route::post('new-customers/post-registration',    array('as' => 'admin.users.registrationstore', 'uses' => 'admin\\UserController@postRegistration'));
        
        Route::get('new-customers/{id}/pre-activation-show', array('as' => 'admin.users.pre-activation-show', 'uses' => 'admin\\UserController@preActivationShow'));
        Route::post('new-customers/pre-activation-post',array('as' => 'admin.users.pre_activation_post', 'uses' => 'admin\\UserController@preActivationPost'));
        Route::get('new-customers/{id}/edit', array('as' => 'admin.users.edit', 'uses' => 'admin\\UserController@edit'));
        Route::post('new-customers/update', array('as' => 'admin.users.update', 'uses' => 'admin\\UserController@update'));
        
        Route::get('new-customers/{id}/pre-activation-ticket-popup', array('as' => 'admin.users.pre_activation_ticket_popup', 'uses' => 'admin\\UserController@preActivationTicketPopup'));
        Route::post('new-customers/status-update', array('as' => 'admin.users.status_update', 'uses' => 'admin\\UserController@statusUpdate'));
        Route::post('new-customers/activate', array('as' => 'admin.users.activate', 'uses' => 'admin\\UserController@activate'));
        Route::get('new-customers/list', array('as' => 'admin.users.list', 'uses' => 'admin\\UserController@newCustomerList'));
        Route::get('new-customers/print',         array('as' => 'admin.users.new-customers-print', 'uses' => 'admin\\UserController@newCustomerPrint'));
        
        Route::get('feasible/list_ajax',array('as' => 'admin.feasible.list_ajax', 'uses' => 'admin\\FeasibleController@NewCustomerListAjax'));
        Route::get('feasible/print_ajax',array('as' => 'admin.feasible.print_ajax', 'uses' => 'admin\\FeasibleController@NewCustomerPrintAjax'));
        Route::get('feasible/reject',array('as' => 'admin.feasible.reject', 'uses' => 'admin\\FeasibleController@NewCustomerReject'));
        Route::get('feasible/reject_ajax',array('as' => 'admin.feasible.reject_ajax', 'uses' => 'admin\\FeasibleController@NewCustomerRejectAjax'));
        Route::get('feasible/assign',array('as' => 'admin.feasible.assign', 'uses' => 'admin\\FeasibleController@NewCustomerAssign'));
        Route::get('feasible/assign_ajax',array('as' => 'admin.feasible.assign_ajax', 'uses' => 'admin\\FeasibleController@NewCustomerAssignAjax'));
        Route::get('feasible/assign',array('as' => 'admin.feasible.assign', 'uses' => 'admin\\FeasibleController@NewCustomerAssign'));
        Route::get('feasible/assign_update',array('as' => 'admin.feasible.assign_update', 'uses' => 'admin\\FeasibleController@NewCustomerAssignUpdate'));
        Route::get('feasible/assign_employee',array('as' => 'admin.feasible.assign_employee', 'uses' => 'admin\\FeasibleController@NewCustomerAssignEmployee'));

        
        //Activation
        Route::get('new-customers/customer-activation',  array('as' => 'admin.users.customer_activation', 'uses' => 'admin\\UserController@customerActivation'));
        Route::post('new-customers/fetch-customer',      array('as' => 'admin.users.fetchCustomer', 'uses' => 'admin\\UserController@fetchCustomer'));
        Route::get('new-customers/customer-activation-process/{id}', array('as' => 'admin.users.customer_activation_process', 'uses' => 'admin\\UserController@customerActivationProcess'));
        Route::get('new-customers/accountEdit/{num}',     array('as' => 'admin.users.accountEdit', 'uses' => 'admin\\UserController@accountEdit'));
        Route::post('new-customers/activation',     array('as' => 'admin.users.activation', 'uses' => 'admin\\JactivationController@Activation'));
           
        
        Route::post('new-customers/activation/post',array('as' => 'admin.activation.post', 'uses' => 'admin\\ActivationController@post'));                  
        Route::post('new-customers/planSubscripe',         array('uses' => 'admin\\UserController@planSubscripe'));
        Route::post('new-customers/planDetail',            array('uses' => 'admin\\UserController@planDetail'));
        Route::post('new-customers/planActivation',        array('uses' => 'admin\\UserController@planActivation'));
        
        Route::get('routes',  array('as' => 'routes', 'uses' => 'admin\\RouteController@index'));

       //tickets..
        Route::get('ticket/index',    array('as'=>'admin.tickets.index','uses'=>'admin\\TicketController@index'));
        Route::get('ticket/create',   array('as'=>'admin.tickets.create','uses'=>'admin\\TicketController@create'));
        Route::post('ticket/store',   array('as'=>'admin.tickets.store','uses'=>'admin\\TicketController@store'));
        Route::get('ticket/view/{id}',array('as'=>'admin.tickets.view','uses'=>'admin\\TicketController@view'));
        Route::post('ticket/generic-store',   array('as'=>'admin.tickets.generic_store','uses'=>'admin\\TicketController@genericStore'));
        Route::get('ticket/mytickets_ajax',    array('as'=>'admin.tickets.mytickets_ajax','uses'=>'admin\\TicketController@MyTicketsAjax'));
        Route::get('ticket/assign_tickets/{id}',    array('as'=>'admin.tickets.assign_tickets','uses'=>'admin\\TicketController@AssignTicket'));
        Route::post('ticket/send_tickets',    array('as'=>'admin.tickets.send_tickets','uses'=>'admin\\TicketController@SendTicket'));
        Route::get('ticket/my_tickets',    array('as'=>'admin.tickets.my_tickets','uses'=>'admin\\TicketController@MyTickets'));
        Route::get('ticket/pdf',    array('as'=>'admin.tickets.pdf','uses'=>'admin\\TicketController@Pdf'));
        Route::get('ticket/ajax_ticket',    array('as'=>'admin.tickets.ajax_ticket','uses'=>'admin\\TicketController@AjaxTicket'));
        Route::get('ticket/status_details',    array('as'=>'admin.tickets.details','uses'=>'admin\\TicketController@TicketDetails'));
        Route::get('ticket/exo_call_status',    array('as'=>'admin.tickets.exo_call_status','uses'=>'admin\\TicketController@ExoCallStatus'));
        Route::get('ticket/exo_call_status_ajax',    array('as'=>'admin.tickets.exo_call_status_ajax','uses'=>'admin\\TicketController@ExoCallStatusAjax'));
        Route::get('ticket/exo_call_missed',    array('as'=>'admin.tickets.exo_call_missed','uses'=>'admin\\TicketController@ExoCallMissed'));
        Route::get('ticket/exo_call_missed_ajax',    array('as'=>'admin.tickets.exo_call_missed_ajax','uses'=>'admin\\TicketController@ExoCallMissedAjax'));
        Route::get('ticket/exo_call_back',    array('as'=>'admin.tickets.exo_call_back','uses'=>'admin\\TicketController@ExoCallBack'));
        Route::get('ticket/support',    array('as'=>'admin.tickets.support','uses'=>'admin\\TicketController@SupportAlert'));
        Route::get('ticket/operation',    array('as'=>'admin.tickets.operation','uses'=>'admin\\TicketController@OperationAlert'));
        Route::get('ticket/support_ajax',    array('as'=>'admin.tickets.support_ajax','uses'=>'admin\\TicketController@SupportAlertAjax'));
        Route::get('ticket/operation_ajax',    array('as'=>'admin.tickets.operation_ajax','uses'=>'admin\\TicketController@OperationAlertAjax'));

        //tickets.. generic methods..
        Route::post('ticket/status',  array('as' => 'status.store', 'uses' => 'StatusController@store'));
        Route::post('ticket/msg',     array('as' => 'messages.store', 'uses' => 'MessagesController@store'));

        //usages..
        Route::get('usages/index',  array('as'=>'admin.usages.index','uses'=>'admin\\UsagesController@index'));
        Route::get('usages/usage_ajax',  array('as'=>'admin.usages.usage_ajax','uses'=>'admin\\UsagesController@indexAjax'));
        Route::get('usages/usage_user',  array('as'=>'admin.usages.usage_user','uses'=>'admin\\UsagesController@userUsage'));
        
        Route::get('session/ajax', array('as' => 'admin.active_sessions.indexAjax', 'uses' => 'admin\\ActiveSessionsController@indexAjax'));
        Route::get('session/index',array('as'=>'admin.active_sessions.index','uses'=>'admin\\ActiveSessionsController@index'));
        Route::get('session/history_index',array('as' => 'admin.session_history.index', 'uses' => 'admin\\SessionController@index')); 
        Route::get('session/history_show',array('as' => 'admin.session_history.show', 'uses' => 'admin\\SessionController@show')); 
        Route::get('session/session_history',  array('as'=>'admin.usages.session_history','uses'=>'admin\\SessionController@sessionHistory'));
        
        Route::get('session/session_logs',  array('as'=>'admin.session.session_logs','uses'=>'admin\\SessionController@sessionLogs'));
        Route::get('session/post_session_logs',  array('as'=>'admin.session.post_session_logs','uses'=>'admin\\SessionController@postSessionLogs'));


        
        //bills..
        Route::get('bills',      array('as'=>'admin.bills.index','uses'=>'admin\\BillsController@index'));
        Route::get('bills/create',array('as'=>'admin.bills.create','uses'=>'admin\\BillsController@create'));
        Route::post('bills/store',array('as'=>'admin.bills.store','uses'=>'admin\\BillsController@store'));
        
        Route::get('bills/edit/{id}',array('as'=>'admin.bills.edit','uses'=>'admin\\BillsController@edit'));
        Route::get('bills/view/{id}',array('as'=>'admin.bills.view','uses'=>'admin\\BillsController@view'));
        Route::get('bills/retransaction/{id}',array('as'=>'admin.bills.retransaction','uses'=>'admin\\BillsController@Retransaction'));
        
        Route::post('bills/update',  array('as'=>'admin.bills.update','uses'=>'admin\\BillsController@update'));
        Route::get('bills/bill_ajax',  array('as'=>'admin.bills.bill_ajax','uses'=>'admin\\BillsController@billAjax'));
        Route::get('bills/user_bill',  array('as'=>'admin.bills.user_bill','uses'=>'admin\\BillsController@userBill'));

        Route::get('bills/notify_user_for_bill/{id}', array('as' => 'admin.bills.notify_user_for_bill', 
                'uses' => 'admin\\BillsController@notifyUserForBill'));

        Route::get('bills/fetch-plan-cost-details', array('as' => 'admin.bills.fetch_plan_cost_details', 'uses' => 'admin\\BillsController@fetchPlanCostDetails'));
        Route::get('bills/fetch-plan-details', array('as' => 'admin.bills.fetch_plan_details', 'uses' => 'admin\\BillsController@fetchPlanDetails'));


        
        //payments
        Route::get('payments/transactions',       array('as' => 'admin.payments.transactions.index', 'uses' => 'admin\\PaymentsController@transactionsList'));
        Route::get('payments/pay-offline-bill',   array('as' => 'admin.payments.get_offline_bill', 'uses' => 'admin\\PaymentsController@getOfflineBill'));
        Route::get('payments/due-offline-bill',   array('as' => 'admin.payments.due_offline_bill', 'uses' => 'admin\\PaymentsController@DuegetOfflineBill'));
        
        Route::post('payments/pay-offline-bill',  array('as' => 'admin.payments.post_offline_bill', 'uses' => 'admin\\PaymentsController@postOfflineBill'));
        Route::get('payments/resend-notification',array('as' => 'admin.payments.resend_notification', 'uses' => 'admin\\PaymentsController@resendNotification'));
        Route::get('payments/show/{id}',          array('as' => 'admin.payments.show', 'uses' => 'admin\\PaymentsController@show'));
        Route::get('payments/cheque',             array('as' => 'admin.payments.cheque_list', 'uses' => 'admin\\PaymentsController@chequeList'));
        Route::get('payments/show_cheque/{id}',   array('as' => 'admin.payments.show_cheque', 'uses' => 'admin\\PaymentsController@showCheque'));
        Route::post('payments/cheque/update',     array('as' => 'admin.payments.update_cheque', 'uses' => 'admin\\PaymentsController@updateCheque'));
        Route::post('payments/fetchBillNo',     array('as' => 'admin.payments.fetchBillNo', 'uses' => 'admin\\PaymentsController@fetchBillNo'));
        Route::get('payments/card',             array('as' => 'admin.payments.card_list', 'uses' => 'admin\\PaymentsController@cardList'));
        Route::get('payments/payment_ajax',  array('as'=>'admin.payments.payment_ajax','uses'=>'admin\\PaymentsController@paymentAjax'));
        Route::get('payments/edit/{id}',  array('as'=>'admin.payments.edit','uses'=>'admin\\PaymentsController@edit'));
        Route::post('payments/update',  array('as'=>'admin.payments.update','uses'=>'admin\\PaymentsController@update'));
        Route::get('payments/payment_user',  array('as'=>'admin.payments.payment_user','uses'=>'admin\\PaymentsController@userPayment'));
        Route::get('payments/cheque_ajax',   array('as' => 'admin.payments.cheque_ajax', 'uses' => 'admin\\PaymentsController@chequeAjax'));
        Route::get('payments/card_ajax',             array('as' => 'admin.payments.card_ajax', 'uses' => 'admin\\PaymentsController@cardAjax'));
        
        //users-old...
        Route::get('users-old',             array('as' => 'admin.users_old.index', 'uses' => 'admin\\UserOldController@index'));
        Route::get('users-old/show/{id}',   array('as' => 'admin.users_old.show', 'uses' => 'admin\\UserOldController@show'));
        Route::get('users-old/showpassword/{id}',array('as' => 'admin.users_old.showpassword', 'uses' => 'admin\\UserOldController@showpassword'));
        Route::get('users-old/edit/{id}',   array('as' => 'admin.users_old.edit', 'uses' => 'admin\\UserOldController@edit'));
        Route::post('users-old/update/{id}',array('as' => 'admin.users_old.update', 'uses' => 'admin\\UserOldController@update'));
        Route::get('users-old/notify-password/{id}',array('as' => 'admin.users_old.notify_password',
                'uses' => 'admin\\UserOldController@notifyPassword'));
        Route::get('users-old/cust_ajax',array('as' => 'admin.users_old.cust_ajax', 'uses' => 'admin\\UserOldController@custAjax'));
        Route::get('users-old/log_ajax',array('as' => 'admin.users_old.log_ajax', 'uses' => 'admin\\UserOldController@logAjax'));
        Route::get('users-old/active_session_ajax',array('as' => 'admin.users_old.active_session_ajax', 'uses' => 'admin\\UserOldController@activeSessionAjax'));
        Route::get('users-old/ticket_ajax',array('as' => 'admin.users_old.ticket_ajax', 'uses' => 'admin\\UserOldController@TicketAjax'));


        Route::get('users-old/activation_details',array('as' => 'admin.users_old.activation_details', 'uses' => 'admin\\UserOldController@ActivationDetails'));
        Route::post('users-old/post_activation_details',array('as' => 'admin.users_old.post_activation_details', 'uses' => 'admin\\UserOldController@PostActivationDetails'));
        Route::get('users-old/get_activation_details',array('as' => 'admin.users_old.get_activation_details', 'uses' => 'admin\\UserOldController@GetActivationDetails'));
        Route::get('users-old/ajax_activation_details',array('as' => 'admin.users_old.ajax_activation_details', 'uses' => 'admin\\UserOldController@AjaxActivationDetails'));
        Route::get('users-old/total_activation_details',array('as' => 'admin.users_old.total_activation_details', 'uses' => 'admin\\UserOldController@totalActivationDetails'));
        Route::get('users-old/approved/{id}',array('as' => 'admin.users_old.approved', 'uses' => 'admin\\UserOldController@SetApproved'));
        Route::get('users-old/set-employee',array('as' => 'admin.users_old.set-employee', 'uses' => 'admin\\UserOldController@SetEmployee'));

        Route::get('users-old/plan_change_details',array('as' => 'admin.users_old.plan_change_details', 'uses' => 'admin\\UserOldController@PlanChangeDetails'));
        Route::post('users-old/post_plan_change_details',array('as' => 'admin.users_old.post_plan_change_details', 'uses' => 'admin\\UserOldController@PostPlanChangeDetails'));
        Route::get('users-old/get_plan_change_details',array('as' => 'admin.users_old.get_plan_change_details', 'uses' => 'admin\\UserOldController@GetPlanChangeDetails'));
        Route::get('users-old/ajax_plan_change_details',array('as' => 'admin.users_old.ajax_plan_change_details', 'uses' => 'admin\\UserOldController@AjaxPlanChangeDetails'));


        Route::get('users-old/ticket-popup/{id}',   array('as' => 'admin.users_old.ticket-popup', 'uses' => 'admin\\UserOldController@ticketPopup'));
        Route::get('users-old/datausage-popup/{id}',array('as' => 'admin.users_old.datausage-popup', 'uses' => 'admin\\UserOldController@datausagePopup'));
        Route::get('users-old/payment-popup/{id}',  array('as' => 'admin.users_old.payment-popup', 'uses' => 'admin\\UserOldController@paymentPopup'));
        Route::get('users-old/bill-popup/{id}',     array('as' => 'admin.users_old.bill-popup', 'uses' => 'admin\\UserOldController@billPopup'));
        Route::get('users-old/feasible-popup/{id}', array('as' => 'admin.users_old.feasible-popup', 'uses' => 'admin\\UserOldController@feasiblePopup'));

        Route::post('sms/postsendsms',array('as' => 'admin.sms.postsendsms', 'uses' => 'admin\\UserOldController@postSendsms'));
        Route::get('sms/getsendsms',array('as' => 'admin.sms.getsendsms', 'uses' => 'admin\\UserOldController@getSendsms'));

       //adjustments...
        Route::get('adjustments',          array('as' => 'admin.adjustments.index', 'uses' => 'admin\\AdjustmentsController@index'));
        Route::get('adjustments/ajax',          array('as' => 'admin.adjustments.index_ajax', 'uses' => 'admin\\AdjustmentsController@indexAjax'));
        Route::get('adjustments/create',   array('as' => 'admin.adjustments.create', 'uses' => 'admin\\AdjustmentsController@create'));
        Route::get('adjustments/edit/{id}',array('as' => 'admin.adjustments.edit', 'uses' => 'admin\\AdjustmentsController@edit'));
        Route::post('adjustments/store',   array('as' => 'admin.adjustments.store', 'uses' => 'admin\\AdjustmentsController@store'));
        Route::post('adjustments/update',  array('as' => 'admin.adjustments.update', 'uses' => 'admin\\AdjustmentsController@update'));
        Route::get('adjustments/fetch-adjustment-cost-details', array('as' => 'admin.adjustments.fetch_adjustment_cost_details', 'uses' => 'admin\\AdjustmentsController@fetchAdjustmentCostDetails'));

        Route::get('discounts',          array('as' => 'admin.discounts.index', 'uses' => 'admin\\DiscountsController@index'));
        Route::get('discounts/ajax',          array('as' => 'admin.discounts.index_ajax', 'uses' => 'admin\\DiscountsController@indexAjax'));
        Route::get('discounts/create',   array('as' => 'admin.discounts.create', 'uses' => 'admin\\DiscountsController@create'));
        Route::get('discounts/edit/{id}',array('as' => 'admin.discounts.edit', 'uses' => 'admin\\DiscountsController@edit'));
        Route::post('discounts/store',    array('as' => 'admin.discounts.store', 'uses' => 'admin\\DiscountsController@store'));
        Route::post('discounts/update',  array('as' => 'admin.discounts.update', 'uses' => 'admin\\DiscountsController@update'));
        Route::get('discounts/fetch-discount-cost-details', array('as' => 'admin.discounts.fetch_discount_cost_details', 'uses' => 'admin\\DiscountsController@fetchDiscountCostDetails'));

        Route::get('devicecost',          array('as' => 'admin.devicecost.index', 'uses' => 'admin\\DevicecostController@index'));
        Route::get('devicecost/ajax',          array('as' => 'admin.devicecost.index_ajax', 'uses' => 'admin\\DevicecostController@indexAjax'));
        Route::get('devicecost/create',   array('as' => 'admin.devicecost.create', 'uses' => 'admin\\DevicecostController@create'));
        Route::get('devicecost/edit/{id}',array('as' => 'admin.devicecost.edit', 'uses' => 'admin\\DevicecostController@edit'));
        Route::post('devicecost/store',    array('as' => 'admin.devicecost.store', 'uses' => 'admin\\DevicecostController@store'));
        Route::post('devicecost/update',  array('as' => 'admin.devicecost.update', 'uses' => 'admin\\DevicecostController@update'));
        Route::get('devicecost/fetch-device-cost-details', array('as' => 'admin.devicecost.fetch_device_cost_details', 'uses' => 'admin\\DevicecostController@fetchDeviceCostDetails'));

        Route::get('othercharges',          array('as' => 'admin.othercharges.index', 'uses' => 'admin\\OtherchargesController@index'));
        Route::get('othercharges/ajax',          array('as' => 'admin.othercharges.index_ajax', 'uses' => 'admin\\OtherchargesController@indexAjax'));
        Route::get('othercharges/create',    array('as' => 'admin.othercharges.create', 'uses' => 'admin\\OtherchargesController@create'));
        Route::get('othercharges/edit/{id}', array('as' => 'admin.othercharges.edit', 'uses' => 'admin\\OtherchargesController@edit'));
        Route::post('othercharges/store',    array('as' => 'admin.othercharges.store', 'uses' => 'admin\\OtherchargesController@store'));
        Route::post('othercharges/update',   array('as' => 'admin.othercharges.update', 'uses' => 'admin\\OtherchargesController@update'));
        Route::get('othercharges/fetch-othercharge-cost-details', array('as' => 'admin.othercharges.fetch_othercharge_cost_details', 'uses' => 'admin\\OtherchargesController@fetchOtherchargeCostDetails'));
       //employees....
        Route::get('employees',             array('as' => 'admin.employees.index', 'uses' => 'admin\\EmployeesController@index'));
        Route::get('employees/create',      array('as' => 'admin.employees.create', 'uses' => 'admin\\EmployeesController@create'));
        Route::post('employees/store',      array('as' => 'admin.employees.store', 'uses' => 'admin\\EmployeesController@store'));
        Route::get('employees/edit/{id}',   array('as' => 'admin.employees.edit', 'uses' => 'admin\\EmployeesController@edit'));
        Route::post('employees/update',     array('as' => 'admin.employees.update', 'uses' => 'admin\\EmployeesController@update'));
        Route::get('employees/delete/{id}', array('as' => 'admin.employees.delete', 'uses' => 'admin\\EmployeesController@delete'));
        Route::get('employees/assign', array('as' => 'admin.employees.assign', 'uses' => 'admin\\EmployeesController@assign'));
        Route::post('employees/assign_roles', array('as' => 'admin.employees.assign_roles', 'uses' => 'admin\\EmployeesController@assignRoles'));
        
        Route::get('employees/team', array('as' => 'admin.employees.team', 'uses' => 'admin\\EmployeesController@Team'));
        Route::get('employees/team_edit/{id}', array('as' => 'admin.employees.team_edit', 'uses' => 'admin\\EmployeesController@TeamEdit'));
        Route::post('employees/team_edit_post', array('as' => 'admin.employees.team_edit_post', 'uses' => 'admin\\EmployeesController@TeamEditPost'));

        Route::get('employees/team_create', array('as' => 'admin.employees.team_create', 'uses' => 'admin\\EmployeesController@TeamCreate'));
        Route::post('employees/team_post', array('as' => 'admin.employees.team_post', 'uses' => 'admin\\EmployeesController@TeamPost'));


         

        //roles....
        Route::get('roles',             array('as' => 'admin.roles.index', 'uses' => 'admin\\RolesController@index'));          
        Route::get('roles/create',      array('as' => 'admin.roles.create', 'uses' => 'admin\\RolesController@create'));         
        Route::post('roles/store',      array('as' => 'admin.roles.store', 'uses' => 'admin\\RolesController@store'));           
        Route::get('roles/edit/{id}',   array('as' => 'admin.roles.edit', 'uses' => 'admin\\RolesController@edit'));          
        Route::post('roles/update',     array('as' => 'admin.roles.update', 'uses' => 'admin\\RolesController@update'));    
        Route::get('roles/delete/{id}', array('as' => 'admin.roles.delete', 'uses' => 'admin\\RolesController@delete'));
        Route::get('roles/{id}/change-permission', array('as' => 'admin.roles.change_permission', 'uses' => 'admin\\RolesController@changePermission'));
        Route::post('roles/update-permission',     array('as' => 'admin.roles.update_permission', 'uses' => 'admin\\RolesController@updatePermission'));

        //Documents
        Route::post('documents/store',     array('as' => 'admin.documents.store', 'uses' => 'admin\\DocumentsController@store'));          
        Route::get('documents/delete/{id}',array('as' => 'admin.documents.delete', 'uses' => 'admin\\DocumentsController@delete'));
        Route::post('documents/cropImage',array('as' => 'admin.documents.crop', 'uses' => 'admin\\DocumentsController@cropImage')); 
        Route::post('documents/cropImage',array('as' => 'admin.documents.crop', 'uses' => 'admin\\DocumentsController@cropImage'));          
        Route::get('documents/{id}/create',array('as' => 'admin.documents.create', 'uses' => 'admin\\DocumentsController@create'));
        
        Route::get('topup/index',array('as' => 'admin.topup.index', 'uses' => 'admin\\TopupController@index')); 
        Route::get('topup/waivertopup',array('as' => 'admin.topup.waivertopup', 'uses' => 'admin\\TopupController@WaiverTopup')); 
        Route::post('topup/showdata',  array('as' => 'admin.topup.showdata', 'uses' => 'admin\\TopupController@showData')); 
        Route::get('topup/plandetails',array('as' => 'admin.topup.plandetail', 'uses' => 'admin\\TopupController@PlanDetails')); 
        Route::post('topup/store',     array('as' => 'admin.topup.store', 'uses' => 'admin\\TopupController@store')); 
        Route::get('topup/topupdetails',array('as' => 'admin.topup.topupdetail', 'uses' => 'admin\\TopupController@TopupDetails')); 
        Route::get('topup/topupdetails_ajax',array('as' => 'admin.topup.topupdetail_ajax', 'uses' => 'admin\\TopupController@TopupDetailsAjax')); 
        
        Route::get('planchange/index',           array('as' => 'admin.planchange.index', 'uses' => 'admin\\PlanchangeController@index')); 
        Route::get('planchange/fetch-account-id',array('as' => 'admin.planchange.fetch-account_id', 'uses' => 'admin\\PlanchangeController@FetchAccountId')); 
        Route::get('planchange/fetchPlanDet',    array('uses' => 'admin\\PlanchangeController@fetchPlanDet')); 
        Route::get('planchange/monthSub',        array('uses' => 'admin\\PlanchangeController@monthSub')); 
        Route::post('planchange/store',          array('as' => 'admin.planchange.store', 'uses' => 'admin\\PlanchangeController@store')); 
        




        Route::get('checks/billpaymentchecks', array('as' => 'admin.checks.billpaymentchecks', 'uses' => 'admin\\PaymentChecksController@BillPaymentCheck'));   
        Route::get('checks/paymentchecks', array('as' => 'admin.checks.paymentchecks', 'uses' => 'admin\\PaymentChecksController@PaymentCheck'));
        Route::get('checks/paymentchecks_ajax', array('as' => 'admin.checks.paymentchecks_ajax', 'uses' => 'admin\\PaymentChecksController@PaymentCheckAjax'));
        Route::get('checks/billchecks_ajax', array('as' => 'admin.checks.billchecks_ajax', 'uses' => 'admin\\PaymentChecksController@BillCheckAjax'));                 
        Route::get('checks/billchecks', array('as' => 'admin.checks.billchecks', 'uses' => 'admin\\PaymentChecksController@BillCheck'));                 
        Route::get('checks/bill_payment_ajax', array('as' => 'admin.checks.bill_payment_ajax', 'uses' => 'admin\\PaymentChecksController@BillPaymentCheckAjax'));   
        Route::get('checks/not_paid_active', array('as' => 'admin.checks.not_paid_active', 'uses' => 'admin\\PaymentChecksController@NotPaidActive')); 
        Route::get('checks/not_paid_active_ajax', array('as' => 'admin.checks.not_paid_active_ajax', 'uses' => 'admin\\PaymentChecksController@NotPaidActiveAjax'));                 


        Route::get('switch-router/index', array('as' => 'admin.switch_router.index', 'uses' => 'admin\\SwitchRouterController@index'));   
        Route::get('switch-router/swtich_ajax', array('as' => 'admin.switch_router.swtich_ajax', 'uses' => 'admin\\SwitchRouterController@switchRouterAjax'));   
        Route::get('switch-router/create', array('as' => 'admin.switch_router.ceate', 'uses' => 'admin\\SwitchRouterController@create'));   
        Route::post('switch-router/store', array('as' => 'admin.switch_router.store', 'uses' => 'admin\\SwitchRouterController@store'));  

        Route::get('switch_router-tag/index', array('as' => 'admin.switch_router_tag.index', 'uses' => 'admin\\SwitchRouterController@TAGindex'));   
        Route::get('switch_router-tag/tag_ajax', array('as' => 'admin.switch_router_tag.tag_ajax', 'uses' => 'admin\\SwitchRouterController@TAGswitchRouterAjax'));   
        Route::get('switch_router-tag/create', array('as' => 'admin.switch_router_tag.ceate', 'uses' => 'admin\\SwitchRouterController@TAGcreate'));   
        Route::post('switch_router-tag/store', array('as' => 'admin.switch_router_tag.store', 'uses' => 'admin\\SwitchRouterController@TAGstore')); 

        
        Route::get('switch_router/stock_in', array('as' => 'admin.switch_router.stock_in', 'uses' => 'admin\\SwitchRouterController@StockIn')); 
        Route::post('switch_router/create_stock_in', array('as' => 'admin.switch_router.create_stock_in', 'uses' => 'admin\\SwitchRouterController@CreateStockIn')); 

        Route::get('switch_router/stock_out', array('as' => 'admin.switch_router.stock_out', 'uses' => 'admin\\SwitchRouterController@StockOut')); 
        Route::post('switch_router/create_stock_out', array('as' => 'admin.switch_router.create_stock_out', 'uses' => 'admin\\SwitchRouterController@CreateStockOut')); 
        Route::get('switch_router/check_stock', array('as' => 'admin.switch_router.check_stock', 'uses' => 'admin\\SwitchRouterController@CheckStock')); 
        
        Route::get('switch_router/stock_update', array('as' => 'admin.switch_router.stock_update', 'uses' => 'admin\\SwitchRouterController@StockUpdate')); 
        Route::post('switch_router/update_stock', array('as' => 'admin.switch_router.update_stock', 'uses' => 'admin\\SwitchRouterController@UpdateStock')); 
        
        Route::get('switch_router/stock_update_ajax', array('as' => 'admin.switch_router.stock_update_ajax', 'uses' => 'admin\\SwitchRouterController@StockUpdateAjax')); 
        Route::get('switch_router/stock_update_det/{id}', array('as' => 'admin.switch_router.stock_update_det', 'uses' => 'admin\\SwitchRouterController@StockUpdateDet')); 
        Route::get('switch_router/stock_updates', array('as' => 'admin.switch_router.stock_updates', 'uses' => 'admin\\SwitchRouterController@StockUpdates')); 
        Route::get('switch_router/stock_update_device', array('as' => 'admin.switch_router.stock_update_device', 'uses' => 'admin\\SwitchRouterController@StockUpdateDevice')); 
        Route::get('switch_router/stock_emp_update/{id}', array('as' => 'admin.switch_router.stock_emp_update', 'uses' => 'admin\\SwitchRouterController@StockEmployUpdate')); 
        Route::get('switch_router/update_stock_det', array('as' => 'admin.switch_router.update_stock_det', 'uses' => 'admin\\SwitchRouterController@UpdateStockDet')); 
        Route::get('switch_router/update_stock_det_ajax', array('as' => 'admin.switch_router.update_stock_det_ajax', 'uses' => 'admin\\SwitchRouterController@UpdateStockDetAjax')); 
        
        Route::get('switch_router/category', array('as' => 'admin.switch_router.category', 'uses' => 'admin\\SwitchRouterController@Category')); 
        Route::post('switch_router/create_category', array('as' => 'admin.switch_router.create_category', 'uses' => 'admin\\SwitchRouterController@createCategory')); 
        Route::get('switch_router/showcategory', array('as' => 'admin.switch_router.showcategory', 'uses' => 'admin\\SwitchRouterController@showCategory')); 

        Route::get('switch_router/check_preactivation', array('as' => 'admin.switch_router.check_preactivation', 'uses' => 'admin\\SwitchRouterController@CheckPreActivation')); 
        Route::get('switch_router/count_details', array('as' => 'admin.switch_router.count_details', 'uses' => 'admin\\SwitchRouterController@countDetails')); 

        Route::get('stock_report/category_report', array('as' => 'admin.stock_report.category_report', 'uses' => 'admin\\StockReportsController@CateGoryReport')); 
        Route::get('stock_report/category_report_ajax', array('as' => 'admin.stock_report.category_report_ajax', 'uses' => 'admin\\StockReportsController@CateGoryReportAjax')); 
        Route::get('stock_report/stock-report/{id}', array('as' => 'admin.stock_report.stock-report', 'uses' => 'admin\\StockReportsController@StockReport')); 
        Route::get('stock_report/stock-report_ajax', array('as' => 'admin.stock_report.stock-report_ajax', 'uses' => 'admin\\StockReportsController@StockReportAjax')); 
        Route::get('stock_report/stock-report_meter/{id}', array('as' => 'admin.stock_report.stock-report_meter', 'uses' => 'admin\\StockReportsController@StockReportMeter')); 

        Route::get('network/server-status', array('as' => 'admin.network.server-status', 'uses' => 'admin\\NetworkController@ServerStatus')); 
        Route::get('network/server-status_ajax', array('as' => 'admin.network.server-status_ajax', 'uses' => 'admin\\NetworkController@ServerStatusAjax')); 
        Route::get('network/server_create', array('as' => 'admin.network.server_create', 'uses' => 'admin\\NetworkController@ServerCreate'));
        Route::post('network/server_post', array('as' => 'admin.network.server_post', 'uses' => 'admin\\NetworkController@ServerPost')); 

        
        Route::get('network/otdr_create', array('as' => 'admin.network.otdr_create', 'uses' => 'admin\\NetworkController@OtdrCreate')); 
        Route::post('network/otdr_post', array('as' => 'admin.network.otdr_post', 'uses' => 'admin\\NetworkController@OtdrPost')); 
        Route::get('network/otdr', array('as' => 'admin.network.otdr', 'uses' => 'admin\\NetworkController@Otdr')); 
        Route::get('network/otdr_ajax', array('as' => 'admin.network.otdr_ajax', 'uses' => 'admin\\NetworkController@OtdrAjax')); 

        Route::get('network/incident', array('as' => 'admin.network.incident', 'uses' => 'admin\\NetworkController@Incident'));
        Route::get('network/incident_ajax', array('as' => 'admin.network.incident_ajax', 'uses' => 'admin\\NetworkController@IncidentAjax')); 
        Route::get('network/incident_show/{id}', array('as' => 'admin.network.incident_show', 'uses' => 'admin\\NetworkController@IncidentShow')); 
        Route::post('network/incident_update', array('as' => 'admin.network.incident_update', 'uses' => 'admin\\NetworkController@IncidentUpdate')); 

        Route::get('network/session_area', array('as' => 'admin.network.session_area', 'uses' => 'admin\\NetworkController@SessionArea'));
        Route::get('network/session_area_ajax', array('as' => 'admin.network.session_area_ajax', 'uses' => 'admin\\NetworkController@SessionAreaAjax'));


        
        Route::get('billwaiver/index', array('as' => 'admin.billwaiver.index', 'uses' => 'admin\\AdjustmentsController@billwaiver'));   
        Route::get('billwaiver/index_ajax', array('as' => 'admin.billwaiver.index_ajax', 'uses' => 'admin\\AdjustmentsController@billwaiverAjax'));
        Route::get('billwaiver/create', array('as' => 'admin.billwaiver.create', 'uses' => 'admin\\AdjustmentsController@billwaiverCreate'));
        Route::post('billwaiver/store', array('as' => 'admin.billwaiver.store', 'uses' => 'admin\\AdjustmentsController@billwaiverStore'));  
        Route::get('billwaiver/update/{id}', array('as' => 'admin.billwaiver.update', 'uses' => 'admin\\AdjustmentsController@billwaiverUpdate'));  
        Route::get('billwaiver/edit/{id}', array('as' => 'admin.billwaiver.edit', 'uses' => 'admin\\AdjustmentsController@billwaiverEdit'));
        Route::post('billwaiver/edit_update', array('as' => 'admin.billwaiver.edit_update', 'uses' => 'admin\\AdjustmentsController@billwaiverEditUpdate'));  

    });
        
});


Route::group( array('domain' => 'test.accounts.oodoo.co.in' ), function() {

        Route::group(array('before' => 'auth.user'), function() {
    

        // profile, edit, change-password
        Route::get('/',  array('as' => 'users.dashboard', 'uses' => 'user\\DashboardController@dashboard'));
        Route::get('profile', array('as' => 'users.profile', 'uses' => 'user\\UsersController@view'));
        Route::get('users/edit', array('as' => 'users.edit', 'uses' => 'user\\UsersController@edit'));
        Route::get('users/change-password', array('as' => 'users.change_password', 'uses' => 'user\\UsersController@change_password'));
        Route::post('users/update', array('as' => 'users.update', 'uses' => 'user\\UsersController@update'));


        //bill details
        Route::get('bills', array('as' => 'users.bills.index', 'uses' => 'user\\BillsController@index'));
        Route::get('pay-bill', array('as' => 'users.bills.payBill', 'uses' => 'user\\BillsController@payBill'));
        Route::get('bills/view/{bill_no}', array('as' => 'users.bills.view', 'uses' => 'user\\BillsController@view'));

        // new payment 
        Route::get('payment', array('as' => 'users.payment.index', 'uses' => 'user\\PaymentConfirmController@index'));
        Route::get('payment/payment_confirm', array('as' => 'users.payment.payment_confirm', 'uses' => 'user\\PaymentConfirmController@payment_confirm'));
        Route::post('payment/payment_process', array('as' => 'users.payment.payment_process', 'uses' => 'user\\PaymentConfirmController@payment_process'));
        Route::post('payment/payment_success', array('as' => 'users.payment.payment_success', 'uses' => 'user\\PaymentStatusController@payment_success'));
        Route::post('payment/payment_failed', array('as' => 'users.payment.payment_failed', 'uses' => 'user\\PaymentStatusController@payment_failed'));




        //payment details
            /*Route::post('payments/confirm-payment', array('as' => 'users.payments.confirmPayment', 'uses' => 'user\\PaymentsController@confirmPayment'));
            Route::get('payments/confirm-payment', array('as' => 'users.payments.confirmPayment', 'uses' => 'user\\PaymentsController@confirmPayment'));
            Route::post('payments/payment-success', array('as' => 'users.payments.payment_success', 'uses' => 'user\\PaymentsController@payment_success'));
            Route::post('payments/payment-failed', array('as' => 'users.payments.payment_failed', 'uses' => 'user\\PaymentsController@payment_failed'));
            */
            
        //sessions
        Route::get('data_usage', array('as' => 'users.sessions.data_usage', 'uses' => 'user\\SessionController@data_usage'));
        Route::get('session_usage', array('as' => 'users.sessions.session_usage', 'uses' => 'user\\SessionController@session_history'));
        Route::post('session_usage', array('as' => 'users.sessions.session_usage', 'uses' => 'user\\SessionController@session_history'));

        
        //Topup  
        Route::get('topup', array('as' => 'users.topup.topup', 'uses' => 'user\\TopupController@topup'));
        Route::post('topup', array('as' => 'users.topup.topup', 'uses' => 'user\\TopupController@topup'));
        Route::post('topup_store', array('as' => 'users.topup.topup_store', 'uses' => 'user\\TopupController@topup_store'));
        Route::get('pay_topup', array('as' => 'users.topup.pay_topup', 'uses' => 'user\\TopupController@pay_topup'));

        //Plan change
        Route::get('plan_change', array('as' => 'users.planchange.plan_change', 'uses' => 'user\\PlanChangeController@plan_change'));
        Route::post('planchange_store', array('as' => 'users.planchange.planchange_store', 'uses' => 'user\\PlanChangeController@planchange_store'));
        Route::get('plan_change/fetch_plan_det', array('as' => 'users.planchange.plan_change', 'uses' => 'user\\PlanChangeController@fetch_plan_det'));
        Route::post('month_sub', array('as' => 'users.planchange.month_sub', 'uses' => 'user\\PlanChangeController@month_sub'));
        

        //support
        Route::get('support', array('as' => 'users.support.index', 'uses' => 'user\\SupportController@index'));
        Route::get('complaint', array('as' => 'users.support.complaint', 'uses' => 'user\\SupportController@complaint'));
        Route::post('complaint_store', array('as' => 'users.support.complaint_store', 'uses' => 'user\\SupportController@complaint_store'));

        //faq
        Route::get('/faq',array('as' => 'users.faq.index','uses'=>'user\\FaqController@index'));

    });
        // login, reset password
        Route::get('user/logout',  array('as' => 'user.logout', 'uses' => 'user\\UserAuthController@getLogout'));
        Route::get('user/login',   array('as' => 'user.login',  'uses' => 'user\\UserAuthController@getLogin'));
        Route::post('user/login',   array('as' => 'user.login', 'uses' => 'user\\UserAuthController@postLogin'));
        Route::post('users/forgot-password-request', array('as' => 'users.forgotPasswordRequest', 'uses' => 'user\\UserAuthController@forgotPasswordRequest'));
        Route::get('users/reset-password-request', array('as' => 'users.resetPasswordRequest', 'uses' => 'user\\UserAuthController@resetPasswordRequest'));
        Route::post('users/reset-password', array('as' => 'users.resetPassword', 'uses' => 'user\\UserAuthController@resetPassword'));

        });

    Route::group( array('domain' => 'test.pay.oodoo.co.in' ), function() {

        Route::get('/',  array('as' => 'users.anonymous_pay', 'uses' => 'user\\AnonymousPaymentsController@anonymousPay'));
        Route::get('/pay',  array('as' => 'users.anonymous_pay', 'uses' => 'user\\AnonymousPaymentsController@anonymousPay'));

        Route::post('payments/anonymous-confirm-payment', array('as' => 'users.payments.anonymousConfirmPayment', 'uses' => 'user\\AnonymousPaymentsController@confirmPayment'));
        Route::get('/payments/anonymous-get-bill-no', array('as' => 'users.payments.anonymousGetBillNo', 'uses' => 'user\\AnonymousPaymentsController@getBillNoAjax'));
        Route::post('payments/anonymous-payment-success', array('as' => 'users.payments.anonymous_payment_success', 'uses' => 'user\\AnonymousPaymentsController@payment_success'));
        Route::post('payments/anonymous-payment-failed', array('as' => 'users.payments.anonymous_payment_failed', 'uses' => 'user\\AnonymousPaymentsController@payment_failed'));

    });


    Route::group( array('domain' => 'test.data.oodoo.co.in' ), function() {

        Route::get('/',  array('as' => '', 'uses' => 'user\\UserDataController@index'));

    });



    Route::group( array('domain' => 'support.wtest.oodoo.co.in' ), function() {
    
    Route::group( array('before' => 'auth.support'), function() {

        Route::get('/navbar', array('as' => '', 'uses' => 'support\\DashboardController@navbar' ));

        Route::get('/query', array('as' => 'support.query', 'uses' => 'support\\SupportController@query'));
        Route::get('/userDet', array('as'=> 'support.userDet', 'uses' => 'support\\SupportController@query'));
        Route::get('/userDet/{account_id}', array('as' => '', 'uses' => 'support\\SupportController@index'));
        Route::post('query', array('as' => '', 'uses' => 'support\\SupportController@query'));
        Route::get('userDetails', array('as' => '', 'uses' => 'support\\SupportController@userDetails'));


        Route::get('mailSupport', array('as' => '', 'uses' => 'MailController@index'));
        Route::post('mailSupport', array('as' => '', 'uses' => 'MailController@index'));
        Route::get('mailSupport/{id}', array('as'=>'', 'uses' => 'MailController@ticket'));
        Route::post('mailSupport/{id}', array('as'=>'', 'uses' => 'MailController@ticket'));  
        
        Route::get('replyMessage',array('as'=>'', 'uses'=> 'MailController@replyMessage'));  
        Route::post('addNote', array('as' => '', 'uses'=> 'MailController@addNote'));    

        Route::get('mailSupports', array('as' => '', 'uses' => 'ApiController@update'));
        Route::get('mailSupportio', array('as' => '', 'uses' => 'MailController@updateMessage'));
        Route::get('mailType', array('as' => '', 'uses' => 'MailController@mailType'));
        Route::get('/oauth2callback', array('as' => '', 'uses' => 'MailController@index'));

        Route::get('payment', array('as' => '', 'uses' => 'support\\SupportController@payment_det'));
        Route::get('bill', array('as' => '', 'uses' => 'support\\SupportController@bill_det'));
        Route::get('session', array('as' => '', 'uses' => 'support\\SupportController@session_det'));  
        Route::get('usage', array('as' => '', 'uses' => 'support\\SupportController@usage_det'));  
        Route::get('ticket', array('as' => '', 'uses' => 'support\\SupportController@ticket_det')); 
        Route::get('log', array('as' => '', 'uses' => 'support\\SupportController@log_det'));
        Route::get('active_session', array('as' => '', 'uses' => 'support\\SupportController@active_session_det'));
        Route::get('bill_waiver', array('as' => '', 'uses' => 'support\\SupportController@bill_waiver_det'));
        Route::get('notifyPassword/{id}', array('as' => '', 'uses' => 'support\\SupportController@notifyPassword'));

        Route::get('ticketCheck', array('as' => '', 'uses' => 'support\\TicketController@ticketCheck'));
        Route::post('ticket/store', array('as' => '', 'uses' => 'support\\TicketController@store'));
        Route::get('callDet', array('as'=>'', 'uses' => 'support\\TicketController@callDet'));
        Route::get('exo_call_status', array('as' => '', 'uses' => 'support\\TicketController@exo_call_status'));
        Route::get('ticket_popup/{id}', array('as' => '', 'uses' => 'support\\TicketController@ticket_popup'));
        Route::post('ticket/message',     array('as' => '', 'uses' => 'support\\TicketController@message'));  
        Route::post('ticket/status',     array('as' => '', 'uses' => 'support\\TicketController@status')); 
        Route::post('ticket/send',     array('as' => '', 'uses' => 'support\\TicketController@sendTicket'));         
        Route::get('sendNotify', array('as' => '', 'uses' => 'support\\DashboardController@sendNotify'));
        Route::get('findTicket', array('as' => '', 'uses' => 'support\\TicketController@findTicket'));

        Route::get('setEmployee', array('as' =>' ', 'uses' => 'support\\TicketController@setEmployee'));




        });
        
        Route::get('/login',  array('as' => 'support.login', 'uses' => 'support\\AuthController@index'));
        Route::post('/login',  array('as' => 'support.login', 'uses' => 'support\\AuthController@login')); 
        Route::get('/logout', array('as' => 'support.logout', 'uses' => 'support\\AuthController@logout'));
        Route::get('/forgetPass', array('as' => 'support.forget_pass', 'uses' => 'support\\AuthController@getForgotPass'));
        Route::post('/request-forget-password', array('as' => '','uses' => 'support\\AuthController@requestForgetPassword'));
        Route::get('/reset-password-request',   array('as' => '','uses' => 'support\\AuthController@resetPasswordRequest'));
        Route::post('/reset-password',   array('as' => '','uses' => 'support\\AuthController@resetPassword'));



    }); 

  




#http://localhost:3000/qr_code/index?utf8=%E2%9C%93&device=OFLCO&model_no=1234567&count=24&commit=Submit
