<?php

class ReporteModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerReportes()
    {
        $query = $this->database->prepare("SELECT RP.id_reporte, 
                                            RP.motivo_reporte,
                                            RP.fecha_reporte,
                                            U.userName_usuario,
                                            P.id_pregunta,
                                            P.interrogante_pregunta,
                                            C.descripcion_categoria,
                                            R.descripcion_respuesta
                                            FROM reporte_pregunta RP
                                            JOIN usuario U ON RP.id_usuario=U.id_usuario
                                            JOIN pregunta P ON RP.id_pregunta=P.id_pregunta
                                            JOIN categoria C ON P.id_categoria=C.id_categoria
                                            JOIN respuesta R ON P.id_pregunta=R.id_pregunta 
                                                            AND R.esCorrecta_respuesta=1");
        $query->execute();
        $reportes = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return $reportes;
    }

    public function guardarReporte($motivo_reporte, $fecha_reporte, $id_usuario, $id_pregunta)
    {
        $query = $this->database->prepare("INSERT INTO reporte_pregunta (
                                                        motivo_reporte, 
                                                        fecha_reporte, 
                                                        id_usuario, 
                                                        id_pregunta) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssii", $motivo_reporte, $fecha_reporte, $id_usuario, $id_pregunta);
        $query->execute();
    }

    public function establecerPreguntaReportada($idPregunta)
    {
        $estado = 3;
        $queryPregunta = $this->database->prepare("UPDATE pregunta 
                                         SET id_estado = ?
                                         WHERE id_pregunta = ?");

        $queryPregunta->bind_param("ii", $estado,$idPregunta);
        $queryPregunta->execute();
    }

    public function cambiarEstadoPreguntaReportada($idPregunta,$estado)
    {
        $queryPregunta = $this->database->prepare("UPDATE pregunta 
                                         SET id_estado = ?
                                         WHERE id_pregunta = ?");

        $queryPregunta->bind_param("ii", $estado,$idPregunta);
        $queryPregunta->execute();
    }

    public function borrarReporte($idReporte)
    {
        $queryPregunta = $this->database->prepare("DELETE FROM `reporte_pregunta` WHERE id_reporte = ?");

        $queryPregunta->bind_param("i", $idReporte);
        $queryPregunta->execute();
    }
}