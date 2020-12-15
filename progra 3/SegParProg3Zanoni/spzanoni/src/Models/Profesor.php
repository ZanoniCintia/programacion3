<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model {

    protected $table = 'profesores';//tabla
    protected $primaryKey = 'pLegajo';
    //public $incrementing = false;//se usa cuando el primarykey es string , no int
    //protected $keyType = 'string';//se usa cuando el primarykey es string , no int
    public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}