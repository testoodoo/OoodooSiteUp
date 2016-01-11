@extends('admin.layouts.default')
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
            <a href="/admin/network/session_area">session area</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Session Area Wise
    </h1>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td>Area</td>
                <td>Total Customers</td>
                <td>Active Customers</td>
                <td>Fault Customers</td>
                <td>Expired Cusotmers</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
 jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
                autoWidth: false,
                       "ajax": '/admin/network/session_area_ajax',
                       "type":'get',
         
             "aoColumns": [
                              { mData: 'area' },
                              { mData: 'total' },
                              { mData: 'active' },
                              { mData: 'fault' },
                              { mData: 'expired' }
                           ]

            });
      /*  setInterval( function () {
                    oTable.fnReloadAjax();
                    },15000 );*/
     });

 </script>

@stop