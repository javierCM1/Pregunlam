<?php

class AdministradorController
{
    private $model;

    private $userModel;
    private $presenter;

    private $ChartGenerator;
    private $pdfGenerator;


    public function __construct($model, $userModel, $presenter, $ChartGenerator, $pdfGenerator)
    {
        $this->model = $model;
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->ChartGenerator = $ChartGenerator;
        $this->pdfGenerator = $pdfGenerator;
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
        $filtroTiempo = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtroTiempo']) ? $_POST['filtroTiempo'] : 'semana'; // Valor por defecto

        $fechaFin = date('Y-m-d');

        $datetime = match ($filtroTiempo) {
            'mes' => '-1 month',
            'anio' => '-1 year',
            default => 'last monday -1 week',
        };

        $fechaInicio = date('Y-m-d',strtotime($datetime));

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
            'preguntasChartPath' => $preguntasChartPath,
            'usuariosChartPath' => $usuariosChartPath,
            'usuariosNuevosChartPath' => $usuariosNuevosChartPath,
            'username' => $_SESSION['user'],
            'tipoUsuario' => 'administrador',
            'filtroTiempo' => $filtroTiempo,
            'cantidadesCategoria' => $preguntasData,
            'porcentajesSexo' => $usuariosData,
            'rangos' => $usuariosNuevos
        ]);
    }

    public function generarPDF()
    {
        if (isset($_POST['valueGrafPreguntas']) && isset($_POST['valueGrafSexoUsers']) && isset($_POST['valueGrafNuevosUsers'])) {

            $html = $this->generarImgHtml('Cantidad de preguntas por categoría',$_POST['valueGrafPreguntas']);
            $html.= $this->generarImgHtml('Porcentaje de usuarios por sexo',$_POST['valueGrafSexoUsers']);
            $html.= $this->generarImgHtml('Cantidad de usuarios nuevos',$_POST['valueGrafNuevosUsers']);

            $this->pdfGenerator->render($html);
        }
    }

    private function generarImgHtml($titulo,$path)
    {
        return "<h4>$titulo</h4>
                <img src='".$this->getImage($path)."' alt='".$path."'
                        style='max-width: 100%;
                                height: auto;
                                border: 1px solid #ccc;
                                border-radius: 8px;
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);'
                >";
    }

    private function getImage($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
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
