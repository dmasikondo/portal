<div class="card-text">
    <p class="text-justify">Please provide your academic details related to your secondary
        education. Click on the green "Add Secondary School" button to add information about
        the secondary/high schools you attended and the period you attended them for. Click
        on the Add O Level Certificate button and Add A Level Certificate button to add a
        certificate details pertaining to the examinations you sat. <strong>Providing
            Secondary School history and O Level certificates is required before
            proceeding.</strong></p>
</div>

<form class="form form-horizontal form-bordered" method="post"
      action="{{route('urp.secodarySchool')}}">
    {!! csrf_field() !!}
    <div class="form-body">
        <h4 class="form-section mt-3"><i class="la la-institution"></i> Secondary School
            Info
        </h4>
        @php
            $secondary = $school_records->where("school_type","S");
        $secondaryCount = $secondary->count();
        @endphp

        <a href="{{route("ur.addSecondary")}}" class="btn btn-outline-success block btn-lg">
            Add{!! (($secondaryCount > 0)?" <strong>Another</strong> ":" ") !!}Secondary
            School
        </a>

        @if($secondaryCount > 0)
            <div class="table-responsive mt-1">
                <table class="table">
                    <thead class="bg-blue white">
                    <tr>
                        <th>#</th>
                        <th>School</th>
                        <th>Town</th>
                        <th>From Form</th>
                        <th>To Form</th>
                        <th>From Year</th>
                        <th>To Year</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($secondary->all() as $item)
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

        <h4 class="form-section mt-3">
            <i class="la la-certificate"></i> O'level Certificate(s)
        </h4>

        @php
            $olevelCertCount = $certificates->where('level','O')->count();
            $alevelCertCount = $certificates->where('level','A')->count();
        @endphp

        <a href="{{route('ur.addCertificate',["cert_level"=>"O"])}}"
           class="btn btn-outline-success block btn-lg">
            Add{!! (($olevelCertCount > 0)?" <strong>Another</strong> ":" ") !!}O Level
            Certificate
        </a>

        @if($olevelCertCount > 0)
            <div class="table-responsive mt-1" id="olevelCertificatesDiv">
                <table class="table table-striped table-bordered table-advance table-hover text-center"
                       id="olevelCertificatesTable">
                    <thead class="bg-blue white">
                    <tr>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Examining Board</th>
                        <th>Center & Candidate #</th>
                        <th>Results</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates->where('level','O')->all() as $result)
                        <tr id="cert-{{$result->id}}">
                            <td class="month"
                                data-value="{{ \Carbon\Carbon::createFromFormat('F',$result->result_month)->format('M')}}">
                                {{$result->result_month}}
                            </td>
                            <td class="year" data-value="{{$result->result_year}}">
                                {{$result->result_year}}
                            </td>
                            <td class="examining_body"
                                data-value="{{$ex_body = $result->examining_body}}">{{$ex_body}}</td>
                            <td class="multiple-details"
                                data-center="{{$center = $result->center_number}}"
                                data-candidate-no="{{$cand = $result->candidate_number}}"
                                data-cert-no="{{$result->certificate_number}}">
                                {{$center}} - {{$cand}}
                            </td>
                            <td>

                                @foreach($result->results as $cert_result)
                                    <span class="subgrade-rez"
                                          data-subject="{{$subject = $cert_result->subject}}"
                                          data-grade="{{$grade = $cert_result->grade}}">
                                                    {{$subject}} - {{$grade}}</span><br/>
                                @endforeach
                            </td>
                            <td>
                                @if($result->results->count() < 1)
                                    <a href="{{route('ur.addCertificateResults',["id"=>base64_encode($result->id)])}}"
                                       role="button"
                                       class="btn btn-block btn-primary btn-min-width">
                                        Add Subjects </a>
                                @endif
                                <a href="{{route("ur.confirmRemoveCert",["id"=>base64_encode($result->id)])}}"
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

        <h4 class="form-section mt-3">
            <i class="la la-certificate"></i> A'level Certificate(s)
        </h4>

        <a href="{{route('ur.addCertificate',["level"=>"A"])}}"
           class="btn btn-outline-success block btn-lg">
            Add{!! (($alevelCertCount > 0)?" <strong>Another</strong> ":" ") !!}A Level
            Certificate
        </a>

        @if($alevelCertCount > 0)
            <div class="table-responsive mt-1" id="alevelCertificatesDiv">
                <table class="table table-striped table-bordered table-advance table-hover text-center"
                       id="alevelCertificatesTable">
                    <thead class="bg-blue white">
                    <tr>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Examining Board</th>
                        <th>Center & Candidate #</th>
                        <th>Results</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates->where('level','A')->all() as $result)
                        <tr id="cert-{{$result->id}}">
                            <td class="month"
                                data-value="{{ \Carbon\Carbon::createFromFormat('F',$result->result_month)->format('M')}}">
                                {{$result->result_month}}
                            </td>
                            <td class="year" data-value="{{$result->result_year}}">
                                {{$result->result_year}}
                            </td>
                            <td class="examining_body"
                                data-value="{{$ex_body = $result->examining_body}}">{{$ex_body}}</td>
                            <td class="multiple-details"
                                data-center="{{$center = $result->center_number}}"
                                data-candidate-no="{{$cand = $result->candidate_number}}"
                                data-cert-no="{{$result->certificate_number}}">
                                {{$center}} - {{$cand}}
                            </td>
                            <td>
                                @foreach($result->results as $cert_result)
                                    <span class="subgrade-rez"
                                          data-subject="{{$subject = $cert_result->subject}}"
                                          data-grade="{{$grade = $cert_result->grade}}">
                                                    {{$subject}} - {{$grade}}</span><br/>
                                @endforeach
                            </td>
                            <td>
                                @if($result->results->count() < 1)
                                    <a href="{{route('ur.addCertificateResults',["id"=>base64_encode($result->id)])}}"
                                       role="button"
                                       class="btn btn-block btn-primary btn-min-width">
                                        Add Subjects </a>
                                @endif
                                <a href="{{route("ur.confirmRemoveCert",["id"=>base64_encode($result->id)])}}"
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
        <button type="submit" class="btn btn-primary">
            <i class="la la-check-square-o"></i> Continue
        </button>
    </div>
</form>

<div class="modal fade text-left" id="deleteCertificate" tabindex="-1"
     role="dialog" aria-labelledby="Delete Result" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Delete Certificate?</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route'=>'urp.removeCert',"role"=>"form"]) !!}
            <div class="modal-body">
                <div class="form-body">
                    <input name="certificate" id="delCertID" type="hidden">
                    <p>Are you sure you would like to delete the certificate?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary"
                        data-dismiss="modal">Close
                </button>
                <button type="submit" class="btn btn-outline-danger">Delete
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>