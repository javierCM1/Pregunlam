<?php

class InvalidPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct("La contraseña no es válida");
    }
}