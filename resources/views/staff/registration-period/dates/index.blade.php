@extends("layouts.staff-master")

@section("pageTitle", "Registration Sessions")
@section("headerTitle", "Registration Sessions")

@section("content")
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">View Registration Sessions</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <a class="btn btn-info" href="{{route("staff.registration.sessions.create")}}">
                                <i class="la la-plus-circle"></i>
                                Add Registration Session
                            </a>
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
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($registration_periods as $registration_period)
                                    <tr class="main-info">
                                        <td></td>
                                        <td>{{$registration_period->title}}</td>
                                        <td>{{$registration_period->start_date->format("Y-m-d")}}</td>
                                        <td>{{$registration_period->end_date->format("Y-m-d")}}</td>
                                        <td>
                                            @php($now = Carbon\Carbon::now())
                                            @if($now->greaterThanOrEqualTo($registration_period->start_date) && $now->lessThanOrEqualTo($registration_period->end_date))
                                                Active
                                            @elseif($now->greaterThan($registration_period->end_date))
                                                Past
                                            @elseif($now->lessThan($registration_period->start_date))
                                                Inactive
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Registration Sessions</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $registration_periods->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection