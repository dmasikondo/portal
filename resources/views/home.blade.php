@extends('layouts.master')

@section('pageTitle',"Dashboard")

@section('mainCon')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{session("status")}}
                            </div>
                        @endif

                        {{--You are logged in!--}}

                        <div class="row">
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="card-profile-image">
                                    <img src="/app-assets/user/default.png"
                                         class="rounded-circle img-border box-shadow-1" width="90%" alt="Card image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section"><i class="la la-globe"></i> My Details</h4>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control"
                                                   for="form_control_1">National ID</label>
                                            <div class="col-md-7">
                                                {{$user->national_id}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control"
                                                   for="form_control_1">Student ID</label>
                                            <div class="col-md-7">
                                                {{(!is_null($user->student_no))?$user->student_no : "-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Title</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->title:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Surname</label>
                                            <div class="col-md-7">
                                                {{$user->last_name}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">First name</label>
                                            <div class="col-md-7">
                                                {{$user->first_name}}
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">DOB</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->date_of_birth:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-5 label-control">Gender</label>
                                            <div class="col-md-7">
                                                {{(!is_null($personal))?$personal->gender:"-"}}
                                            </div>
                                        </div>

                                        <div class="form-group row last">
                                            <label class="col-md-5 label-control">Phone</label>
                                            <div class="col-md-7">
                                                {{(!is_null($contacts))?$contacts->cellphone:"-"}}

                                            </div>
                                        </div>

                                    </div>


                                </form>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form form-horizontal form-bordered">
                                    <div class="form-body">
                                        <h4 class="form-section"><i class="la la-certificate"></i> Courses</h4>
                                        @foreach($enrolment as $enrol)
                                            <h5 class="text-center text-bold-400 text-capitalize">{{$enrol->programme->name}}
                                                - {{$enrol->qualification->name}}</h5>
                                        @endforeach
                                        <h4 class="form-section"><i class="la la-globe"></i> Financial Record</h4>
                                        @php($balance = $transactions->sum("debit")+(-$transactions->sum("credit")))

                                        <h4 class="text-bold-600">Current Balance:
                                            <span class="{{($balance<0)?"text-success":"text-danger"}}">
                                                {{($balance<0)?"-":""}}${{abs($balance)}}</span></h4>
                                        <div class="table-responsive mt-1">
                                            <table class="table table-striped table-bordered">
                                                <thead class="bg-blue white">
                                                <tr>
                                                    <th>Ref</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>DR</th>
                                                    <th>CR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->ref }}</td>
                                                        <td>{{ $transaction->transactiondate }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ ($transaction->debit != 0)?"$".$transaction->debit:"" }}</td>
                                                        <td>{{ ($transaction->credit != 0)?"$".$transaction->credit:"" }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-capitalize">No Financial
                                                            Record
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
