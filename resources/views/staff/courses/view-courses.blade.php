@extends("layouts.staff-master")

@section("pageTitle","View Courses")

@section("headerTitle",((is_null(request('search')))?"View Course":"Search Results for \"".request('search')."\"..."))

@push('pageStyles')
    <meta name="csrf_token" content="{{csrf_token()}}">
@endpush

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">
                            <a href="{{route("staff.courses")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            View Courses Offered</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <form>
                                <fieldset>
                                    <div class="input-group">
                                        <div class="input-group-prepend show">
                                            <select class="btn btn-primary dropdown-toggle" name="field">
                                                <option value="national_id"
                                                        {{request("field")=="national_id"?"selected":""}}>
                                                    National ID
                                                </option>
                                                <option value="reference_number"
                                                        {{request("field")=="reference_number"?"selected":""}}>
                                                    Reference Number
                                                </option>
                                            </select>
                                        </div>
                                        <input name="search" type="text" class="form-control" placeholder="Search..."
                                               aria-describedby="button-addon2" value="{{request('search')}}">
                                        <div class="input-group-append">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary" type="submit"><i
                                                            class="la la-search"></i>
                                                    Search
                                                </button>
                                                {{--<a class="btn btn-info"--}}
                                                {{--href="{{route('staff.students.enrolment-download')}}"><i--}}
                                                {{--class="la la-download"></i>--}}
                                                {{--Download CSV--}}
                                                {{--</a>--}}
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
                                    <th>Department</th>
                                    <th>Qualification</th>
                                    <th>Course</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="p-0" colspan="9">
                                        <a href="{{route("staff.courses.create")}}"
                                           class="btn btn-block btn-secondary add-more-btn"><i
                                                    class="la la-plus"></i>
                                            Add New Course
                                        </a>
                                    </td>
                                </tr>
                                @forelse($intake as $item)
                                    <tr class="main-info">
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->programme->department->name}}</td>
                                        <td>{{$item->qualification->name}}</td>
                                        <td>{{$item->programme->name}}</td>
                                        <td>
                                            <a href="{{route('staff.students.enrolment.edit',["id"=>$item->id])}}"
                                               target="_blank" class="btn btn-block btn-info">
                                                <i class="la la-pencil"></i> Edit Course
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Courses</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Department</th>
                                    <th>Qualification</th>
                                    <th>Course</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $intake->appends(Request::only(["search"]))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


