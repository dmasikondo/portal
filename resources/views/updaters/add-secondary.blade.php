@extends('layouts.master')

@section('pageTitle',"Add Secondary School")

@section('mainCon')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Update Personal Information</h4>
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
                                <p>Please provide details of the secondary school you attended.</p>
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
                                  action="{{route('urp.addSecondary')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-institution"></i> Add Secondary School</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="school">School</label>
                                        <div class="col-md-9">
                                            <input type="text" id="school" class="form-control"
                                                   placeholder="Secondary School"
                                                   name="school"
                                                   value="{{Session::hasOldInput("school")?Session::getOldInput("school"):""}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="town">Town</label>
                                        <div class="col-md-9">
                                            <input type="text" id="town" class="form-control"
                                                   placeholder="Town"
                                                   name="town"
                                                   value="{{Session::hasOldInput("town")?Session::getOldInput("town"):""}}">
                                        </div>
                                    </div>

                                    @php($form_arr = array_combine(range(1,6),range(1,6)))

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="from_form">From
                                            Form</label>
                                        <div class="col-md-9">
                                            {!! Form::select('from_form',$form_arr,null,["class"=>"form-control", "id"=>"from_form"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="to_form">To Form</label>
                                        <div class="col-md-9">
                                            {!! Form::select('to_form',$form_arr,null,["class"=>"form-control", "id"=>"to_form"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="from_year">From
                                            Year</label>
                                        <div class="col-md-9">
                                            {!! Form::select('from_year',
                                                    ([""=>"Year"]+array_combine(range((date('Y')),(date('Y')-110)),range((date('Y')),(date('Y')-110)))),null,['id'=>'from_year',"class"=>"form-control"]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="to_year">To Year</label>
                                        <div class="col-md-9">
                                            {!! Form::select('to_year',
                                                   ([""=>"Year"]+array_combine(range((date('Y')),(date('Y')-110)),range((date('Y')),(date('Y')-110)))),null,['id'=>'to_year',"class"=>"form-control"]) !!}
                                        </div>
                                    </div>


                                    {{--<div class="form-group row">--}}
                                    {{--<label class="col-md-3 label-control" for=""></label>--}}
                                    {{--<div class="col-md-9">--}}
                                    {{--<input type="text" id="" class="form-control"--}}
                                    {{--placeholder=""--}}
                                    {{--name=""--}}
                                    {{--value="{{Session::hasOldInput("")?Session::getOldInput(""):""}}">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="form-actions">
                                    <a href="{{route("ur.stage5")}}" class="btn btn-warning mr-1">
                                        <i class="la la-arrow-circle-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
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

