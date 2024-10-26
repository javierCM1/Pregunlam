<?php
class RespuestaController{
    private $presenter;
    private $usuarioModel;
    private $preguntaModel;

    public function __construct($usuarioModel,$preguntaModel,$presenter)
    {
        $this->presenter = $presenter;
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
            header("Location: /error"); // Ajusta según sea necesario
            exit();
        }
        $data['usuario'] = $this->usuarioModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['respuesta'] = $this->preguntaModel->getRespuestaById($_POST['id_respuesta']);
        $data['pregunta'] = $this->preguntaModel->obtenerPreguntaPorId($_POST['id_pregunta'], 2);


        $respuestaIdPregunta = (int)$data['respuesta']['id_pregunta'];
        $preguntaIdPregunta = (int)$data['pregunta']['id_pregunta'];
        $esCorrecta = (int)$data['respuesta']['esCorrecta_respuesta'];

        if ($respuestaIdPregunta === $preguntaIdPregunta && $esCorrecta !== 0) {
            $data['message'] = 'Respuesta Correcta';
        } else {
            $data['message'] = 'Respuesta Incorrecta';
    }
        // Redirigir a la página de resultados
        $this->presenter->show("resultadoPregunta", $data);  }
}