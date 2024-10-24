<?php
class PartidaModel{
    private $db;
    
    
    public function __construct($database)
    {
        $this->db = $database;
    }
    
    
    public function savePartida($partida)
    {
        $query = $this->db->prepare("INSERT INTO partida (
                    fechaHora_partida,
                    puntaje_partida,
                    estado_partida,
                    id_usuario
                ) VALUES (?, ?, ?, ?)");
        
        $fechaHora = $partida->getFechaHora();
        $puntaje = $partida->getPuntaje();
        $estado = $partida->getEstado();
        $idUsuario = $partida->getIdUsuario();
        
        
        $query->bind_param('sssi', $fechaHora, $puntaje, $estado, $idUsuario);
        
        return $query->execute();
    }
    public function getPartidaById($id)
    {
        $query = $this->db->prepare("SELECT * FROM partida WHERE id_partida = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
    }
    
    
    
    
}
