<?php

class Respuesta
{
    public $status;
    public $data;

    public function __construct()
    {
        $this->status = 'success';
    }
}

?>