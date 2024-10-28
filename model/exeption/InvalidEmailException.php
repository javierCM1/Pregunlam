<?php

class InvalidEmailException extends Exception
{
    public function __construct()
    {
        parent::__construct("El correo electrónico no es válido");
    }
}