<?php

class PreguntaExpiradaException extends Exception
{
    public function __construct()
    {
        parent::__construct("Se terminó el tiempo");
    }
}