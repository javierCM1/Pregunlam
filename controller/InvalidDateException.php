<?php

class InvalidDateException extends Exception
{
    public function __construct()
    {
        parent::__construct("La fecha de nacimiento no es válida");
    }
}