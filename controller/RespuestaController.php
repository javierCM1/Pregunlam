<?php
class RespuestaController{
    private $preguntaModel;
    
    private $presenter;
    
    public function __construct($model, $presenter)
    {
        $this->preguntaModel = $model;
        
        
        $this->presenter = $presenter;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }
        if (isset($_SESSION['message'])) {
            $data['message'] = $_SESSION['message'];
            unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
        }

        if (!isset($_POST['id_respuesta']) || !isset($_POST['id_pregunta'])) {
            // Manejar el error, tal vez redirigir a una página de error o mostrar un mensaje
            header("Location: /error"); // Ajusta según sea necesario
            exit();
        }

        $data['respuesta'] = $this->preguntaModel->getRespuestaById($_POST['id_respuesta']);
        $data['pregunta'] = $this->preguntaModel->obtenerPreguntaPorId($_POST['id_pregunta'], 2);

        if ($data['respuesta']['id_pregunta'] == $data['pregunta']['id_pregunta'] && $data['respuesta']['esCorrecta_respuesta'] != 0) {
            $_SESSION['message'] = 'Respuesta Correcta';
        } else {
            $_SESSION['message'] = 'Respuesta Incorrecta';
        }

        // Redirigir a la página de resultados
        $this->presenter->show("resultadoPregunta", $data);

    }
}