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
        
        $data['respuesta'] = $this->preguntaModel->getRespuestaById($_GET['id_respuesta']);
        $data['pregunta'] = $this->preguntaModel->obtenerPreguntaPorId($_GET['id_pregunta'],2);
        
        
        if($data['respuesta']['id_pregunta'] == $data['pregunta']['id_pregunta'] && $data['respuesta']['esCorrecta_respuesta'] != 0 ){
            $data['message'] = 'Respuesta Correcta';
        }
        else{
            $data['message'] = 'Respuesta Incorrecta';
        }
        
        
        
        // En el entorno de pruebas, solo imprimimos el mensaje en lugar de llamar a $presenter
        if (defined('TEST_ENV') && TEST_ENV === true) {
            echo $data['message'];
        } else {
            $this->presenter->show("resultadoPregunta", $data['message']);
        }
        
        
        
        
    }
    
}