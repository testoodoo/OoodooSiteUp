@extends('support.layouts.default')
@section('main')
<div class="page-content">
<div class="col-lg-6">
    <div class="panel panel-yellow">
        <div class="panel-heading">Simple Table</div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Henry</td>
                        <td>23</td>
                        <td>
                            <span class="label label-sm label-success">Approved</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>John</td>
                        <td>45</td>
                        <td>
                            <span class="label label-sm label-info">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>30</td>
                        <td>
                            <span class="label label-sm label-warning">Suspended</span>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lahm</td>
                        <td>15</td>
                        <td>
                            <span class="label label-sm label-danger">Blocked</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-green">
        <div class="panel-heading">Bordered Table</div>
        <div class="panel-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Henry</td>
                        <td>23</td>
                        <td>
                            <span class="label label-sm label-success">Approved</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>John</td>
                        <td>45</td>
                        <td>
                            <span class="label label-sm label-info">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>30</td>
                        <td>
                            <span class="label label-sm label-warning">Suspended</span>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lahm</td>
                        <td>15</td>
                        <td>
                            <span class="label label-sm label-danger">Blocked</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-blue" style="background:#FFF;">
        <div class="panel-heading">Variations Table</div>
        <div class="panel-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Henry</td>
                        <td>23</td>
                        <td>
                            <span class="label label-sm label-success">Approved</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>John</td>
                        <td>45</td>
                        <td>
                            <span class="label label-sm label-info">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>30</td>
                        <td>
                            <span class="label label-sm label-warning">Suspended</span>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lahm</td>
                        <td>15</td>
                        <td>
                            <span class="label label-sm label-danger">Blocked</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>
                            <i>4 People</i>
                        </th>
                        <th></th>
                        <th>
                            <i>1 Approved</i>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>


@stop