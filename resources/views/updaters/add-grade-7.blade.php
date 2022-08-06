@extends('layouts.master')

@section('pageTitle',"Add Grade 7 Results")

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
                                <p class="text-justify">Please fill in the form with your grade 7 results. Select your
                                    language option in the last
                                    field. When done filling the form press the save button.</p>
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
                            <form method="post" action="{{route('urp.addGrade')}}" class="form row">
                                {!! csrf_field() !!}

                                <div class="form-group col-md-12 mb-2">
                                    <label class="label-control" for="centre">Where did you write your Grade 7
                                        Exam</label>
                                    <input type="text" class="form-control" placeholder="School Name(Exam Centre Name)"
                                           id="centre" name="centre" value="{{old("centre")}}">
                                </div>

                                <div class="form-group col-12 mb-2">
                                    <div class="row mb-1">
                                        <div class="form-group col-md-7">
                                            <label class="label-control" for="subject">Subject</label>
                                            <input type="text" class="form-control"
                                                   value="Mathematics" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="label-control" for="points">Points</label>
                                            {!! Form::select('mathematics_points',array_combine(range(1,9),range(1,9)),null,["class"=>"form-control", "id"=>"points"]) !!}
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="form-group col-md-7">
                                            <label class="label-control" for="subject">Subject</label>
                                            <input type="text" class="form-control"
                                                   value="English" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="label-control" for="points">Points</label>
                                            {!! Form::select('english_points',array_combine(range(1,9),range(1,9)),null,["class"=>"form-control", "id"=>"points"]) !!}
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="form-group col-md-7">
                                            <label class="label-control" for="subject">Subject</label>
                                            <input type="text" class="form-control"
                                                   value="General Paper" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="label-control" for="points">Points</label>
                                            {!! Form::select('general_paper_points',array_combine(range(1,9),range(1,9)),null,["class"=>"form-control", "id"=>"points"]) !!}
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="form-group col-md-7">
                                            <label class="label-control" for="language">Subject</label>
                                            {!! Form::select('language',["Shona"=>"Shona","Ndebele"=>"Ndebele"],null,["class"=>"form-control","id"=>"language"]) !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="label-control" for="points">Points</label>
                                            {!! Form::select('language_points',array_combine(range(1,9),range(1,9)),null,["class"=>"form-control", "id"=>"points"]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-12 last">
                                    <a href="{{route("ur.stage4")}}" class="btn btn-warning mr-1">
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

@push('javascripts')
    <script src="/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"
            type="text/javascript"></script>
    <script src="/app-assets/js/scripts/forms/form-repeater.js" type="text/javascript"></script>
@endpush
