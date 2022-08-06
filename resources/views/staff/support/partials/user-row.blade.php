<tr>
    <td>{{$ticket->id}}</td>
    <td>{{$ticket->ticketable->first_name}}</td>
    <td>{{$ticket->ticketable->last_name}}</td>
    <td>{{$ticket->ticketable->national_id}}</td>
    <td>{{collect(\App\SupportTicket::$issue_types)->where("id",$ticket->issue_type)->first()["student_detail"]}}</td>
    <td><a class="btn btn-primary"
           href="{{route('staff.tickets.view',["user"=>$ticket->id])}}">View</a></td>
</tr>