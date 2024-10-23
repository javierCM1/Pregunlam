<?php
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    
    private $userModel; // Instancia del modelo
    private $db; // La conexión a la base de datos
    
    
    protected function setUp()
    {
        // Aquí inicializas la conexión a la base de datos
        $this->db = new mysqli("localhost", "root", "", "pregunlam_db");
        
        // Asegúrate de que la conexión fue exitosa
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
        
        // Inicializas el modelo con la conexión
        $this->userModel = new UserModel($this->db);
    }
    

    
    public function testShouldCheckAssertTrue(){
        $this->assertTrue(true);
    }

    public function testShouldCheckAssertEquals(){
        $this->assertEquals("a", "a");
    }
    

    
    
    public function givenExisteUnaPartida(){
        //id_partida	fechaHora_partida	puntaje_partida	estado_partida	id_usuario
        
        $estado = "A";
        $usuario = new Usuario();
        $idUsuario = $usuario->getIdUsuario();
        $partida = new Partida();
        $partida->setEstado($estado);
        $partida->setIdUsuario($idUsuario);
        
        
        $this->userModel->savePartida($partida);
        
        $partidaDb = $this->userModel->getPartidaById($partida->getId());
        
        
        assertEquals($partidaDb->getEstado(), $partida->getEstado());
        assertEquals($partidaDb->getIdUsuario(), $partida->getIdUsuario());
        assertEquals($partidaDb->getPuntaje(),$partida->getPuntaje());
        assertEquals($partidaDb->getId(),$partida->getId());
        
        
        
    }
    
}

