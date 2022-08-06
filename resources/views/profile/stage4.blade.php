@extends('layouts.master')

@section('pageTitle',"Stage 4: Academic Information")

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
                                <p class="text-justify">Please provide your academic details related to your primary
                                    education. Click on the
                                    "Add Primary School" button to enter information about where you learnt from Grade 1
                                    to Grade 7. Click on the "Add Grade 7 Result" button to enter information about your
                                    grade 7 results. <strong>These 2 sections are required before proceeding.</strong>
                                </p>
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
                                  action="{{route('urp.stage4Proceed')}}">
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-institution"></i> Primary School Info</h4>

                                    @php
                                        $primary = $school_records->where("school_type","P");
                                        $primaryCount = $primary->count();
                                    @endphp

                                    <a href="{{route("ur.addPrimary")}}" class="btn btn-outline-success block btn-lg">
                                        Add{!! (($primaryCount > 0)?" <strong>Another</strong> ":" ") !!}Primary
                                        School</a>

                                    @if($primaryCount > 0)
                                        <div class="table-responsive mt-1">
                                            <table class="table">
                                                <thead class="bg-blue white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>School</th>
                                                    <th>Town</th>
                                                    <th>From Grade</th>
                                                    <th>To Grade</th>
                                                    <th>From Year</th>
                                                    <th>To Year</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($primary->all() as $item)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->town}}</td>
                                                        <td>{{$item->from_level}}</td>
                                                        <td>{{$item->to_level}}</td>
                                                        <td>{{$item->from_year}}</td>
                                                        <td>{{$item->to_year}}</td>
                                                        <td>
                                                            <a href="{{route('ur.confirmDeleteSchool',["id"=>base64_encode($item->id),"type"=>$item->school_type])}}"
                                                               role="button"
                                                               class="btn btn-block btn-danger btn-min-width">
                                                                REMOVE </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    @php($g7ResultCount = $g7_results->count())

                                    <h4 class="form-section"><i class="la la-institution"></i> Grade 7 Result</h4>
                                    <a href="{{route("ur.addGrade")}}" class="btn btn-outline-success block btn-lg">
                                        Add{!! (($g7ResultCount > 0)?" <strong>Another</strong> ":" ") !!}Grade 7
                                        Result</a>

                                    @if($g7ResultCount > 0)
                                        <div class="table-scrollable mt-1" id="alevelCertificatesDiv">
                                            <table class="table table-striped table-bordered table-advance table-hover text-center"
                                                   id="alevelCertificatesTable">
                                                <thead class="bg-blue white">
                                                <tr>
                                                    <th>Centre</th>
                                                    <th>Results</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($g7_results->all() as $result)
                                                    <tr id="cert-{{$result->id}}">
                                                        <td>
                                                            {{$result->centre}}
                                                        </td>
                                                        <td>
                                                            @foreach($result->results as $cert_result)
                                                                <span class="subgrade-rez"
                                                                      data-subject="{{$subject = $cert_result->subject}}"
                                                                      data-grade="{{$grade = $cert_result->points}}">
                                                                    {{$subject}} - {{$grade}} point(s)</span><br/>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="{{route('ur.confirmDeleteG7',["id"=>base64_encode($result->id)])}}"
                                                               role="button"
                                                               class="btn btn-block btn-danger btn-min-width">
                                                                REMOVE </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif


                                </div>
                                <div class="form-actions right">
                                    <a href="{{route('assistance')}}"> Having Challenges? Click Here</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Continue
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
