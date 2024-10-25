<?php

class UsernameExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct("El nombre de usuario ya está en uso");
    }
}