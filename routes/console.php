<?php

use App\User;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('user-update:all', function () {

    foreach (User::all() as $user) {
        $user->update(["update_record" => "Y"]);
        $user->userProfileUpdatePlan()->createMany([
            ["stage" => 1, "total_stages" => 9, "route" => "ur.stage1", "status" => "A", "exception_routes" => ['urp.stage1']],
            ["stage" => 2, "total_stages" => 9, "route" => "ur.stage2", "exception_routes" => ['urp.stage2']],
            ["stage" => 3, "total_stages" => 9, "route" => "ur.stage3", "exception_routes" => ['urp.stage3']],
            ["stage" => 4, "total_stages" => 9, "route" => "ur.stage4", "exception_routes" => ["urp.stage4Proceed", "ur.addPrimary", "urp.addPrimary", "ur.addGrade", "urp.addGrade", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmDeleteG7", "urp.deleteG7"]],
            ["stage" => 5, "total_stages" => 9, "route" => "ur.secodarySchool", "exception_routes" => ["urp.secodarySchool", "ur.addSecondary", "urp.addSecondary", "urp.addOLevel", "urp.removeCert", "ur.addCertificate", "ur.addCertificateResults", "urp.addCertificateResults", "ur.confirmDeleteSchool", "urp.deleteSchool", "ur.confirmRemoveCert"]],
            ["stage" => 6, "total_stages" => 9, "route" => "ur.addTertiary", "exception_routes" => ['urp.stage4', 'urp.addTertiary', 'ur.addTertiaryPeriod', 'urp.addTertiaryPeriod', 'urp.tertiaryProceed', 'ur.addTertiaryPeriodResults', 'urp.addTertiaryPeriodResults']],
            ["stage" => 7, "total_stages" => 9, "route" => "ur.stage5", "exception_routes" => ['urp.stage5']],
            ["stage" => 8, "total_stages" => 9, "route" => "ur.currentAcademic", "exception_routes" => ['urp.currentAcademic', "json.qualificationList", "json.programmeList"]],
            ["stage" => 9, "total_stages" => 9, "route" => "ur.verifyStudent", "exception_routes" => ['urp.verifyStudent', 'ur.verifyBySMS', 'urp.verifyBySMS', 'ur.verifyByEmail', 'urp.verifyByEmail', 'urp.updatePhone', "urp.updateEmail"]],
        ]);
        $this->comment("User Profile Update Plan created for {$user->first_name} {$user->last_name}.");

    }

})->describe('Create an update user plan for all users');
