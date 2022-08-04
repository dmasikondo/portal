@extends("layouts.staff-master")

@section("pageTitle", "Student Transactions")
@section("headerTitle", ucfirst($status)." Students")

@section("content")
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">
                            <a href="{{route("staff.data-analytics.index")}}"
                               class="btn btn-sm btn-secondary mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            {{ucfirst($status)}} Students</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @include("layouts.partials.notifications")

                        <table class="table table-responsive" style="display: table;">
                            <thead class="thead-inverse">
                            <tr>
                                <th>Student No</th>
                                <th>Student Name</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $transaction)
                                <tr>
                                    <td>{{$transaction->student_no}}</td>
                                    <td>{{$transaction->first_name}} {{$transaction->last_name}}</td>
                                    <td>{{displayMoney($transaction->balance)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center font-weight-bold">No {{$status}} students for
                                        current period
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mx-auto" style="width: 100px;">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection