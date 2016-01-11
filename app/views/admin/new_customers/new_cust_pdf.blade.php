<html>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
      <body>
    <table  width="540" cellspacing="0" cellpadding="0">
            <tr>
                <th>Application No</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Application Date</th>
                <th>Remarks for the connection</th>
            </tr>
            @foreach($custom as $cust)
            <tr>
                <td width="70" align="center" >{{$cust->application_no}}</td>
                <td width="70" align="center" >{{strtolower($cust->first_name)}}</td>
                <td width="70" align="center" >{{$cust->phone}}</td>
                <td width="70" align="center" >{{strtolower($cust->address1)}},{{strtolower($cust->address2)}},{{strtolower($cust->address3)}}</td>
                <td width="60" align="center" >{{$cust->application_date}}</td>
                <td width="100"> </td>
            </tr>
            @endforeach
            </tr>
    </table>
    </body>
</html>