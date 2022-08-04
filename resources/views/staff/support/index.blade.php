@extends("layouts.staff-master")

@section("pageTitle",((is_null(request('search')))?"All Students":"Search Results for \"".request('search')."\"..."))

@section("headerTitle",((is_null(request('search')))?"All Students":"Search Results for \"".request('search')."\"..."))

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">All Tickets</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <form>
                                <fieldset>
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control" placeholder="Search..."
                                               aria-describedby="button-addon2" value="{{request('search')}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="la la-search"></i>
                                                Search
                                            </button>
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
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>National ID</th>
                                    <th>Issue Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tickets as $ticket)
                                    @php
                                        $class_name = explode("\\", $ticket->ticketable_type);
                                        $view_name = strtolower($class_name[(count($class_name) - 1)]);
                                    @endphp

                                    @include("staff.support.partials.{$view_name}-row")
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>National ID</th>
                                    <th>Issue Type</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $tickets->appends(Request::only(["search"]))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


