<?php
class RespuestaController{

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
        if (!isset($_POST['id_respuesta']) || !isset($_POST['id_pregunta'])) {
            // Manejar el error, tal vez redirigir a una página de error o mostrar un mensaje
            header("Location: /jugar"); // Ajusta según sea necesario
            exit();
        }

        $usuario = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
        $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
        $pregunta = $this->preguntaModel->obtenerPreguntaPorId($_POST['id_pregunta'], 2);
        $respuestaSeleccionada = $this->preguntaModel->getRespuestaById($_POST['id_respuesta']);

        if($respuestaSeleccionada['id_pregunta'] === $pregunta['id_pregunta'])
            $this->preguntaModel->respondePregunta($partida['id_partida'],$pregunta['id_pregunta']);

        if ($this->preguntaModel->respuestaEsCorrecta($respuestaSeleccionada)) {
            $this->partidaModel->incrementarPuntajePartida($partida['id_partida'],'a');
            $this->preguntaModel->respondeCorrecto($partida['id_partida'],$pregunta['id_pregunta']);
            $data['message'] = 'Respuesta Correcta';
        } else {
            $this->partidaModel->terminarPartida($partida['id_partida'],$usuario['id_usuario']);
            $this->usuarioModel->determinarPuntajeMaximo($usuario,$partida);
            $data['message'] = 'Respuesta Incorrecta';
        }

        $data['usuario'] = $usuario;
        $data['partida'] = $partida;
        $data['respuesta'] = $respuestaSeleccionada;
        $data['pregunta'] = $pregunta;
        // Redirigir a la página de resultados
        $this->presenter->show("resultadoPregunta", $data);
    }
}