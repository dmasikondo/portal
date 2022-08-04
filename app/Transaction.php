<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;
    protected $table = "transaction";
    protected $fillable = ["AutoIdx", "account_number", "ref", "transactiondate", "description", "debit", "credit"];
}
