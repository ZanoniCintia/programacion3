<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model {

    protected $table = 'encuestas';
    //protected $primaryKey = 'idComanda';
    //public $incrementing = false;
    protected $keyType = 'string';
   public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}