@extends("layouts.staff-master")

@section("pageTitle","Hostels")

@section("headerTitle",((is_null(request('search')))?"Hostels":"Search Results for \"".request('search')."\"..."))

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
                            <a href="{{route("staff.accommodation.index")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            View Hostels On System</h4>
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
                                    <th width="5%"></th>
                                    <th>Hostel Name</th>
                                    <th width="20%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($hostels as $hostel)
                                    <tr class="main-info">
                                        <td>{{$hostel->id}}</td>
                                        <td>{{$hostel->name}}</td>
                                        <td>
                                            <a href="{{route('staff.accommodation.hostel-rooms',["hostel"=>$hostel->id])}}"
                                               target="_blank" class="btn btn-block btn-primary">
                                                <i class="la la-bed"></i> View Hostel Rooms
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Hostels on system.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Hostel Name</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $hostels->appends(Request::only(["search"]))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


