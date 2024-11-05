<?php

class ReportesController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function index()
    {
        $username = $_SESSION['user'];
        $reportes = $this->model->obtenerReportes();

        $this->presenter->show('reportes', ['username' => $username, 'reportes' => $reportes]);
    }

    public function activar()
    {
        $idPregunta = $_GET['id'];
        $idReporte = $_GET['reporte'];

        $this->model->cambiarEstadoPreguntaReportada($idPregunta,2);
        $this->model->borrarReporte($idReporte);

        header('Location: /reportes');
        exit();
    }

    public function desactivar()
    {
        $idPregunta = $_GET['id'];
        $idReporte = $_GET['reporte'];

        $this->model->cambiarEstadoPreguntaReportada($idPregunta,5);
        $this->model->borrarReporte($idReporte);

        header('Location: /reportes');
        exit();
    }
}