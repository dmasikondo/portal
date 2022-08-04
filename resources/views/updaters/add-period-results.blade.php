@extends('layouts.master')

@section('pageTitle',"Add Period Results")

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
                                <p>Please provide details of your period results.</p>
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
                            <form method="post"
                                  action="{{route('urp.addTertiaryPeriodResults',["code"=>$qualification->code,"id"=>base64_encode($period->id)])}}"
                                  class="form row">
                                {!! csrf_field() !!}
                                <h4>{{$qualification->qualification_title}} - {{$period->period}} Results</h4>

                                @php($i = 0)
                                @while($i < $period->number_of_courses)
                                    <div class="form-group col-12 mb-2">
                                        <div class="row mb-1">
                                            <div class="form-group col-md-7">
                                                <label class="label-control" for="subject">Course/Module</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Course/Module"
                                                       name="cert[{{$i}}][course]"
                                                       value="{{old("cert.{$i}.course")}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="label-control" for="grade_1">Grade</label>
                                                <input type="text" class="form-control" placeholder="Grade"
                                                       name="cert[{{$i}}][grade]" value="{{old("cert.{$i}.grade")}}">
                                            </div>
                                        </div>
                                    </div>
                                    @php($i++)
                                @endwhile

                                <div class="form-group col-12 last">
                                    {{--<a href="{{route("ur.stage4")}}" class="btn btn-warning mr-1">--}}
                                    {{--<i class="la la-arrow-circle-left"></i> Back--}}
                                    {{--</a>--}}
                                    <button name="save_add" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save And Add Another Period
                                    </button>
                                    <button name="save_continue" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save And Continue
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

@push('pageStyle')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/ui/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/ui/jqueryui.css">
@endpush

@push('javascripts')
    <script src="/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>

@endpush

