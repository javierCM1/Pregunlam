<?php
use PHPUnit\Framework\TestCase;
require_once ("../../model/PartidaModel.php");
require_once ("../../model/UserModel.php");
require_once ("../../helper/FileEmailSender.php");
require_once ("Usuario.php");
require_once ("Partida.php");

final class ExampleTest extends TestCase
{
    
    private $userModel; // Instancia del modelo
    private $db; // La conexión a la base de datos
    
    private $fileEmailSender;
    private $partidaModel;
    
    public function setUp(): void
    {
        // Aquí inicializas la conexión a la base de datos
        $this->db = new mysqli("localhost", "root", "", "pregunlam_db");
        
        // Asegúrate de que la conexión fue exitosa
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
        $this->fileEmailSender = new FileEmailSender();
        
        // Inicializas el modelo con la conexión
        $this->userModel = new UserModel($this->db,$this->fileEmailSender);
        $this->partidaModel = new PartidaModel($this->db,$this->fileEmailSender);
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
    
}

