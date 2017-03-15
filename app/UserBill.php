<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBill extends Model
{
    protected $table = "UserBill";
    protected $primaryKey = "Id";
    protected $hidden = [
        'Id', 'Created'
    ];
}
