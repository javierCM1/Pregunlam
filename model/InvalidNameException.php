<?php

class InvalidNameException extends Exception
{
    public function __construct()
    {
        parent::__construct("Caracteres no válidos en el campo nombre");
    }
}