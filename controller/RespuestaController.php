<?php
class RespuestaController{

    private $presenter;
    private $partidaModel;
    private $usuarioModel;
    private $preguntaModel;
    private $reporteModel;

    public function __construct($partidaModel, $usuarioModel, $preguntaModel, $reporteModel, $presenter)
    {
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->usuarioModel = $usuarioModel;
        $this->preguntaModel = $preguntaModel;
        $this->reporteModel = $reporteModel;
    }

    public function index()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }
            if (isset($_POST['continuar']) && $_POST['continuar'] && !$_SESSION['terminoPartida']) {
                header("Location: /jugar");
                exit();
            }
            if (isset($_POST['continuar']) && $_POST['continuar'] === false) {
                header("Location: /lobby");
                exit();
            }

            $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
            $pregunta = $this->preguntaModel->getUltimaPreguntaEntregadaDePartida($partida['id_partida']);
            $respuestaSeleccionada = $this->preguntaModel->getRespuestaById($_POST['id_respuesta']);

            if ($respuestaSeleccionada['id_pregunta'] === $pregunta['id_pregunta'])
                $this->preguntaModel->respondePregunta($partida['id_partida'], $pregunta['id_pregunta']);

            $this->preguntaModel->respuestaEsCorrecta($respuestaSeleccionada); //tira exception

            $_SESSION['usuario'] = $usuario;
            $_SESSION['pregunta'] = $pregunta;
            $_SESSION['partida'] = $partida;

            header('Location: /respuesta/correcta');
            exit();
        }
        catch (PreguntaExpiradaException|RespuestaIncorrectaException $e) {
            $_SESSION['id_pregunta'] = $_POST['id_pregunta'];
            $_SESSION['message'] = $e->getMessage();
            header('Location: /respuesta/incorrecta');
            exit();
        }
        catch (PartidaActivaNoExisteException $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: /lobby');
            exit();
        }
    }

    public function correcta()
    {
        try {
            $usuario = $_SESSION['usuario'];
            $partida = $_SESSION['partida'];
            $pregunta = $_SESSION['pregunta'];

            $this->partidaModel->incrementarPuntajePartida($partida['id_partida'], 'a');
            $this->preguntaModel->respondeCorrecto($partida['id_partida'], $pregunta['id_pregunta']);
            $this->usuarioModel->incrementarPreguntasCorrectasUsuario($usuario['id_usuario']);
            $this->preguntaModel->incrementarCantCorrectas($pregunta['id_pregunta']);

            $data['usuario'] = $usuario;
            $data['pregunta'] = $pregunta;
            $data['partida'] = $partida;
            $data['id_usuario'] = $usuario['id_usuario'];
            $data['id_pregunta'] = $pregunta['id_pregunta'];
            $data['audio_src'] = 'public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg';
            $data['respuestaEsCorrecta'] = true;
            $this->presenter->show('resultadoPregunta', $data);

        } catch (PartidaActivaNoExisteException $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: /lobby');
            exit();
        }
    }

    public function incorrecta()
    {
        try {
            $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
            $pregunta = $this->preguntaModel->obtenerPreguntaPorId($_SESSION['id_pregunta'], 2);
            $respuestaCorrecta = $this->preguntaModel->getRespuestaCorrectaDePregunta($pregunta['id_pregunta']);
            $_SESSION['terminoPartida'] = true;

            $data['puntaje_final'] = $partida['puntaje_partida'];
            $data['message'] = $_SESSION['message'];
            $data['usuario'] = $usuario;
            $data['respuesta'] = $respuestaCorrecta['descripcion_respuesta'];
            $data['pregunta'] = $pregunta;
            $data['id_usuario'] = $usuario['id_usuario'];
            $data['id_pregunta'] = $pregunta['id_pregunta'];
            $data['partida'] = $partida;
            $data['respuestaEsCorrecta'] = false;

            $this->partidaModel->terminarPartida($partida['id_partida'], $usuario['id_usuario']);
            $this->usuarioModel->determinarPuntajeMaximo($usuario, $partida);

            $this->presenter->show("resultadoPregunta", $data);

        } catch (PartidaActivaNoExisteException $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: /lobby');
            exit();
        }
    }

    public function reportar()
    {
        $motivo_reporte = $_POST['motivo_reporte'];
        $fecha_reporte = $_POST['fecha_reporte'];
        $id_usuario = $_POST['id_usuarioMandado'];
        $id_pregunta = $_POST['id_pregunta'];

        if (!isset($motivo_reporte)) {
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        $this->reporteModel->guardarReporte($motivo_reporte, $fecha_reporte, $id_usuario, $id_pregunta);
        $this->reporteModel->establecerPreguntaReportada($id_pregunta);
        if($_POST['continuar']){
            header('Location: /respuesta');
            exit();
        }
        header('Location: /lobby');
        exit();
    }
}