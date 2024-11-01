<?php
class RespuestaController
{
    private $presenter;
    private $partidaModel;
    private $usuarioModel;
    private $preguntaModel;

    public function __construct($partidaModel, $usuarioModel, $preguntaModel, $presenter)
    {
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->usuarioModel = $usuarioModel;
        $this->preguntaModel = $preguntaModel;
    }

    public function index()
    {
        try {
            if (!isset($_SESSION['user'])) {
                header("Location: /login");
                exit();
            }

            $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
            $pregunta = $this->preguntaModel->getUltimaPreguntaEntregadaDePartida($partida['id_partida']);
            $respuestaSeleccionada = $this->preguntaModel->getRespuestaById($_POST['id_respuesta']);

            // Verificar si la respuesta es correcta
            if ($respuestaSeleccionada['id_pregunta'] === $pregunta['id_pregunta']) {
                $this->preguntaModel->respondePregunta($partida['id_partida'], $pregunta['id_pregunta']);

                // Procesar la respuesta correcta
                $this->preguntaModel->respuestaEsCorrecta($respuestaSeleccionada);
                $this->partidaModel->incrementarPuntajePartida($partida['id_partida'], 'a');
                $this->preguntaModel->respondeCorrecto($partida['id_partida'], $pregunta['id_pregunta']);
                $this->usuarioModel->incrementarPreguntasCorrectasUsuario($usuario['id_usuario']);
                $this->preguntaModel->incrementarCantCorrectas($pregunta['id_pregunta']);

                // Guardar datos en sesión para usar en la vista
                $_SESSION['data'] = [
                    'message' => 'Respuesta Correcta',
                    'usuario' => $usuario,
                    'partida' => $partida,
                    'pregunta' => $pregunta,
                    'id_usuario' => $usuario['id_usuario'],
                    'id_pregunta' => $pregunta['id_pregunta'],
                    'audio_src' => 'public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg'
                ];

                // Redirigir a la vista de respuesta correcta
                header("Location: /respuesta/respuestaCorrecta");
                exit();
            } else {
                throw new RespuestaIncorrectaException("Respuesta incorrecta");
            }
        } catch (PreguntaExpiradaException $e) {
            $this->manejarExcepcion($e);
        } catch (RespuestaIncorrectaException $e) {
            $_SESSION['id_pregunta'] = $_POST['id_pregunta'];
            $_SESSION['message'] = $e->getMessage();
            header('Location: /respuesta/respondeIncorrecto');
            exit();
        } catch (PartidaActivaNoExisteException $e) {
            $_SESSION['message'] = $e->getMessage();
            header('Location: /lobby');
            exit();
        }
    }

    public function respuestaCorrecta()
    {
        // Verifica si hay datos en sesión y los muestra
        if (isset($_SESSION['data'])) {
            $data = $_SESSION['data'];
            $this->presenter->show('resultadoPregunta', $data);
            // NOTA: NO descomentar la línea de unset aquí.
        } else {
            // Manejar el caso en que no hay datos
            $_SESSION['message'] = "No hay datos disponibles.";
            header('Location: /lobby'); // Cambiar si es necesario
            exit();
        }
    }

    public function respondeIncorrecto()
    {
        try {
            $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
            $pregunta = $this->preguntaModel->obtenerPreguntaPorId($_SESSION['id_pregunta'], 2);
            $respuestaCorrecta = $this->preguntaModel->getRespuestaCorrectaDePregunta($pregunta['id_pregunta']);
            $_SESSION['terminoPartida'] = true;

            $data = [
                'puntaje_final' => $partida['puntaje_partida'],
                'message' => $_SESSION['message'],
                'usuario' => $usuario,
                'respuesta' => $respuestaCorrecta['descripcion_respuesta'],
                'pregunta' => $pregunta,
                'id_usuario' => $usuario['id_usuario'],
                'id_pregunta' => $pregunta['id_pregunta']
            ];

            if ($_SESSION['message'] == 'Respuesta Incorrecta' && isset($_POST['continuar'])) {
                $this->partidaModel->terminarPartida($partida['id_partida'], $usuario['id_usuario']);
                $this->usuarioModel->determinarPuntajeMaximo($usuario, $partida);
                header("Location: /lobby");
                exit();
            }

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

        $this->usuarioModel->guardarReporte($motivo_reporte, $fecha_reporte, $id_usuario, $id_pregunta);
        header("Location: /lobby");
    }

    private function manejarExcepcion($e)
    {
        $_SESSION['message'] = $e->getMessage();
        header('Location: /respuesta/respondeIncorrecto');
        exit();
    }
    

}
