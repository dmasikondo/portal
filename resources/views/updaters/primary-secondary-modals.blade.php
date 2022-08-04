<div class="modal fade text-left" id="primarySchoolModal" tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel17"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Add Primary School</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="{{route('urp.addPrimary')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-body">

                        <div class="row">
                            <div class="form-group col-12 mb-2">
                                <label for="school">School</label>
                                <input class="form-control border-primary"
                                       name="school" type="text"
                                       placeholder="Primary School"
                                       id="school">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-2">
                                <label for="from_grade">From Grade</label>
                                <input type="number" id="from_grade"
                                       class="form-control border-primary"
                                       placeholder="From Grade"
                                       name="from_grade">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="to_grade">To Grade</label>
                                <input type="number" id="to_grade"
                                       class="form-control border-primary"
                                       placeholder="To Grade"
                                       name="to_grade">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-2">
                                <label for="from_year">From Year</label>
                                <input type="number" id="from_year"
                                       class="form-control border-primary"
                                       placeholder="From Year"
                                       name="from_year">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="to_year">To Year</label>
                                <input type="number" id="to_year"
                                       class="form-control border-primary"
                                       placeholder="To Year"
                                       name="to_year">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-outline-primary">Save
                        Primary School
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="secondarySchoolModal" tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel17"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Add Secondary School</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" method="post" action="{{route('urp.addSecondary')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-body">

                        <div class="row">
                            <div class="form-group col-12 mb-2">
                                <label for="school">School</label>
                                <input class="form-control border-primary"
                                       name="school" type="text"
                                       placeholder="Secondary School"
                                       id="school">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-2">
                                <label for="from_grade">From Form</label>
                                <input type="number" id="from_form"
                                       class="form-control border-primary"
                                       placeholder="From Form"
                                       name="from_form">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="to_grade">To Form</label>
                                <input type="number" id="to_form"
                                       class="form-control border-primary"
                                       placeholder="To Form"
                                       name="to_form">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-2">
                                <label for="from_year">From Year</label>
                                <input type="number" id="from_year"
                                       class="form-control border-primary"
                                       placeholder="From Year"
                                       name="from_year">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="to_year">To Year</label>
                                <input type="number" id="to_year"
                                       class="form-control border-primary"
                                       placeholder="To Year"
                                       name="to_year">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-outline-primary">Save
                        Secondary School
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addOlevelCertificate" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="Add OLevel Certificate" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Add an O'level Certificate</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route'=>'urp.addOLevel',"role"=>"form",'id'=>"addOlevelCertificates"]) !!}
            <div class="modal-body" id="olevelCertificatesModal">

                <div class="form-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="month_1">Month</label>
                                <select name="month" class="form-control" id="month_1">
                                    <option value=""></option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="year_1">Year</label>
                                <input name="year" type="text" class="form-control"
                                       id="year_1">
                                <span class="help-block">ex. 2008</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Examining
                                    Body</label>
                                <input name="level" type="hidden" value="O">
                                <input name="examining_body" type="text"
                                       class="form-control"
                                       id="form_control_1">
                                <span class="help-block">ex. ZIMSEC, CAMBRIDGE</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Certificate
                                    Number</label>
                                <input name="certificate_number" type="text"
                                       class="form-control" id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Center
                                    Number</label>
                                <input name="center_number" type="text" class="form-control"
                                       id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Candidate
                                    Number</label>
                                <input name="candidate_number" type="text"
                                       class="form-control"
                                       id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div id="certificate_subjects">
                        <h5 id="clicky4">Subjects On Certificate</h5>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="label-control"
                                           for="subject">Subject</label>
                                    <input name="cert[0][subject]" type="text"
                                           class="form-control subjects-w"
                                           id="subject">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label-control" for="grade_1">Grade</label>
                                    <select name="cert[0][grade]" class="form-control"
                                            id="grade_1">
                                        <option value=""></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="U">U</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="subjectAdder"
                            class="btn btn-info btn-min-width block">Add
                        Another Subject
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                {{--<button class="btn default" data-dismiss="modal" aria-hidden="true">--}}
                {{--Close--}}
                {{--</button>--}}
                <button type="submit" class="btn btn-info btn-min-width">Save</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

<div id="addAlevelCertificate" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="Add ALevel Certificate" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Add an A'level Certificate</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="alevelCertificatesModal">
                {!! Form::open(['route'=>'urp.addOLevel',"role"=>"form",'id'=>"addALevelCertificates"]) !!}

                <div class="form-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="month_1">Month</label>
                                <select name="month" class="form-control" id="month_1">
                                    <option value=""></option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="year_1">Year</label>
                                <input name="year" type="text" class="form-control"
                                       id="year_1">
                                <span class="help-block">ex. 2008</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Examining
                                    Body</label>
                                <input name="level" type="hidden" value="A">
                                <input name="examining_body" type="text"
                                       class="form-control"
                                       id="form_control_1">
                                <span class="help-block">ex. ZIMSEC, CAMBRIDGE</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Certificate
                                    Number</label>
                                <input name="certificate_number" type="text"
                                       class="form-control" id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Center
                                    Number</label>
                                <input name="center_number" type="text" class="form-control"
                                       id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-control" for="form_control_1">Candidate
                                    Number</label>
                                <input name="candidate_number" type="text"
                                       class="form-control"
                                       id="form_control_1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div id="a_certificate_subjects">
                        <h5 id="clicky4">Subjects On Certificate</h5>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="label-control"
                                           for="subject">Subject</label>
                                    <input name="cert[0][subject]" type="text"
                                           class="form-control subjects-a"
                                           id="subject">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label-control" for="grade_1">Grade</label>
                                    <select name="cert[0][grade]" class="form-control"
                                            id="grade_1">
                                        <option value=""></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="U">U</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="ASubjectAdder"
                            class="btn btn-info btn-min-width block">Add
                        Another Subject
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                {{--<button class="btn default" data-dismiss="modal" aria-hidden="true">--}}
                {{--Close--}}
                {{--</button>--}}
                <button type="submit" class="btn btn-info btn-min-width">Save
                </button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

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