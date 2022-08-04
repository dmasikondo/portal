@extends('layouts.master')

@section('pageTitle',"Verify Contact Details")

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
                                <p>Please provide your verify your contact details.</p>
                            </div>

                            @php
                                $codeNotSent = is_null($cellphone_verify);
                                $modifying = (in_array(request("modify"),["mobile","email"]));
                                $modifyingPhone = request("modify") == "mobile";
                                $modifyingEmail = request("modify") == "email";

                                $emailNotSent = is_null($email_verify);
                                $emailSentAndNotVerified = !$emailNotSent && is_null($email_verify->email_verified_at);
                                $emailSentAndVerified = !$emailNotSent && !is_null($email_verify->email_verified_at);

                                $codeNotSentAndNotModifying = ( $codeNotSent && !$modifying);
                                $codeNotSentAndModifyingPhone = ($codeNotSent && $modifyingPhone);
                                $codeSentNotVerified = (!is_null($cellphone_verify) && is_null($cellphone_verify->sms_verified_at));
                                $codeSentVerified = (!is_null($cellphone_verify) && !is_null($cellphone_verify->sms_verified_at));
                            @endphp

                            @includeWhen($codeNotSentAndNotModifying,"profile.verification-partials.confirm-number",["cellphone"=>$contacts->cellphone])
                            @includeWhen($codeNotSentAndModifyingPhone,"profile.verification-partials.change-number")
                            @includeWhen($codeSentNotVerified,'profile.verification-partials.enter-verification-code')
                            @includeWhen(($codeSentVerified && $emailNotSent && !$modifying),'profile.verification-partials.confirm-email',["email"=>$contacts->email])
                            @includeWhen(($codeSentVerified && $emailNotSent && $modifyingEmail),'profile.verification-partials.change-email')
                            @includeWhen(($codeSentVerified && $emailSentAndNotVerified),'profile.verification-partials.resend-email')
                            @includeWhen(($codeSentVerified && $emailSentAndVerified),'profile.verification-partials.verification-complete')

                            <form class="form form-horizontal form-bordered" method="post"
                                  action="{{route('urp.verifyStudent')}}">
                                {!! csrf_field() !!}

                                <div class="form-actions right">
                                    <button type="button" class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
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
