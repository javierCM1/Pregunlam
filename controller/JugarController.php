<?php

class JugarController
{
    private $presenter;
    private $partidaModel;
    private $usuarioModel;
    private $preguntaModel;

    public function __construct($partidaModel,$usuarioModel,$preguntaModel,$presenter)
    {
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->usuarioModel = $usuarioModel;
        $this->preguntaModel = $preguntaModel;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
        //crear partida si no hay partida activa
        if($partida === null) {
            $this->partidaModel->savePartida(date('Y-m-d H:i:s'),0,'a',$usuario['id_usuario']);
            $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
        }
        $pregunta = $this->preguntaModel->obtenerPreguntaAleatoria($usuario['id_usuario']);
        if($pregunta === null) {
            $pregunta = $this->preguntaModel->obtenerPreguntaAleatoria($usuario['id_usuario']);
        }
        $respuestas = $this->preguntaModel->getRespuestasPorIdPregunta($pregunta['id_pregunta']);

        //relacionar pregunta con partida. correcto por defecto en 0, se actualiza a 1 si responde correcto en tiempo:
        $this->partidaModel->asociarPreguntaPartida($partida['id_partida'],$pregunta['id_pregunta'],0);

        /* falta:
         * relacionar a pregunta vista (pregunta - usuario)
         * incrementar vistas pregunta
         * incrementar vistas usuario
         * no permitir que usuario reciba nueva pregunta recargando la pantalla
        */

        $data['usuario'] = $usuario;
        $data['partida'] = $partida;
        $data['pregunta'] = $pregunta;
        $data['respuesta'] = $respuestas;


        $this->presenter->show('jugar', $data);
    }

}