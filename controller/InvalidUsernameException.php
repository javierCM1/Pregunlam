<?php

class InvalidUsernameException extends Exception
{
    public function __construct()
    {
        parent::__construct("El nombre de usuario no es válido");
    }
}