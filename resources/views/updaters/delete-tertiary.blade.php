@extends('layouts.master')

@section('pageTitle',"Delete Tertiary Qualifications")

@section('mainCon')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Delete Tertiary Qualifications</h4>
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
                                <p>Confirm Tertiary Qualifications deletion.</p>
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
                                  action="{{route('urp.deleteTertiary',["code"=>$item->code])}}">
                                {!! csrf_field() !!}

                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-trash"></i> Are you sure you would like to
                                        delete this Tertiary Qualification?</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="form_control_1">What would you like
                                            to delete?</label>
                                        <div class="col-md-9">

                                            {!! Form::select("item_to_delete",
                                            ["all"=>"The Whole Qualification"]+$item->periods->pluck("period","id")->toArray(),null,
                                            ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Institution</label>
                                        <div class="col-md-9">
                                            {{$item->institution_name}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Qualification</label>
                                        <div class="col-md-9">
                                            {{$item->qualification_title}}
                                        </div>
                                    </div>

                                    @foreach($item->periods as $period)
                                        <h4 class="text-center text-bold-600">{{$period->period}}</h4>

                                        @forelse($period->results as $result)
                                            <div class="form-group row">
                                                <label class="col-md-6 label-control">{{$result->module}}</label>
                                                <div class="col-md-6">{{$result->grade}}</div>
                                            </div>
                                        @empty
                                            <div class="form-group row">
                                                <div class="col-md-12 text-center text-bold-600">Period has no results
                                                </div>
                                            </div>
                                        @endforelse
                                    @endforeach

                                </div>
                                <div class="form-actions">
                                    <a href="{{route('ur.addTertiary')}}" class="btn btn-secondary mr-1">
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

