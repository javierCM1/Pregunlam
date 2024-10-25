<?php
use PHPUnit\Framework\TestCase;
require_once ("../../model/PartidaModel.php");
require_once ("../../model/PreguntaModel.php");
require_once ("../../model/UserModel.php");
require_once ("../../helper/FileEmailSender.php");
require_once ("Usuario.php");
require_once ("Partida.php");
require_once ("Pregunta.php");
require_once ("Categoria.php");
require_once ("Estado.php");


final class ExampleTest extends TestCase
{
    
    private $userModel; // Instancia del modelo
    private $db; // La conexión a la base de datos
    
    private $partidaModel;
    
    private $preguntaModel;
    
    public function setUp(): void
    {
        // Aquí inicializas la conexión a la base de datos
        $this->db = new mysqli("localhost", "root", "", "pregunlam_db");
        
        // Asegúrate de que la conexión fue exitosa
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
        
        // Inicializas el modelo con la conexión
        $this->userModel = new UserModel($this->db);
        $this->partidaModel = new PartidaModel($this->db);
        $this->preguntaModel = new PreguntaModel($this->db);
    }
    
    public function testShouldCheckAssertTrue(){
        $this->assertTrue(true);
    }

    public function testShouldCheckAssertEquals(){
        $this->assertEquals("a", "a");
    }

    public function testGivenExisteUnaPartida(){
        $estado = "a";
        $idUsuario = 1;
        $fechaHora = date('Y-m-d H:i:s');
        $puntaje = 0;
        $expectedIdPartida = $this->partidaModel->obtenerUltimoIdPartida() + 1;

        $this->partidaModel->savePartida($fechaHora,$puntaje,$estado,$idUsuario);
        
        $partidaDb = $this->partidaModel->getPartidaById($expectedIdPartida,$estado);

        $this->assertEquals($expectedIdPartida, $partidaDb['id_partida']);
        $this->assertEquals($fechaHora, $partidaDb['fechaHora_partida']);
        $this->assertEquals($puntaje, $partidaDb['puntaje_partida']);
        $this->assertEquals($estado, $partidaDb['estado_partida']);
        $this->assertEquals($idUsuario, $partidaDb['id_usuario']);
    }
    
    public function testQueSePuedaCrearUnaPregunta(){
        $interrogante = "¿En que año murio Ricardo Fort?";
        $idUsuario = 11;
        $idCategoria = 3;
        $idEstado = 1;
        $expectedId = $this->preguntaModel->obtenerUltimoIdPreguntas();

        $this->preguntaModel->savePregunta($interrogante,$idUsuario,$idCategoria,$idEstado);
        
        $preguntaDb = $this->preguntaModel->obtenerPreguntaPorId($expectedId,$idEstado);
        $this->assertEquals($interrogante, $preguntaDb["interrogante_pregunta"]);
    }
    
    public function testQueSePuedaMostrarUnaPreguntaYSusRespuestas()
    {
        $idPregunta = 5;
        $estadoPregunta = 2; //estado activo
        $pregunta = $this->preguntaModel->obtenerPreguntaPorId($idPregunta,$estadoPregunta);

        $this->assertEquals('¿Qué evento marcó el inicio de la Revolución Francesa?',$pregunta['interrogante_pregunta']);

        $respuestas = $this->preguntaModel->getRespuestasPorIdPregunta($idPregunta);

        $expectedRes = ['La toma de la Bastilla',
                        'La declaración de los Derechos del Hombre',
                        'La ejecución de Luis XVI',
                        'El inicio de la guerra contra Prusia'];

        for ($i=0; $i<4; $i++) {
            $this->assertEquals($expectedRes[$i],$respuestas[$i]['descripcion_respuesta']);
        }
    }

    private function setNewPartida()
    {
        $estado = "a";
        $idUsuario = 1;
        $fechaHora = date('Y-m-d H:i:s');
        $puntaje = 0;

        $this->partidaModel->savePartida($fechaHora,$puntaje,$estado,$idUsuario);
    }

    public function testQueSePuedaSeleccionarUnaRespuestaCorrecta()
    {
        $idUsuario = 1;
        $idPregunta = 5;
        $estadoPregunta = 2; //estado activo
        $respuestaSeleccionada = 0;
        $estado = "a";
        $expectedIdPartida = $this->partidaModel->obtenerUltimoIdPartida() + 1;
        $expectedValue = 1;
        $correcto = 1;
        $expectedPuntaje = 1;

        $this->setNewPartida();

        $pregunta = $this->preguntaModel->obtenerPreguntaPorId($idPregunta,$estadoPregunta);

        $this->preguntaModel->incrementarCantVistas($pregunta['id_pregunta'],$estadoPregunta);
        $this->userModel->incrementarCantPreguntasJugadas($idUsuario);
        $this->preguntaModel->establecerPreguntaVista($idUsuario,$pregunta['id_pregunta']);

        $partida = $this->partidaModel->getPartidaById($expectedIdPartida,$estado);
        $pregunta = $this->preguntaModel->obtenerPreguntaPorId($idPregunta,$estadoPregunta);
        $respuestas = $this->preguntaModel->getRespuestasPorIdPregunta($idPregunta);

        //$usuario = $this->userModel->getUserById($idUsuario);
        //$this->assertEquals(5,$pregunta['cantVistas_pregunta']);
        //$this->assertEquals(4,$usuario['cantPreguntasJugadas_usuario']);
        //$this->assertEquals(1,$this->preguntaModel->getPreguntaVistaById(1)['id_pregunta_vista']);

        $this->assertEquals($expectedValue,$respuestas[$respuestaSeleccionada]['esCorrecta_respuesta']);

        $this->partidaModel->asociarPreguntaPartida($partida['id_partida'],$pregunta['id_pregunta'],$correcto);
        $this->partidaModel->incrementarPuntajePartida($partida['id_partida'],$estado);

        $partida = $this->partidaModel->getPartidaById($expectedIdPartida,$estado);

        $this->assertEquals($expectedPuntaje,$partida['puntaje_partida']);

        //actualizar correcta usuario y pregunta

        //actualizar max puntaje de usuario
    }

    //test -> reporte de pregunta

    //test -> evitar repeticion

    //test -> evaluar nivel y dificultad
    
}

