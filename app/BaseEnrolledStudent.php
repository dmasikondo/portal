<?php

namespace App;

use App\Events\BaseEnrolledStudentDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseEnrolledStudent extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'student_no', 'title', 'first_name', 'last_name', "maiden_name", 'gender', 'date_of_birth',
        'national_id', "qualificationid", "programmeid", "mode_of_entry", "phone_number",
        "house_number", "street_name", "suburb", "city", "district", "country", "added_by", "record_hash"
    ];

    protected $dispatchesEvents = [
        'deleted' => BaseEnrolledStudentDeleted::class,
    ];

    public function __get($key)
    {
        if (is_string($this->getAttribute($key))) {
            return strtoupper($this->getAttribute($key));
        } else {
            return $this->getAttribute($key);
        }
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getModeOfEntryTxtAttribute()
    {
        return strtoupper(implode(" ", explode("_", $this->mode_of_entry)));
    }

    public function getAddressAttribute()
    {
        return $this->house_number . ' ' . $this->street_name . ", " . $this->suburb . ", " . $this->city . ", " . $this->country;
    }


    public function programme()
    {
        return $this->belongsTo(Programme::class, "programmeid");
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, "qualificationid");
    }
}
