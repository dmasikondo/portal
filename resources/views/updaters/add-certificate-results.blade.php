@extends('layouts.master')

@section('pageTitle',"Add Certificate Results")

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
                            @if (session('status'))
                                <div class="alert round bg-success alert-icon-left alert-dismissible mb-2" role="alert">
                                    <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{session("status")}}
                                </div>
                            @endif
                            <?php
                            $suggestSubject = request("opt") == "report_missing";
                            ?>
                            @includeWhen((!$suggestSubject),'updaters.secondary-results-form')
                            @includeWhen($suggestSubject,'profile.secondary-edu-partials.suggest-subject')
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
    <script>
                @php($bad_ids = [496,497,498,499,500,63,30,65,35,60,17,77,31,69,284,529,630])
        let resultTags = {!! \App\SECertificateResult::select("subject")->whereNotIn("certificate_id",$bad_ids)->distinct()->get()->pluck("subject")->toJson() !!};
        $(".subject-suggestable").autocomplete({
            source: resultTags
        });
    </script>
@endpush

