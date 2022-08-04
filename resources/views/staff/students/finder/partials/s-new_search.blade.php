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
            <th>Title</th>
            <th>First Name</th>
            <th>Surname</th>
            {{--            <th>Gender</th>--}}
            <th>National ID</th>
            {{--            <th>Date Of Birth</th>--}}
            {{--            <th>Programme</th>--}}
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($student as $_student)
            <tr class="main-info">
                <td>{{$_student->student_no}}</td>
                <td>{{$_student->title}}</td>
                <td>{{$_student->first_name}}</td>
                <td>{{$_student->last_name}}</td>
                {{--                <td>{{$student->gender}}</td>--}}
                <td>{{$_student->national_id}}</td>
                {{--                <td>{{$student->date_of_birth}}</td>--}}
                {{--                <td>{{$student->programme->name}}</td>--}}
                <td>
                    <a href="{{route('staff.students.enrolment.edit',["id"=>$_student->id])}}"
                       target="_blank" class="btn btn-block btn-warning">
                        <i class="la la-pencil"></i> Edit Enrolment
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No Enrolled Students</td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>Title</th>
            <th>First Name</th>
            <th>Surname</th>
            {{--            <th>Gender</th>--}}
            <th>National ID</th>
            {{--            <th>Date Of Birth</th>--}}
            {{--            <th>Programme</th>--}}
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
</div>