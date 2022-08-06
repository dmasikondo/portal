@extends('layouts.master')

@section('pageTitle',"Add A Secondary Exam Certificate")

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
                                <p>Please provide details of your secondary school examination certificate.</p>
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
                                  action="{{route('urp.addOLevel')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-institution"></i> Add Secondary Exam
                                        Certificate (O Level or A Level)</h4>

                                    <div class="form-body">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="level">Certificate
                                                Level</label>
                                            <div class="col-md-9">
                                                <select name="level" class="form-control" id="level">
                                                    <option value="">Select Certification Level</option>
                                                    <option value="O"
                                                            {{(old('level')=="O")?"selected":((is_null(old('level')) && request('cert_level')=="O")?"selected":"")}}>
                                                        O Level
                                                    </option>
                                                    <option value="A"
                                                            {{(old('level')=="A")?"selected":((is_null(old('level')) && request('cert_level')=="A")?"selected":"")}}>
                                                        A Level
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="month_1">Month</label>
                                            <div class="col-md-9">
                                                {!! Form::select('month', [""=>"Month", "06"=>"June","11"=>"November"],null,
                                                ['id'=>'month_1',"class"=>"form-control"]) !!}
                                                <span class="help-block">In which session did you sit the exam? ex. June</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="year_1">Year</label>
                                            <div class="col-md-9">
                                                {!! Form::select('year',
                                                    ([""=>"Year"]+array_combine(range((date('Y')),(date('Y')-110)),range((date('Y')),(date('Y')-110)))),null,['id'=>'birth_year',"class"=>"form-control"]) !!}
                                                <span class="help-block">In which session did you sit the exam? ex. 2008</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="form_control_1">Examining
                                                Body</label>
                                            <div class="col-md-9">
                                                {!! Form::select('examining_body',["ZIMSEC"=>"ZIMSEC","CAMBRIDGE"=>"CAMBRIDGE"],"ZIMSEC",['id'=>'form_control_1',"class"=>"form-control"]) !!}
                                                <span class="help-block">ex. ZIMSEC, CAMBRIDGE</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="form_control_1">Certificate
                                                Number</label>
                                            <div class="col-md-9">
                                                <input name="certificate_number" type="text"
                                                       value="{{old("certificate_number")}}"
                                                       class="form-control" id="form_control_1">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="form_control_1">Center
                                                Name</label>
                                            <div class="col-md-9">
                                                <input name="center_number" type="text" class="form-control"
                                                       value="{{old("center_number")}}"
                                                       id="form_control_1">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="form_control_1">Candidate
                                                Number</label>
                                            <div class="col-md-9">
                                                <input name="candidate_number" type="text" class="form-control"
                                                       value="{{old("candidate_number")}}" id="form_control_1">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="number_of_subjects">Number of
                                            Subjects Written</label>
                                        <div class="col-md-9">
                                            <input name="number_of_subjects" type="number" class="form-control"
                                                   id="number_of_subjects" min="1" max="20"
                                                   value="{{old('number_of_subjects')}}">
                                            <span class="help-block">How many subjects did you write during this sitting?</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <a href="{{route("ur.secodarySchool")}}" class="btn btn-warning mr-1">
                                        <i class="la la-arrow-circle-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Next: Add Subject(s) For Certificate
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

