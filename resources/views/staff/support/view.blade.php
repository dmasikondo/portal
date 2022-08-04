@extends("layouts.staff-master")

@section("pageTitle","Ticket Record")

@section("headerTitle","Ticket Record")

@push('pageStyles')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/summernote.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/codemirror.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/theme/monokai.css">
@endpush

@push('pageJavascript')
    <script src="/app-assets/vendors/js/editors/summernote/summernote.js" type="text/javascript"></script>
    <script>
        $('.response-box').summernote({height: 350});
    </script>
@endpush

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="{{route("staff.tickets")}}" class="btn btn-icon btn-light mr-1"><i
                                        class="la la-chevron-circle-left"></i></a>
                            Support Ticket
                        </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include("layouts.partials.notifications")
                    </div>
                </div>

            </div>

            <div class="row match-height">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Details</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @php
                                    $class_name = explode("\\", $ticket->ticketable_type);
                                    $view_name = strtolower($class_name[(count($class_name) - 1)]);
                                @endphp

                                @include("staff.support.partials.{$view_name}-details")
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Issue</h4>
                            <a class="heading-elements-toggle"><i
                                        class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">

                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-5 label-control"
                                           for="form_control_1">Issue Type</label>
                                    <div class="col-md-7">
                                        {{collect(\App\SupportTicket::$issue_types)->where("id",$ticket->issue_type)->first()["student_detail"]}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 label-control"
                                           for="form_control_1">Issue Description</label>
                                    <div class="col-md-7 text-justify">
                                        {{$ticket->description}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row match-height">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Response</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
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
                                      action="{{route('staff.tickets.respond',["id"=>$ticket->id])}}">
                                    @csrf
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">
                                            <textarea name="description" class="form-control response-box"
                                                      id="textarea2"
                                                      rows="3"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions right">
                                        <button type="button" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection


