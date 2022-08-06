@extends('layouts.master')

@section('pageTitle',"Delete School Record")

@section('mainCon')
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="bordered-layout-basic-form">Delete School Record</h4>
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
                                <p>Confirm school record deletion.</p>
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
                                  action="{{route('urp.deleteSchool',["id"=>base64_encode($school_record->id),"type"=>$school_record->school_type])}}">
                                @method('delete')
                                {!! csrf_field() !!}
                                <div class="form-body">
                                    <h4 class="form-section"><i class="la la-trash"></i> Are you sure you would like to
                                        delete this school record?</h4>

                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">School</label>
                                        <div class="col-md-9">
                                            {{$school_record->name}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Town</label>
                                        <div class="col-md-9">
                                            {{$school_record->town}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">School Type</label>
                                        <div class="col-md-9">
                                            {{($school_record->school_type == "P")?"Primary":"Secondary"}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Years</label>
                                        <div class="col-md-9">
                                            {{$school_record->from_year}}-{{$school_record->to_year}}
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <a href="{{route('ur.stage4')}}" class="btn btn-secondary mr-1">
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

