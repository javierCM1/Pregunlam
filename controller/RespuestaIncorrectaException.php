<?php

class RespuestaIncorrectaException extends Exception
{
    public function __construct()
    {
        parent::__construct("Respuesta Incorrecta");
    }
}