@extends("layouts.staff-master")

@section("pageTitle", "Registration Periods")

@section("content")
    @php
        function pad($input)
        {
            return sprintf("%02d", $input);
        }
    $years = range((date('Y')),(date('Y')+2));
    @endphp

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">

                        <h4 class="card-title">Add A Registration Period</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        @include("layouts.partials.notifications")

                        <form class="form form-horizontal form-bordered" method="post"
                              action="{{route("staff.registration.sessions.store")}}">
                            {!! csrf_field() !!}

                            <div class="form-group row {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="col-md-3 label-control" for="form_control_1">Title</label>
                                <div class="col-md-9">
                                    {!! Form::text("title",null,["id"=>"title","placeholder"=>"Title","class"=>"form-control"]) !!}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('start_date') ? ' issue' : '' }}">
                                <label class="col-md-3 label-control" for="start_date">Registration Start Date</label>
                                <div class="col-md-9">
                                    @php
                                        $exploded_date = ["day"=>null,"month"=>null,"year"=>null];
                                        $date = null;

                                    if(!is_null($date)){
                                    $exp = explode("-",$date->exam_date);
                                    $exploded_date["day"] = $exp[2];
                                    $exploded_date["month"] = $exp[1];
                                    $exploded_date["year"] = $exp[0];
                                    }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::select("start_day",
                                            ([""=>"Day"]+array_combine(array_map('pad', range(1,31)),range(1,31)))
                                            ,$exploded_date["day"],["class"=>"form-control"]) !!}
                                        </div>

                                        <div class="col-md-5">
                                            {!! Form::select("start_month",
                                            ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),$exploded_date["month"],["class"=>"form-control"]) !!}
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::select("start_year",
                                            ([""=>"Year"]+array_combine($years,$years)),$exploded_date["year"],["class"=>"form-control"]) !!}
                                        </div>
                                    </div>
                                    {!! $errors->first('start_date','<span class="font-red-mint validation-error">:message</span><br/>')!!}
                                </div>
                            </div>

                            <div class="form-group row last {{ $errors->has('end_date') ? ' issue' : '' }}">
                                <label class="col-md-3 label-control" for="end_date">Registration End Date</label>
                                <div class="col-md-9">
                                    @php
                                        $exploded_date = ["day"=>null,"month"=>null,"year"=>null];
                                        $date = null;

                                    if(!is_null($date)){
                                    $exp = explode("-",$date->exam_date);
                                    $exploded_date["day"] = $exp[2];
                                    $exploded_date["month"] = $exp[1];
                                    $exploded_date["year"] = $exp[0];
                                    }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::select("end_day",
                                            ([""=>"Day"]+array_combine(array_map('pad', range(1,31)),range(1,31)))
                                            ,$exploded_date["day"],["class"=>"form-control"]) !!}
                                        </div>

                                        <div class="col-md-5">
                                            {!! Form::select("end_month",
                                            ([""=>"Month"]+array_reduce(array_map('pad', range(1,12)),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; })),$exploded_date["month"],["class"=>"form-control"]) !!}
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::select("end_year",
                                            ([""=>"Year"]+array_combine($years,$years)),$exploded_date["year"],["class"=>"form-control"]) !!}
                                        </div>
                                    </div>
                                    {!! $errors->first('end_date','<span class="font-red-mint validation-error">:message</span><br/>')!!}
                                </div>
                            </div>

                            <div class="form-actions center">
                                <a href="{{route("staff.registration.sessions.index")}}" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
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
    </section>
@endsection
