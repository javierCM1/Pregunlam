<?php

class InvalidGenderException extends Exception
{
    public function __construct()
    {
        parent::__construct("El género no es válido");
    }
}