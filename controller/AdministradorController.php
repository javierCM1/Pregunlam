<?php

class AdministradorController
{
    private $model;

    private $userModel;
    private $presenter;

    private $ChartGenerator;


    public function __construct($model,$userModel, $presenter, $ChartGenerator)
    {
        $this->model = $model;
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->ChartGenerator = $ChartGenerator;
    }

    public function index()
    {
        $username = $_SESSION['user'];
        $estado = 2;



        $numeroDePreguntas = $this->model->obtenerNumeroDePreguntasActivasPorCategoria($estado);
        $numeroDeUsuariosPorSexo = $this->userModel->obtenerNumeroDeUsuariosPorSexo();


        $preguntasLabels = [];
        $preguntasData = [];

        foreach ($numeroDePreguntas as $categoria) {
            $preguntasLabels[] = $categoria['descripcion_categoria'];
            $preguntasData[] = $categoria['numero_preguntas'];
        }


        $usuariosLabels = [];
        $usuariosData = [];

        foreach ($numeroDeUsuariosPorSexo as $sexo) {
            $usuariosLabels[] = $sexo['descripcion_sexo'];
            $usuariosData[] = $sexo['numero_usuario'];
        }

        $preguntasChartPath = 'public/images/graficos/grafico-Preguntas-por-Categoría.png';
        $usuariosChartPath = 'public/images/graficos/grafico-Usuarios-por-Sexo.png';


        if (file_exists($preguntasChartPath)) {
            unlink($preguntasChartPath);
        }
        if (file_exists($usuariosChartPath)) {
            unlink($usuariosChartPath);
        }

        $chartWidth = 600;
        $chartHeight = 400;

        $this->ChartGenerator->generateBarChart(
            $preguntasData,
            $preguntasLabels,
            "Número de Preguntas por Categoría",
            $chartWidth,
            $chartHeight,
            $preguntasChartPath
        );


        $this->ChartGenerator->generatePieChart(
            $usuariosData,
            $usuariosLabels,
            "Número de Usuarios por Sexo",
            $chartWidth,
            $chartHeight,
            $usuariosChartPath
        );


        $this->presenter->show('administrador', [
            'preguntasChartPath' => $preguntasChartPath,
            'usuariosChartPath' => $usuariosChartPath,
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
