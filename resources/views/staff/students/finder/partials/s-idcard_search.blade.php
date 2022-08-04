<div class="alert round bg-danger alert-icon-left alert-dismissible mb-2" role="alert">
    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    An exact match could not be found, possible matches have been listed for updating.
</div>

<div class="table-responsive">
    <table class="table table-white-space table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>First Name</th>
            <th>National ID</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($student as $_student)
            <tr class="main-info">
                <td>{{$_student->ucARSTUDENTNO}}</td>
                <td>{{$_student->Name}}</td>
                <td>{{$_student->Account}}</td>
                <td>
                    <a href="{{route('staff.student-finder.card-edit',["card_id"=>$_student->id])}}"
                       class="btn btn-block btn-warning">
                        <i class="la la-pencil"></i> Edit Record
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No Student Found</td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>Full Name</th>
            <th>National ID</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
</div>