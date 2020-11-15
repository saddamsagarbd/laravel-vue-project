<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'first_name','last_name','email','contact_no','nos_share','invst_amt','ref_no','address'
    ];
}
