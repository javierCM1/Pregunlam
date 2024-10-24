<?php
class PartidaModel{
    private $db;
    
    
    public function __construct($database)
    {
        $this->db = $database;
    }
    
    
    public function savePartida($fechaHora,$puntaje,$estado,$idUsuario)
    {
        $query = $this->db->prepare("INSERT INTO partida (
                    fechaHora_partida,
                    puntaje_partida,
                    estado_partida,
                    id_usuario
                ) VALUES (?, ?, ?, ?)");

        $query->bind_param('sssi', $fechaHora, $puntaje, $estado, $idUsuario);
        return $query->execute();
    }

    public function getPartidaById($id,$estado)
    {
        $query = $this->db->prepare("SELECT * FROM partida WHERE id_partida = ? AND estado_partida = ?");
        $query->bind_param('is', $id,$estado);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
    }

    public function obtenerCantidadDePartidas()
    {
        $query = $this->db->prepare("SELECT COUNT(id_partida) FROM `partida`");
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['COUNT(id_partida)'];
    }
    
    
}
