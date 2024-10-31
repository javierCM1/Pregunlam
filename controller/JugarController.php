<?php

class JugarController
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
            if (isset($_SESSION['terminoPartida']) && $_SESSION['terminoPartida'] === true) {
                header("Location: /jugar");//inicia otra partida. no redirigir al lobby porque se rompe el botón jugar
                unset($_SESSION['terminoPartida']);
                exit();
            }
            
            $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);//crear partida si no hay partida activa
            $pregunta = $this->preguntaModel->getUltimaPreguntaEntregadaDePartida($partida['id_partida']);
            
            if ($pregunta === null) {
                $nivel = $this->usuarioModel->determinarNivelUsuario($usuario);
                $pregunta = $this->preguntaModel->obtenerPreguntaAleatoria($usuario['id_usuario'], $nivel);
                $this->partidaModel->asociarPreguntaPartida($partida['id_partida'], $pregunta['id_pregunta'], 0);
                $this->preguntaModel->establecerPreguntaVista($usuario['id_usuario'], $pregunta['id_pregunta']);
                $this->preguntaModel->incrementarCantVistas($pregunta['id_pregunta']);
                $this->usuarioModel->incrementarCantPreguntasJugadas($usuario['id_usuario']);
            }

            $respuestas = $this->preguntaModel->getRespuestasPorIdPregunta($pregunta['id_pregunta']);
            shuffle($respuestas);

            $data['usuario'] = $usuario;
            $data['partida'] = $partida;
            $data['pregunta'] = $pregunta;
            $data['respuesta'] = $respuestas;
            $data['audio_src'] = '/public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg';

            // Renderizar la vista del juego
            $this->presenter->show('jugar', $data);
        }
        catch (PreguntaExpiradaException $e) {
            $this->partidaModel->terminarPartida($partida['id_partida'], $usuario['id_usuario']);
            $data['message'] = $e->getMessage();
            $this->presenter->show('resultadoPregunta', $data);
        }
        catch (PartidaActivaNoExisteException $e) {
            $this->partidaModel->savePartida(date('Y-m-d H:i:s'), 0, 'a', $usuario['id_usuario']);
            header('Location: /jugar');
            exit();
        }
    }

}