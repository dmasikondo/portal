@extends('layouts.master')

@section('pageTitle',"Stage 5: Academic Information")

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

                                <?php
                                $addedSchool = ($school_records->where("school_type", "S")->count() > 0);
                                $addedOlevel = ($certificates->where('level', 'O')->count() > 0);
                                $addedAlevel = ($certificates->where('level', 'A')->count() > 0);
                                $olevelAddingDone = request("olevel") == "done" || $addedAlevel;
                                $goToReview = request("review") == "yes";
                                $addedSchoolNoOlevel = $addedSchool && !$addedOlevel;
                                $addedSchoolAndOlevelNotDone = $addedSchool && $addedOlevel && !$olevelAddingDone;
                                $addedSchoolAndOlevelDoneNotReview = $addedSchool && $addedOlevel && $olevelAddingDone && !$goToReview;
                                $addedSchoolAndOlevelDoneGoToReview = $addedSchool && $addedOlevel && $goToReview;
                                ?>

                                @includeWhen($addedSchoolNoOlevel,'profile.secondary-edu-partials.proceed-olevel')
                                @includeWhen($addedSchoolAndOlevelNotDone,'profile.secondary-edu-partials.proceed-alevel')
                                @includeWhen($addedSchoolAndOlevelDoneNotReview,'profile.secondary-edu-partials.alevel-check')
                                @includeWhen($addedSchoolAndOlevelDoneGoToReview,'profile.secondary-edu-partials.review-page')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascripts')
    <script>
        $("#subjectAdder").click(function () {
            let length = $('.subjects-w').length;
            $('#certificate_subjects').append(subjectGradeFields(length, 'w'));
        });

        $("#ASubjectAdder").click(function () {
            let length = $('.subjects-a').length;
            $('#a_certificate_subjects').append(subjectGradeFields(length, 'a'));
        });

        $(document).on('click', 'a.delFields', function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });

        $(document).on('click', 'a.delCert', function () {
            $('#delCertID').val($(this).data('id'));
        });

        function subjectGradeFields(field_length, letter, subject_val, grade_val) {
            subject_val = typeof subject_val !== 'undefined' ? subject_val : '';
            grade_val = typeof grade_val !== 'undefined' ? grade_val : '';

            if ($("[name='cert[" + field_length + "][subject]'].subjects-" + letter).length > 0) {
                field_length++;
                return subjectGradeFields(field_length, letter, subject_val, grade_val);
            }

            return '<div class="row"> <div class="col-md-9">' +
                ' <div class="form-group"> ' +
                '<label class="label-control" for="subject">Subject</label>' +
                ' <input name="cert[' + field_length + '][subject]" type="text" value="' + subject_val + '" class="form-control subjects-' + letter + '" id="subject"> ' +
                '</div> </div> ' +
                '<div class="col-md-3"> <div class="form-group"> ' +
                '<label class="label-control" for="grade_1">Grade</label> ' +
                ((field_length != 0) ? '<div class="input-group"> ' : '') +
                '<select name="cert[' + field_length + '][grade]" class="form-control" id="grade_1">' +
                '<option value=""></option> ' +
                '<option value="A"' + ((grade_val == "A") ? " selected" : "") + '>A</option>' +
                '<option value="B"' + ((grade_val == "B") ? " selected" : "") + '>B</option> ' +
                '<option value="C"' + ((grade_val == "C") ? " selected" : "") + '>C</option> ' +
                '<option value="D"' + ((grade_val == "D") ? " selected" : "") + '>D</option> ' +
                '<option value="E"' + ((grade_val == "E") ? " selected" : "") + '>E</option> ' +
                '<option value="U"' + ((grade_val == "U") ? " selected" : "") + '>U</option>' +
                ' </select> ' +
                ((field_length != 0) ? '<div class="input-group-append"><span class="input-group-text" id="basic-addon4">' +
                    '<a href="#" class="delFields danger"><i class="la la-trash"></i></a>' +
                    '</span></div></div>' : '') +
                ' </div> </div> </div>';
        }
    </script>
@endpush
