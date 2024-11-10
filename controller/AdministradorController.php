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

        $uploadDirectory = 'public/images/admin/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $chartFilePath = $uploadDirectory . 'grafico-Preguntas-por-Categoría.png';

        $this->barChartGenerator->generateChart($data,
                                                $labels,
                                                "Número de Preguntas por Categoría",
                                                600,//width
                                                400,//height
                                                $chartFilePath);

        $this->presenter->show('administrador', [
            'chartFilePath' => $chartFilePath,
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
