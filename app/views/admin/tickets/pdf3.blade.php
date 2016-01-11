<html>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
      <body>
    <table>
            <tr>
                <th>Ticket No</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Area</th>
                <th>Address</th>
                <th>Remarks for the connection</th>
            </tr>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{$ticket->ticket_no}}</td>
                <td>{{$ticket->name}}</td>
                <td>{{$ticket->mobile}}</td>
                <td>{{$ticket->area}}</td>
                <td>{{$ticket->address}}</td>
                <th> </th>
            </tr>
            @endforeach
            </tr>
    </table>
    </body>
</html>