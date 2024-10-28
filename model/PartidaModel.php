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

    public function obtenerUltimoIdPartida()
    {
        $query = $this->db->prepare("SELECT MAX(id_partida) FROM `partida`");
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['MAX(id_partida)'];
    }

    public function asociarPreguntaPartida($idPartida,$idPregunta,$correcto)
    {
        $timestamp = time();
        $query = $this->db->prepare("INSERT INTO `pregunta_partida`(
                                        `respondeCorrecto_pregunta_partida`,
                                        `id_partida`,
                                        `id_pregunta`
                                    )
                                    VALUES(?, ?, ?)");

        $query->bind_param('iii', $correcto, $idPartida, $idPregunta);
        return $query->execute();
    }

    public function incrementarPuntajePartida($id_partida,$estado)
    {
        $incrementoPuntaje = 1;
        $query = $this->db->prepare("UPDATE `partida` SET `puntaje_partida`= `puntaje_partida` + ?
                                    WHERE id_partida = ? AND estado_partida = ?");
        $query->bind_param('iis',$incrementoPuntaje,$id_partida,$estado);
        return $query->execute();
    }

    /**
     * @throws PartidaActivaNoExisteException
     */
    public function getPartidaActivaByUserId($userId)
    {
        $estado = 'a';
        $query = $this->db->prepare("SELECT * FROM partida WHERE id_usuario = ? AND estado_partida = ?");
        $query->bind_param('is', $userId,$estado);
        $query->execute();
        $result = $query->get_result()->fetch_array(MYSQLI_ASSOC);

        if($result === null) {
            throw new PartidaActivaNoExisteException();
        }
        return $result;
    }

    public function terminarPartida($idPartida,$idUsuario)
    {
        $nuevoEstado = 'i';
        $query = $this->db->prepare("UPDATE partida SET estado_partida = ? WHERE id_partida = ? AND id_usuario = ?");
        $query->bind_param('sii', $nuevoEstado, $idPartida, $idUsuario);
        return $this->db->executeStmt($query) == 1;
    }
    
    public function getPartidasByUserId($idUsuario)
    {
        $query = $this->db->prepare("SELECT * FROM partida WHERE id_usuario = ?");
        $query->bind_param('i', $idUsuario);
        $query->execute();
        return array_reverse($query->get_result()->fetch_all(MYSQLI_ASSOC));
    }
    
    


}
