<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryExamCertificate extends Model
{
    protected $fillable = ['user_id', 'result_month', 'result_year', 'examining_body', 'level', 'certificate_number',
        'center_number', 'candidate_number', 'number_of_subjects'];

    public function results()
    {
        return $this->hasMany(SECertificateResult::class, 'certificate_id');
    }
}
