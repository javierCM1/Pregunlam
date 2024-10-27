<?php

class PartidaActivaNoExisteException extends Exception
{
    public function __construct()
    {
        parent::__construct("No existen partidas activas para el usuario");
    }
}