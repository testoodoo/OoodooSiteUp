<html>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
TOTAL USAGE ::
<body>
    <table>
           <tr>
              <th>Account ID</th>
              <th>From Date</th>
              <th>To Date</th>
              <th>Upload</th>
              <th>Download</th>
              <th>Total GB</th>
          </tr>
            <tr>
                <td align="center" >{{$account_id}}</td>
                <td align="center" >{{$from_date}}</td>
                <td align="center" >{{$to_date}}</td>
                <td align="center" >{{$bytes_up}}</td>
                <td align="center" >{{$bytes_down}}</td>
                <td align="center" >{{$bytes_total}}GB</td>
            </tr>
    </table>
</body>
USAGES ::
<body>
    <table  width="480" cellspacing="0" cellpadding="0">
            <tr>
                <th>Session ID</th>
                <th>IP Address</th>
                <th>MAC address</th>
                <th>Start Time</th>
                <th>Stop Time</th>
                <th>Data In</th>
                <th>Data Out</th>
                <th>Total Data</th>
            </tr>
            @foreach($sessions as $session)
            <tr>
                <td width="60" align="center" >{{$session->session_id}}</td>
                <td width="60" align="center" >{{$session->ip_address}}</td>
                <td width="60" align="center" >{{$session->mac_address}}</td>
                <td width="60" align="center" >{{$session->start_time}}</td>
                <td width="60" align="center" >{{$session->stop_time}}</td>
                <td width="60" align="center" >{{$session->data_usage_in_gb($session->bytes_up)}}GB</td>
                <td width="60" align="center" >{{$session->data_usage_in_gb($session->bytes_down)}}GB</td>
                <td width="60" align="center" >{{$session->data_usage_in_gb($session->bytes_total)}}GB</td>
            </tr>
            @endforeach
            </tr>
    </table>
    </body>
</html>