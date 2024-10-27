<?php

class EditorModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerReportes()
    {
        $query = $this->database->prepare("SELECT * FROM reporte_pregunta");
        $query->execute();
        $reportes = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return $reportes;
    }
}