<?php

class AdministradorController
{
    private $model;

    private $userModel;
    private $presenter;

    private $ChartGenerator;


    public function __construct($model, $userModel, $presenter, $ChartGenerator)
    {
        $this->model = $model;
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->ChartGenerator = $ChartGenerator;
    }

    public function index()
    {
        $username = $_SESSION['user'];


        $this->presenter->show('administrador', [
            'usuario' => $username,
            'username' => $username,
            'tipoUsuario' => 'administrador'
        ]);

    }

    public function filtrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtroTiempo'])) {
            $_SESSION['filtroTiempo'] = $_POST['filtroTiempo'];
        }
        $filtroTiempo = isset($_SESSION['filtroTiempo']) ? $_SESSION['filtroTiempo'] : 'semana'; // Valor por defecto

        $username = $_SESSION['user'];
        $estado = 2;

        $fechaFin = date('Y-m-d');
        $fechaInicio = null;

        switch ($filtroTiempo) {
            case 'semana':
                $fechaInicio = date('Y-m-d', strtotime('last monday -1 week'));
                break;
            case 'mes':
                $fechaInicio = date('Y-m-d', strtotime('-1 month'));
                break;
            case 'anio':
                $fechaInicio = date('Y-m-d', strtotime('-1 year'));
                break;
        }

        $preguntasData = $this->model->obtenerNumeroDePreguntasActivasPorCategoria();//no se calcula por fecha
        $usuariosData = $this->userModel->obtenerNumeroDeUsuariosPorSexo();//no se calcula por fecha
        $usuariosNuevos = $this->userModel->obtenerCantidadUsuariosNuevos($fechaInicio, $fechaFin, $filtroTiempo);

        $uploadDirectory = 'public/images/graficos/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $preguntasChartPath = $uploadDirectory . 'grafico-Preguntas-por-Categoría.png';
        $usuariosChartPath = $uploadDirectory . 'grafico-Usuarios-por-Sexo.png';
        $usuariosNuevosChartPath = $uploadDirectory . 'grafico-Usuarios-Registrados.png';

        if (file_exists($preguntasChartPath)) {
            unlink($preguntasChartPath);
        }
        if (file_exists($usuariosChartPath)) {
            unlink($usuariosChartPath);
        }
        if (file_exists($usuariosNuevosChartPath)) {
            unlink($usuariosNuevosChartPath);
        }

        $chartWidth = 600;
        $chartHeight = 400;

        $preguntasValues = [];
        $preguntasLabels = [];
        foreach ($preguntasData as $pregunta) {
            $preguntasValues[] = $pregunta['numero_preguntas'];
            $preguntasLabels[] = $pregunta['descripcion_categoria'];
        }

        $usuariosValues = [];
        $usuariosLabels = [];
        foreach ($usuariosData as $usuario) {
            $usuariosValues[] = $usuario['numero_usuario'];
            $usuariosLabels[] = $usuario['descripcion_sexo'];
        }

        $usuariosNuevosValues = [];
        $usuariosNuevosLabels = [];
        foreach ($usuariosNuevos as $usuarioNuevo) {
            $usuariosNuevosValues[] = $usuarioNuevo['numero_usuarios_nuevos'];
            $usuariosNuevosLabels[] = $usuarioNuevo['mes_registro'];
        }

        if (!empty($preguntasData)) {
            $this->ChartGenerator->generateBarChart(
                $preguntasValues,
                $preguntasLabels,
                "Número de Preguntas por Categoría",
                $chartWidth,
                $chartHeight,
                $preguntasChartPath
            );
        }else {
            $preguntasChartPath = null;
        }

        if (!empty($usuariosData) > 0) {
            $this->ChartGenerator->generatePieChart(
                $usuariosValues,
                $usuariosLabels,
                "Número de Usuarios por Sexo",
                $chartWidth,
                $chartHeight,
                $usuariosChartPath
            );
        }else {
            $usuariosChartPath = null;
        }

        if (!empty($usuariosNuevos)) {
            $this->ChartGenerator->generateLineChart(
                $usuariosNuevosValues,
                $usuariosNuevosLabels,
                "Número de Usuarios Nuevos Registrados",
                $chartWidth,
                $chartHeight,
                $usuariosNuevosChartPath
            );
        } else {
            $usuariosNuevosChartPath = null;
        }

        $this->presenter->show('administrador', [
            'preguntasChartPath2' => $preguntasChartPath,
            'usuariosChartPath2' => $usuariosChartPath,
            'usuariosNuevosChartPath' => $usuariosNuevosChartPath,
            'username' => $_SESSION['user'],
            'tipoUsuario' => 'administrador',
            'filtroTiempo' => $filtroTiempo
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
