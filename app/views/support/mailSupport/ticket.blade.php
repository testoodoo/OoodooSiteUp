@extends('support.layouts.default')
@section('main')
<div class="page-content">
	<div class="row">
		<div class="col-lg-9">
		    <div class="panel panel-blue" style="background:#FFF;">
		        <div class="panel-heading">Mail Support</div>
		        <div class="panel-body">
		        <h3>{{$subject}}</h3>
				@foreach($mails as $mail)
					<table class="table table-hover table-bordered">
					    <thead>
					        <tr>
					            <th>
					            <span class="pull-right" onLoad="time_elapsed_string({{$mail->time}});">
					            {{$mail->time}}
					            </span> </th>
				            <tr>
				            	<th> {{$mail->body}} </th>
				            </tr>
					        </tr>
					    </thead>
					</table>
		        @endforeach
		        </div>
		    </div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
			<div class="panel panel-blue" style="background:#FFF;">
				<div class ="panel-heading"> Ticket Status </div>
				<div class="panel-body">
					hello
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="panel panel-blue" style="background:#FFF;">
				<div class ="panel-heading"> Remarks </div>
				<div class="panel-body">
					<textarea class="form-control"></textarea><hr>
					<button class="btn btn-blue pull-right"> Submit </button>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script>
function time_elapsed_string($datetime, $full = false) {
	alert('hello');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    alert($string ? implode(', ', $string) . ' ago' : 'just now');
}
</script>

@stop