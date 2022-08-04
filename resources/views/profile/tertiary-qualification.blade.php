@extends('layouts.master')

@section('pageTitle',"Stage 6: Academic Information")

@section('mainCon')
    @include('layouts.partials.stage-viewer')
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
                                <p class="text-justify">Please provide your academic details relating to past tertiary
                                    education that is before coming to Harare Polytechnic College. This has to be for a
                                    course
                                    or programme already completed. If you have none please press continue.</p>
                            </div>
                            @if (session('status'))
                                <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{session("status")}}
                                </div>
                            @endif
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
                                  action="{{route('urp.tertiaryProceed')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-institution"></i> Tertiary Qualifications
                                    </h4>

                                    <button type="button" class="btn btn-outline-success block btn-lg"
                                            data-toggle="modal"
                                            data-target="#addATertiaryQualification">
                                        Add A Tertiary Qualification
                                    </button>


                                    @if($qualifications->count()>0)

                                        <p class="text-justify mt-1 mb-1">
                                            <small class="text-muted">* A period is an academic session that may be
                                                called
                                                a Semester or a Term. At the last column of the table there is a button
                                                to add a period. You will not be able to proceed until a period is
                                                added.
                                            </small>
                                        </p>
                                        <div class="table-responsive mt-1">
                                            <table class="table">
                                                <thead class="bg-blue white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Institution</th>
                                                    <th>Qualification</th>
                                                    <th>Results</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($qualifications->all() as $item)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$item->institution_name}}</td>
                                                        <td>{{$item->qualification_title}}</td>
                                                        <td>
                                                            @foreach($item->periods as $period)
                                                                <span class="text-center text-bold-600">
                                                                    {{$period->period}}
                                                                </span><br/>

                                                                @forelse($period->results as $result)
                                                                    {{$result->module}} - {{$result->grade}}<br/>
                                                                @empty
                                                                    <a href="{{route("ur.addTertiaryPeriodResults",["code"=>$item->code,"id"=>base64_encode($period->id)])}}"
                                                                       class="btn btn-sm btn-block btn-primary"><i
                                                                                class="la la-calendar-plus-o"></i> Add
                                                                        Courses
                                                                    </a>
                                                                @endforelse
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="{{route("ur.addTertiaryPeriod",["code"=>$item->code])}}"
                                                               class="btn btn-primary btn-block"><i
                                                                        class="la la-check-square-o"></i> Add An
                                                                Academic Period
                                                            </a>
                                                            <a href="{{route('ur.deleteTertiary',["code"=>$item->code])}}"
                                                               class="btn btn-danger btn-block"> Remove </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif


                                </div>
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Continue
                                    </button>
                                </div>
                            </form>

                            <div class="modal fade text-left" id="addATertiaryQualification" tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="myModalLabel17"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel17">Add A Tertiary
                                                Qualification</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form" method="post" action="{{route('urp.addTertiary')}}">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="form-body">

                                                    <div class="row">
                                                        <div class="form-group col-12 mb-2">
                                                            <label for="institution_name">Institution Name</label>
                                                            <input class="form-control border-primary"
                                                                   name="institution_name" type="text"
                                                                   placeholder="Institution Name"
                                                                   id="institution_name">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-12 mb-2">
                                                            <label for="qualification_title">Qualification Title</label>
                                                            <input class="form-control border-primary"
                                                                   name="qualification_title" type="text"
                                                                   placeholder="Qualification Title"
                                                                   id="qualification_title">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn grey btn-outline-secondary"
                                                        data-dismiss="modal">Close
                                                </button>
                                                <button type="submit" class="btn btn-outline-primary">Save
                                                    Tertiary Qualification
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
