<?php
use PHPUnit\Framework\TestCase;
require_once ("../../model/PartidaModel.php");
require_once ("../../model/PreguntaModel.php");
require_once ("../../model/UserModel.php");
require_once ("../../helper/FileEmailSender.php");


require_once ("../../controller/RespuestaController.php");


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
    private $presenter;
    
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
        
        $this->controller = new RespuestaController($this->preguntaModel, $this->presenter);
        
        
        // Configurar una sesión simulada
        $_SESSION['user'] = 'testUser';
    }
    

    
    public function testShouldCheckAssertTrue(){
        $this->assertTrue(true);
    }

    public function testShouldCheckAssertEquals(){
        $this->assertEquals("a", "a");
    }
    
    
    public function testGivenExisteUnaPartida(){
        //id_partida	fechaHora_partida	puntaje_partida	estado_partida	id_usuario
        
        $estado = "A";
        $usuario = $this->userModel->getUserById(11);
        
        
        $partida = new Partida();
        $partida->setEstado($estado);
        $partida->setIdUsuario(11);
        
        $this->partidaModel->savePartida($partida);
        
        $usuarioDb = $this->userModel->getUserById(11);
        
        
        $partidaDb = $this->partidaModel->getPartidaById(28);
        
      
        $this->assertEquals($partidaDb["estado_partida"], "A");
        $this-> assertEquals($partidaDb["id_usuario"], $usuarioDb["id_usuario"]);
        $this->assertEquals($partidaDb["puntaje_partida"],$partida->getPuntaje());
        $this->assertEquals($partidaDb["id_partida"],28);
        
    }
    
    public function testQueSePuedaCrearUnaPregunta(){
     
  
        $interrogante = "¿En que año murio Ricardo Fort?";
        $pregunta = new Pregunta();
        $pregunta->setInterrogantePregunta($interrogante);
        
        
        
        $categoria = new Categoria();
        $estado = new Estado();
        
        
        $idPruebaEstado = 25;
        $idPruebaCategoria = 25;
        
        $estado->setIdEstado($idPruebaEstado);
        $estado->setDescripcion("pendiente");
        
        
        $categoria->setIdCategoria($idPruebaCategoria);
        $categoria->setDescripcion("ENTRETENIMIENTO");
        $categoria->setImg("rutaInexistente");
        $categoria->setColor("Rojo");
        
        
        
        $pregunta->setIdCategoria($idPruebaCategoria);
        $pregunta->setIdEstado($idPruebaEstado);
        $pregunta->setIdUsuarioCreador(17);
        
        
        
        
        $usuarioDb = $this->userModel->getUserById(11);
        
        $this->preguntaModel->saveEstado($estado);
        $this->preguntaModel->saveCategoria($categoria);
        $this->preguntaModel->savePregunta($pregunta);
        
        
        
        $preguntaDb = $this->preguntaModel->obtenerPreguntaPorId(4);
        $categoriaDb = $this->preguntaModel->obtenerCategoriaPorId($idPruebaCategoria);
        $estadoDb = $this->preguntaModel->obtenerEstadoPorId($idPruebaEstado);
        
        $this->assertEquals($preguntaDb["interrogante_pregunta"], $interrogante);
      
        $this->assertEquals($preguntaDb["id_estado"], $estadoDb["id_estado"]);
        $this->assertEquals($preguntaDb["id_categoria"], $categoriaDb["id_categoria"]);
     
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
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
    
    
    
    public function testGivenQueSePuedaDeterminarSiLaRespuestaObtenidaEsCorrectaDevuelvaUnMensajeDeRespCorrecta()
    {
        define('TEST_ENV', true);
        
        // Definir IDs para la pregunta y la respuesta
        $idPregunta = 5;
        $estadoPregunta = 2; // estado activo
        $idRespuesta = 17;
        
        // Datos esperados de la respuesta
        $descripcionEsperada = "La toma de la Bastilla";
        $esCorrectaEsperada = 1;
        
        // Consultar la pregunta y respuesta de la base de datos
        $preguntaDb = $this->preguntaModel->obtenerPreguntaPorId($idPregunta, $estadoPregunta);
        $respuestaDb = $this->preguntaModel->getRespuestaById($idRespuesta);
        
        // Verificar que los datos de la respuesta sean correctos
        $this->assertEquals($descripcionEsperada, $respuestaDb['descripcion_respuesta']);
        $this->assertEquals($esCorrectaEsperada, $respuestaDb['esCorrecta_respuesta']);
        $this->assertEquals($preguntaDb['id_pregunta'], $respuestaDb['id_pregunta']);
        
        // Simular los datos de GET para que el controlador use estos valores
        $_GET['id_respuesta'] = $respuestaDb['id_respuesta'];
        $_GET['id_pregunta'] = $preguntaDb['id_pregunta'];
        
        // Esperar la salida "Respuesta Correcta" si la respuesta es correcta
        $this->expectOutputString('Respuesta Correcta');
        
        // Llamar al método que queremos probar
        $this->controller->index();
    }
    
    
    
}

