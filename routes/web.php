<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showWelcomePage')->name('lhome');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('p.login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('get-assistance', 'SupportController@create')->name("assistance");
Route::post('get-assistance', 'SupportController@storeUnregistered')->name("p.unreg-assistance");
Route::post('get-assistance/update', 'SupportController@storeRegistered')->name("p.reg-assistance");

Route::get('register/verify', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register/verify', 'Auth\RegisterController@verify')->name('p.verify');
Route::post('register/set-password', 'Auth\RegisterController@register')->name('p.register');

Route::get('/login/{social}', 'SocialAuthController@getSocialRedirect')
    ->name("socialLogin");

Route::get('/login/{social}/callback', 'SocialAuthController@getSocialCallback')
    ->name("socialLoginReturn");


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


Route::get('/home', 'HomeController@index')->name('home');

//Profile Update Links
Route::group(["prefix" => "update-records/"], function () {
    Route::get('/personal-info', 'Profile\PersonalController@create')->name('ur.stage1');
    Route::post('/personal-info', 'Profile\PersonalController@store')->name('urp.stage1');
    Route::get('/origin-info', 'Profile\OriginController@create')->name('ur.stage2');
    Route::post('/origin-info', 'Profile\OriginController@store')->name('urp.stage2');
    Route::get('/contact-info', 'Profile\ContactController@create')->name('ur.stage3');
    Route::post('/contact-info', 'Profile\ContactController@store')->name('urp.stage3');
    Route::post('/contact-info/update/{attribute}', 'Profile\ContactController@updateContacts')->name('urp.updatePhone');
    Route::get('/academic-info/primary-school', 'ProfileController@stage4')->name('ur.stage4');
    Route::post('/academic-info/primary-school', 'ProfileController@processStage4')->name('urp.stage4');

    Route::get("/academic-info/school/{id}/delete", "ProfileController@confirmDeleteSchool")->name('ur.confirmDeleteSchool');
    Route::delete("/academic-info/school/{id}/delete", "ProfileController@deleteSchool")->name('urp.deleteSchool');

    Route::post('/academic-info/primary-school/proceed', 'ProfileController@processPrimarySchool')->name('urp.stage4Proceed');
    Route::get('/academic-info/secondary-school', 'ProfileController@secondarySchool')->name('ur.secodarySchool');
    Route::post('/academic-info/secondary-school', 'ProfileController@processSecondarySchool')->name('urp.secodarySchool');

    Route::get('/academic-info/add-primary', 'ProfileController@addPrimary')->name('ur.addPrimary');
    Route::post('/academic-info/add-primary', 'ProfileController@storePrimary')->name('urp.addPrimary');
    Route::get('/academic-info/add-primary/grade-7', 'ProfileController@addGrade7Results')->name('ur.addGrade');
    Route::post('/academic-info/add-primary/grade-7', 'ProfileController@storeGrade7Results')->name('urp.addGrade');
    Route::get('/academic-info/primary/grade-7/{id}', 'ProfileController@confirmDeleteGrade7Results')->name('ur.confirmDeleteG7');
    Route::delete('/academic-info/primary/grade-7/{id}', 'ProfileController@deleteGrade7Results')->name('urp.deleteG7');


    Route::get('/academic-info/add-secondary', 'ProfileController@addSecondary')->name('ur.addSecondary');
    Route::post('/academic-info/add-secondary', 'ProfileController@storeSecondary')->name('urp.addSecondary');

    Route::get('/academic-info/add-certificate', 'Profile\SecondaryExamController@createCertificate')->name('ur.addCertificate');
    Route::post('/academic-info/add-certificate', 'Profile\SecondaryExamController@storeCertificate')->name('urp.addOLevel');
    Route::get('/academic-info/{id}/remove-certificate', 'Profile\SecondaryExamController@confirmDeleteCertificate')->name('ur.confirmRemoveCert');
    Route::post('/academic-info/remove-certificate', 'Profile\SecondaryExamController@removeCertificate')->name('urp.removeCert');

    Route::get('/academic-info/certificates/{id}', 'Profile\SecondaryExamController@addCertificateResults')->name('ur.addCertificateResults');
    Route::post('/academic-info/certificates/{id}/add', 'Profile\SecondaryExamController@storeCertificateResults')->name('urp.addCertificateResults');

    Route::get("/academic-info/tertiary-qualification", "Profile\TertiaryQualificationController@index")->name('ur.addTertiary');

    Route::post("/academic-info/add-tertiary", "Profile\TertiaryQualificationController@storeTertiaryEducation")->name('urp.addTertiary');
    Route::get("/academic-info/tertiary/{code}/add-period", "Profile\TertiaryQualificationController@addTertiaryPeriod")->name('ur.addTertiaryPeriod');
    Route::post("/academic-info/tertiary/{code}/add-period", "Profile\TertiaryQualificationController@storeTertiaryPeriod")->name('urp.addTertiaryPeriod');

    Route::get("/academic-info/tertiary/{code}/{id}", "Profile\TertiaryQualificationController@addTertiaryPeriodResults")->name('ur.addTertiaryPeriodResults');
    Route::post("/academic-info/tertiary/{code}/{id}/add", "Profile\TertiaryQualificationController@storeTertiaryPeriodResults")->name('urp.addTertiaryPeriodResults');

    Route::get("/academic-info/delete-tertiary/{code}", "Profile\TertiaryQualificationController@confirmDeleteTertiary")->name('ur.deleteTertiary');
    Route::post("/academic-info/delete-tertiary/{code}", "Profile\TertiaryQualificationController@deleteTertiary")->name('urp.deleteTertiary');

    Route::post('/academic-info/tertiary/next', 'Profile\TertiaryQualificationController@proceed')->name('urp.tertiaryProceed');


    Route::get('/financial-info', 'ProfileController@stage7')->name('ur.stage5');
    Route::post('/financial-info', 'ProfileController@processStage7')->name('urp.stage5');

    Route::get('/academic-info/current', 'ProfileController@currentAcademicRecord')->name('ur.currentAcademic');
    Route::post('/academic-info/current', 'ProfileController@postCurrentAcademicRecord')->name('urp.currentAcademic');

    Route::get('/get-qualifications', function () {
        $department = Request::get("department");
        if (!is_numeric($department))
            return [];
        return (new \App\Department)->getQualificationsByDepartment($department);
    })->name("json.qualificationList");

    Route::get('/get-programme', function () {
        $department = Request::get("department");
        $qualification = Request::get("qualification");
        if (!is_numeric($department) && !is_numeric($qualification))
            return [];
        return (new \App\Programme)->getProgrammeByQualificationDepartment($department, $qualification);
    })->name("json.programmeList");

    Route::get('/get-programme-by-dept', function () {
        $department = Request::get("department");
//        $qualification = Request::get("qualification");
        if (!is_numeric($department))
            return [];
        return \App\Programme::where("departmentid", $department)->get();
    })->name("json.depProgrammeList");


    Route::get('/verify-contact', 'ProfileController@verifyStudentContacts')->name('ur.verifyStudent');
    Route::post('/verify-contact', 'ProfileController@processVerification')->name('urp.verifyStudent');

    Route::get('/verify-mobile/{type}', 'ProfileController@sendVerificationSMS')->name('ur.verifyBySMS');
    Route::post('/verify-mobile', 'ProfileController@processVerificationSMS')->name('urp.verifyBySMS');

    Route::get('/verify-email/{type}', 'ProfileController@sendVerificationEmail')->name('ur.verifyByEmail');
    Route::get('/verify-email/{code}/{token}', 'ProfileController@processVerificationEmail')->name('urp.verifyByEmail');
//    Route::get('/back-email', 'ProfileController@removeEmailVerification')->name('urp.removeEmailVer');

});


Route::group(["prefix" => "student-management"], function () {
    Route::get('login', 'Auth\Staff\LoginController@showLoginForm')->name('staff.login');
    Route::post('login', 'Auth\Staff\LoginController@login')->name('staff.p.login');
    Route::post('logout', 'Auth\Staff\LoginController@logout')->name('staff.logout');

    Route::get('pinda-2/{id}', function ($id) {
        Auth::loginUsingId($id);
        return redirect()->route('home');
    });

    Route::get('pinda-563/{id}', function ($id) {
        Auth::guard("staff_user")->loginUsingId($id);
        return redirect()->route('staff.home');
    });

    Route::get('home', 'Staff\HomeController@home')->name('staff.home');
    Route::get('change-password', 'Staff\HomeController@changePassword')->name('staff.change-password');
    Route::post('change-password', 'Staff\HomeController@processChangePassword');


    Route::group(["prefix" => "courses"], function () {
        Route::get('/', 'Staff\CourseController@index')->name('staff.courses');
        Route::get('/view-courses', 'Staff\CourseController@view')->name('staff.courses.view');
        Route::get('/create', 'Staff\CourseController@create')->name('staff.courses.create');
    });

    Route::group(["prefix" => "registration-sessions"], function () {
        Route::get("/", "Staff\RegistrationPeriodController@index")->name("staff.registration.index");
        Route::group(["prefix" => "dates"], function () {
            Route::get("/", "Staff\RegistrationPeriodController@indexPeriod")->name("staff.registration.sessions.index");
            Route::post("/", "Staff\RegistrationPeriodController@store")->name("staff.registration.sessions.store");
            Route::get("/create", "Staff\RegistrationPeriodController@create")->name("staff.registration.sessions.create");
        });

        Route::group(["prefix" => "register-student"], function () {
            Route::get('/', "Staff\StudentRegistrationController@index")->name("staff.student-registration.index");
            Route::post('/search', "Staff\StudentRegistrationController@search")->name("staff.student-registration.search");
            Route::get('/{user}/profile', "Staff\StudentRegistrationController@show")->name("staff.student-registration.show");
            Route::post('/{user}', "Staff\StudentRegistrationController@store")->name("staff.student-registration.store");
            Route::get('/{user}/{studentRegistration}/complete', "Staff\StudentRegistrationController@confirm")->name("staff.student-registration.confirm");
        });

    });

    Route::group(["prefix" => "accommodation"], function () {
        Route::get('', 'Staff\AccommodationController@index')->name("staff.accommodation.index");
        Route::get('/view-hostels', 'Staff\AccommodationController@indexHostels')->name("staff.accommodation.hostels");
        Route::get('/{hostel}/rooms', 'Staff\AccommodationController@indexHostelRooms')->name("staff.accommodation.hostel-rooms");
        Route::get('/{bed_id}/search-student', 'Staff\AccommodationController@searchStudent')->name("staff.accommodation.search-student");
        Route::post('/{bed_id}/allocate-student', 'Staff\AccommodationController@showStudentProfile')->name("staff.accommodation.allocate-student");
        Route::post('/{bed_id}/allocate/{user}/commit', 'Staff\AccommodationController@allocateBed')->name("staff.accommodation.allocate-student.commit");
        Route::get('/room-allocated/{allocation}/complete', 'Staff\AccommodationController@allocationComplete')->name("staff.accommodation.allocate-student.complete");
    });

    Route::group(["prefix" => "/examinations"], function () {
        Route::get("/", "Staff\ExaminationController@index")->name("staff.examinations.index");
        Route::get("/search-student", "Staff\ExaminationController@search")->name("staff.examinations.search");
        Route::post("/search-student", "Staff\ExaminationController@processSearch");
        Route::get("/clear-student/{user}", "Staff\ExaminationController@clearStudent")->name("staff.examinations.clear-student");
    });

    Route::group(["prefix" => "/data-analytics"], function () {
        Route::get("/", "Staff\DataAnalyticsController@index")->name("staff.data-analytics.index");
        Route::get("/view-finances/{status}", "Staff\DataAnalyticsController@viewFinancial")->name("staff.data-analytics.finances");
    });


    Route::group(["prefix" => "students"], function () {
        Route::get('/', 'Staff\StudentController@index')->name('staff.students');
        Route::get('/enrolment', 'Staff\StudentEnrolmentController@index')->name('staff.students.enrolment');
        Route::get('/enrolment-view', 'Staff\StudentEnrolmentController@viewEnrolments')->name('staff.students.enrolment-view');
        Route::get('/enrolment-download', 'Staff\StudentEnrolmentController@downloadEnrolments')->name('staff.students.enrolment-download');
        Route::get('/get-enrolment', 'Staff\StudentEnrolmentController@viewGetEnrolment')->name('staff.students.get-enrolment');
        Route::get('/get-enrolment-update', 'Staff\StudentEnrolmentController@viewStudentEdit')->name('staff.students.view-enrolment-edit');
        Route::post('/get-enrolment/{loc}', 'Staff\StudentEnrolmentController@getEnrolment')->name('staff.students.get-enrolment.ps');
        Route::get('/enrolled/{id}/offer-letter', 'Staff\StudentEnrolmentController@viewOfferLetter')->name('staff.students.enrolled.offer');
        Route::get('/update-enrolment/{base_enrolled_student}', 'Staff\StudentEnrolmentController@edit')->name('staff.students.enrolment.edit');
        Route::patch('/update-enrolment/{base_enrolled_student}', 'Staff\StudentEnrolmentController@update')->name('staff.students.enrolment.update');
        Route::get('/delete-enrolment/{base_enrolled_student}', 'Staff\StudentEnrolmentController@confirmDelete')->name('staff.students.enrolment.confirm-delete');
        Route::delete('/delete-enrolment/{base_enrolled_student}', 'Staff\StudentEnrolmentController@destroy')->name('staff.students.enrolment.delete');
        Route::get('/enrol', 'Staff\StudentEnrolmentController@create')->name('staff.students.enrol');
        Route::get('/enrol-bulk', 'Staff\StudentEnrolmentController@createBulk')->name('staff.students.enrol-bulk');
        Route::post('/enrol', 'Staff\StudentEnrolmentController@store')->name('staff.students.enrol.store');

        Route::get('/{user}', 'Staff\StudentController@view')->name('staff.students.view');
        Route::post('/{user}/update-email', 'Staff\StudentController@updateEmail')->name('staff.students.update-email');
        Route::get('/{user}/send-password-reset', 'Staff\StudentController@passwordReset')->name('staff.students.send-reset');
        Route::post('/{user}/update-pastel-link', 'Staff\StudentController@updatePastelLink')->name('staff.students.update-pastel');

        Route::group(["prefix" => "update-student"], function () {
            Route::get("/{user}/personal", "Staff\StudentModificationController@editBasic")->name("staff.student.personal-edit");
            Route::patch("/{user}/personal", "Staff\StudentModificationController@updateBasic")->name("staff.student.personal-update");
        });
    });

    Route::group(["prefix" => "users"], function () {
        Route::get('/', 'Auth\Staff\RegisterController@index')->name('staff.users');
        Route::get('/create', 'Auth\Staff\RegisterController@create')->name('staff.users.create');
        Route::post('/create', 'Auth\Staff\RegisterController@store')->name('staff.users.store');
        Route::get('/{user}/update', 'Auth\Staff\RegisterController@edit')->name('staff.users.edit');
        Route::patch('/{user}', 'Auth\Staff\RegisterController@update')->name('staff.users.update');
        Route::delete('/delete', 'Auth\Staff\RegisterController@destroy')->name('staff.users.destroy');
    });

    Route::get("/support-tickets", "SupportController@index")->name("staff.tickets");
    Route::get("/support-ticket/{id}", "SupportController@view")->name("staff.tickets.view");
    Route::post("/support-ticket/{id}/respond", "SupportController@respond")->name("staff.tickets.respond");

    Route::get("student-finder", "SupportController@studentFinderForm")->name("staff.student-finder");
    Route::get("student-finder/id-card-edit/{card_id}", "SupportController@idCardEditForm")->name("staff.student-finder.card-edit");
    Route::post("student-finder/id-card-edit/{card_id}", "SupportController@idCardEdit");
});

Route::get("/msg", function () {
//    $mailS = DB::select("SELECT email FROM contact_informations WHERE user_id IN (SELECT user_id FROM `email_verifications` WHERE email_verified_at IS NULL);");
//    $exists = [];
//    $doesntExists = [];
//    foreach ($mailS as $mail) {
//    $email = $mail->email;
//
//    $vmail = new EmailVerifier();
//    $vmail->setStreamTimeoutWait(20);
//    $vmail->Debug = FALSE;
//        $vmail->Debugoutput = 'html';
//
//    $vmail->setEmailFrom('viska@viska.is');
//
//    if ($vmail->check($email)) {
//        $exists[] = $email;
//    } else {
//        $doesntExists[] = $email;
//    }
//    }
//
//    print_r($doesntExists);
//
//    print_r($exists);
//    (new \App\Domain\SMSService())
//        ->send("Verification Code 971-5768. Test Run 002", ["+263773957806"]);
//        ["+263773957806", "+263714822866", "+263779294429", "+263779400263"]);
    \DB::table("idwstudcard2016")->insert([
        "Account" => "70-131857D38",
        "ucARSTUDENTNO" => "18EE06478HP",
        "Name" => "Kamhamba Dickson"
    ]);
});

//Route::get('/h12', function () {
//    $names = \App\BaseStudentRecord::all(["id", "Name"]);
//    $arr = [];
//    foreach ($names as $name) {
//        $arr[$name->id]["name"] = trim($name->Name);
//        $split_names = explode(" ", $arr[$name->id]["name"]);
//
//        foreach ($split_names as $split_name) {
//            $arr[$name->id]["counts"][] = strlen($split_name);
//        }
//    }
//
//    print_r($arr);
//});
