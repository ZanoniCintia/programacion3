<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    protected $table = 'productos';
    //protected $primaryKey = 'codigo';
    //public $incrementing = false;
    //protected $keyType = 'string';
    public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}