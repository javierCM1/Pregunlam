<?php

class AdministradorController
{
    private $model;
    private $presenter;
    private $barChartGenerator;

    public function __construct($model, $presenter, $barChartGenerator)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->barChartGenerator = $barChartGenerator;
    }

    public function index()
    {
        $username = $_SESSION['user'];
        $estado = 2;

        $numeroDePreguntas = $this->model->obtenerNumeroDePreguntasActivasPorCategoria($estado);

        $data = [];
        $labels = [];

        foreach ($numeroDePreguntas as $categoria) {
            $labels[] = $categoria['descripcion_categoria'];
            $data[] = $categoria['numero_preguntas'];
        }

        $chartFilePath = 'public/images/graficos/grafico-Preguntas-por-Categoría.png';


        if (!file_exists($chartFilePath)) {
            $title = "Número de Preguntas por Categoría";
            $width = 600;
            $height = 400;

            $this->barChartGenerator->generateChart($data, $labels, $title, $width, $height, $chartFilePath);
        }

        $this->presenter->show('administrador', [
            'chartFilePath' => $chartFilePath,
            'usuario' => $username,
            'username' => $username,
            'tipoUsuario' => 'administrador'
        ]);
    }



    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /login");
        exit();
    }
}
