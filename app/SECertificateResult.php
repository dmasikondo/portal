<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SECertificateResult extends Model
{
    protected $fillable = ['certificate_id', 'subject', 'grade'];

    public function secondaryExamCertificate()
    {
        return $this->belongsTo(SecondaryExamCertificate::class, 'certificate_id');
    }
}
