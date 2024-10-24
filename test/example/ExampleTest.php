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
        $expectedIdPartida = $this->partidaModel->obtenerCantidadDePartidas() + 1;

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
        $expectedId = $this->preguntaModel->obtenerCantidadDePreguntas();

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

        var_dump($expectedRes);

        for ($i=0; $i<4; $i++) {
            $this->assertEquals($expectedRes[$i],$respuestas[$i]['descripcion_respuesta']);
        }
    }
    
    
    
}

