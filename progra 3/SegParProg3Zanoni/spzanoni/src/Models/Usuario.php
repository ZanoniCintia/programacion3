<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    protected $table = 'usuarios';
    protected $primaryKey = 'legajo';
    //public $incrementing = false;
    //protected $keyType = 'string';
    public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}



