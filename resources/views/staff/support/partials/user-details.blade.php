<form class="form form-horizontal form-bordered">
    <div class="form-body">

        <div class="form-group row">
            <label class="col-md-6 label-control">First Name</label>
            <div class="col-md-6">
                {{$ticket->ticketable->first_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-6 label-control">Surname</label>
            <div class="col-md-6">
                {{$ticket->ticketable->last_name}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-6 label-control">National ID</label>
            <div class="col-md-6">
                {{$ticket->ticketable->national_id}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-6 label-control">Student ID</label>
            <div class="col-md-6">
                {{$ticket->ticketable->student_no}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-6 label-control">E-mail</label>
            <div class="col-md-6">
                {{$ticket->ticketable->email}}
            </div>
        </div>

    </div>
</form>
