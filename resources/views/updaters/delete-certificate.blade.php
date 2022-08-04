@extends('layouts.master')

@section('pageTitle',"Delete Secondary Exam Certificate")

@section('mainCon')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Delete Secondary Exam Certificate</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                {{--<li><a data-action="collapse"><i class="ft-minus"></i></a></li>--}}
                                {{--<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>--}}
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                {{--<li><a data-action="close"><i class="ft-x"></i></a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="card-text">
                                <p>Confirm secondary exam certificate deletion.</p>
                            </div>
                            @if(count($errors->all()) > 0)
                                @foreach($errors->all() as $error)
                                    <div class="alert round bg-danger alert-icon-left alert-dismissible mb-2"
                                         role="alert">
                                        <span class="alert-icon"><i class="la la-exclamation-triangle"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                            <form class="form form-horizontal form-bordered" method="post"
                                  action="{{route('urp.removeCert')}}">
                                {!! csrf_field() !!}
                                <input name="certificate" value="{{$result->id}}" type="hidden">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-trash"></i> Are you sure you would like to
                                        delete this Secondary Exam Certificate?</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Session</label>
                                        <div class="col-md-9">
                                            {{$result->result_month}} {{$result->result_year}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Level</label>
                                        <div class="col-md-9">
                                            {{(($result->level=="O")?"O Level":"A Level")}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Examining Body</label>
                                        <div class="col-md-9">
                                            {{$result->examining_body}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Center Number</label>
                                        <div class="col-md-9">
                                            {{$result->center_number}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Candidate Number</label>
                                        <div class="col-md-9">
                                            {{$result->candidate_number}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Certificate Number</label>
                                        <div class="col-md-9">
                                            {{$result->certificate_number}}
                                        </div>
                                    </div>

                                    @foreach($result->results as $cert_result)
                                        <div class="form-group row">
                                            <label class="col-md-6 label-control">{{$cert_result->subject}}</label>
                                            <div class="col-md-6">{{$cert_result->grade}}</div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="form-actions">
                                    <a href="{{route('ur.stage5')}}" class="btn btn-secondary mr-1">
                                        <i class="la la-arrow-circle-left"></i> No
                                    </a>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="la la-check-square-o"></i> Yes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

