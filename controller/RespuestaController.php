<?php

class RespuestaController
{
    
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
            if (isset($_POST['continuar']) && $_POST['continuar'] && !$_SESSION['terminoPartida']) {

                $this->sumarPuntaje($_SESSION['user']);
                
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
            $this->usuarioModel->incrementarPreguntasCorrectasUsuario($usuario['id_usuario']);

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
        } catch (PartidaActivaNoExisteException $e) {
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

            $data['usuario'] = $usuario;
            $data['pregunta'] = $pregunta;
            $data['partida'] = $partida;
            $data['id_usuario'] = $usuario['id_usuario'];
            $data['id_pregunta'] = $pregunta['id_pregunta'];
            $data['audio_src'] = 'public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg';
            $data['respuestaEsCorrecta'] = true;
            $data['message'] = '¡Respuesta correcta!';
            
            
            
            // $_SESSION['estadoRespuesta'] = true;

            $this->preguntaModel->respondeCorrecto($partida['id_partida'], $pregunta['id_pregunta']);
            $this->preguntaModel->incrementarCantCorrectas($data['id_pregunta']);

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
            
            //$_SESSION['estadoRespuesta'] = false;
            
            
            
            
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
        
        // Verificar que los campos necesarios estén presentes
        if (empty($motivo_reporte) || empty($fecha_reporte) || empty($id_usuario) || empty($id_pregunta)) {
            http_response_code(400); // Código de error
            echo json_encode(['error' => 'Todos los campos son obligatorios.']);
            return;
        }
        
        try {
            $this->reporteModel->guardarReporte($motivo_reporte, $fecha_reporte, $id_usuario, $id_pregunta);
            $this->reporteModel->establecerPreguntaReportada($id_pregunta);
            
            // Respuesta en formato JSON
            echo json_encode(['success' => 'Reporte enviado correctamente.']);
            return;
            
        } catch (Exception $e) {
            http_response_code(500); // Código de error del servidor
            echo json_encode(['error' => 'Ocurrió un error al procesar el reporte.']);
            return;
        }
    }
    
    
    private function sumarPuntaje($user)
    {
        $usuario = $this->usuarioModel->getUserByUsernameOrEmail($user, 'a');
        $partida = $this->partidaModel->getPartidaActivaByUserId($usuario['id_usuario']);
        
        
            $this->partidaModel->incrementarPuntajePartida($partida['id_partida'], 'a');
      
        
        
    }
    
    /**
     * @param $id_pregunta
     * @param $id_usuario
     * @return void
     */
  
}