@extends("layouts.staff-master")

@section("pageTitle","Hostels")

@section("headerTitle")
    <div class="btn-group mr-1 mb-1">
        <h2 class="my-auto mr-2">You are viewing</h2>
        <button class="btn btn-info btn-lg dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            {{$hostel->name}}
        </button>
        <h2 class="my-auto ml-2">Chart</h2>
        <div class="dropdown-menu">
            @foreach($hostels as $hostel_pop)
                <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$hostel_pop->id])}}"
                   class="dropdown-item {{($hostel_pop->id == $hostel->id)? "active" : ""}}">{{$hostel_pop->name}}</a>
            @endforeach
        </div>
    </div>
@endsection

@push('pageStyles')
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="enrol_student_url" content="{{route('staff.students.enrol.store')}}">
@endpush

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">
                            <a href="{{route("staff.accommodation.index")}}" class="btn btn-sm btn-secondary mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            View Rooms On System</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <form>
                                <fieldset>
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search..."
                                               aria-describedby="button-addon2" value="{{request('search')}}">
                                        <div class="input-group-append">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary" type="submit"><i
                                                            class="la la-search"></i>
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                    @include("layouts.partials.notifications")
                    <!-- Task List table -->
                        <div class="table-responsive">
                            <table class="table table-white-space table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Room Number</th>
                                    <th>Occupancy Size</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th width="20%">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($hostel->rooms as $room)
                                    <tr class="main-info">
                                        <td>{{$room->id}}</td>
                                        <td>{{$room->name}}</td>
                                        <td>{{$room->room_size}}</td>
                                        <td>{{$room->gender}}</td>
                                        <td>
                                            @foreach($room->beds as $bed)
                                                @if(is_null($bed->student_residence_allocation))
                                                    <a href="{{route("staff.accommodation.search-student",["bed_id"=>$bed->id])}}"
                                                       class="btn btn-block btn-sm btn-primary">
                                                        <i class="la la-plus-circle"></i> Allocate
                                                    </a>
                                                @else
                                                    @php($user = $bed->student_residence_allocation->user)
                                                    <span>{{$user->student_no}}-{{$user->name}}</span><br/>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No rooms on system.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Room Number</th>
                                    <th>Occupancy Size</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th width="20%">Price</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push("pageJavascript")
    <script>
        $('.dropdown-toggle').dropdown();
    </script>
@endpush


