<div class="card-text">
    <p>Please provide details of your secondary school examination certificate.</p>
</div>
<form method="post"
      action="{{route('urp.addCertificateResults',["id"=>base64_encode($certs->id)])}}"
      class="form row">
    {!! csrf_field() !!}

    <div class="form-group col-12">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 label-control">Examining Board: </label>
                    <div class="col-md-8 text-bold-600">{{$certs->examining_body}}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 label-control">Session: </label>
                    <div class="col-md-8 text-bold-600">{{$certs->result_month}} {{$certs->result_year}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 label-control">Level: </label>
                    <div class="col-md-8 text-bold-600">{{$certs->level=="O"?"O Level":($certs->level=="A"?"A Level":"")}}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4 label-control">Center & Candidate #:</div>
                    <div class="col-md-8 text-bold-600">{{$certs->center_number}}
                        - {{$certs->candidate_number}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4 label-control">Certificate Number</div>
                    <div class="col-md-8 text-bold-600">{{$certs->certificate_number}}</div>
                </div>
            </div>
        </div>
    </div>

    @php($i = 0)
    @while($i < $certs->number_of_subjects)
        <div class="form-group col-12">
            <div class="row">
                <div class="form-group col-md-7">
                    <label class="label-control" for="subject">Subject</label>
                    @if($certs->examining_body == "ZIMSEC")
                        {!! Form::select("cert[{$i}][subject]",
                        \DB::table('secondary_subject_list')
                        ->where(["level"=>$certs->level,"board"=>$certs->examining_body,"is_approved"=>1])
                        ->orderBy("subject")
                        ->pluck('subject','subject'), null,
                         ["class"=>"form-control", "id"=>"form_control_1"]) !!}
                    @else
                        <input type="text" class="form-control subject-suggestable"
                               name="cert[{{$i}}][subject]"
                               value="{{old("cert.{$i}.subject")}}">
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label class="label-control" for="grade_1">Grade</label>
                    <select name="cert[{{$i}}][grade]" class="form-control"
                            id="grade_1">
                        <option value=""></option>
                        <option value="A" {{(old("cert.{$i}.grade")=="A")?"selected":""}}> A
                        </option>
                        <option value="B" {{(old("cert.{$i}.grade")=="B")?"selected":""}}>B
                        </option>
                        <option value="C" {{(old("cert.{$i}.grade")=="C")?"selected":""}}>C
                        </option>
                        <option value="D" {{(old("cert.{$i}.grade")=="D")?"selected":""}}>D
                        </option>
                        <option value="E" {{(old("cert.{$i}.grade")=="E")?"selected":""}}>E
                        </option>
                        @if($certs->level == "A")
                            <option value="F" {{(old("cert.{$i}.grade")=="F")?"selected":""}}>
                                F
                            </option>
                            <option value="O" {{(old("cert.{$i}.grade")=="O")?"selected":""}}>
                                O
                            </option>
                        @endif
                        <option value="U" {{(old("cert.{$i}.grade")=="U")?"selected":""}}>U
                        </option>
                    </select>

                </div>
            </div>
        </div>
        @php($i++)
    @endwhile

    <div class="form-group col-12 last">
        <button type="submit" class="btn btn-primary">
            <i class="la la-check-square-o"></i> Save
        </button>

        @if($certs->examining_body == "ZIMSEC")
            <?php
            $parameter = request()->input();
            $parameter["id"] = base64_encode($certs->id);
            $parameter["opt"] = "report_missing";
            ?>

            <a href="{{route("ur.addCertificateResults",$parameter)}}" class="mr-1">
                Report missing subject
            </a>
        @endif
    </div>

</form>