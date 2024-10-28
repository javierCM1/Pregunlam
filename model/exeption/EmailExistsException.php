<?php

class EmailExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct("El correo electrónico ya está en uso");
    }
}