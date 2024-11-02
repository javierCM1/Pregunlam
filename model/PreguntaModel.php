<?php

class PreguntaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /*public function saveEstado($estado)
    {
        
        $query = $this->db->prepare("INSERT INTO estado (
                    id_estado,
                descripcion_estado
                ) VALUES (?, ?)");
        
        $descripcion_estado = $estado->getDescripcion();
        $id_estado = $estado->getId();
        
        $query->bind_Param("is", $id_estado, $descripcion_estado);
        return $query->execute();
        
        
    }*/

    /*public function saveCategoria($categoria)
    {
        $query = $this->db->prepare("INSERT INTO categoria (
                    id_categoria,
                descripcion_categoria,
                       img_categoria,
                       color_categoria
                ) VALUES (?,?,?,?)");
        
        $id_categoria = $categoria->getIdCategoria();
        $descripcion_categoria = $categoria->getDescripcion();
        $img_categoria = $categoria->getImg();
        $color_categoria = $categoria->getColor();
        
        $query->bind_Param("isss", $id_categoria, $descripcion_categoria,$img_categoria,$color_categoria);
        return $query->execute();
        
        
        
    }*/

    public function obtenerUltimoIdPreguntas()
    {
        $query = $this->db->prepare("SELECT MAX(id_pregunta) FROM `pregunta`");
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['MAX(id_pregunta)'];
    }

    public function obtenerCantidadPreguntasPorEstado($estado)
    {
        $query = $this->db->prepare("SELECT COUNT(id_pregunta) FROM `pregunta` WHERE id_estado = ?");
        $query->bind_Param('i', $estado);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['COUNT(id_pregunta)'];
    }

    public function obtenerPreguntasPorEstado($estado)
    {
        $query = $this->db->prepare("SELECT P.id_pregunta,
                                        P.interrogante_pregunta,
                                        P.fechaCreacion_pregunta,
                                        C.descripcion_categoria,
                                        U.userName_usuario,
                                        R.descripcion_respuesta
                                 FROM Pregunta P
                                 JOIN Categoria C ON P.id_categoria=C.id_categoria
                                 LEFT JOIN Usuario U ON P.id_usuarioCreador=U.id_usuario
                                 JOIN respuesta R ON P.id_pregunta=R.id_pregunta 
                                                            AND R.esCorrecta_respuesta=1
                                 WHERE P.id_estado = ?");
        $query->bind_Param('i', $estado);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function cambiarEstadoPregunta($idPregunta,$estado)
    {
        $queryPregunta = $this->db->prepare("UPDATE pregunta 
                                         SET id_estado = ?
                                         WHERE id_pregunta = ?");

        $queryPregunta->bind_param("ii", $estado,$idPregunta);
        $queryPregunta->execute();
    }

    public function obtenerPreguntasActivasNoVistasPorIdUsuario($idUsuario)
    {
        $estado = 2;

        $query = $this->db->prepare("SELECT p.id_pregunta, p.cantVistas_pregunta, p.cantCorrectas_pregunta
                                    FROM pregunta p
                                    LEFT JOIN pregunta_vista pv ON p.id_pregunta = pv.id_pregunta AND pv.id_usuario = ?
                                    WHERE pv.id_pregunta IS NULL AND p.id_estado = ?;");

        $query->bind_param('ii', $idUsuario, $estado);
        $query->execute();
        $resultado = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (sizeof($resultado) === 0)
            $this->eliminarPreguntasVistasDeUsuario($idUsuario);

        return $resultado;
    }

    public function obtenerPreguntaAleatoria($idUsuario, $nivel)
    {
        do {
            $arrayNoVistas = $this->obtenerPreguntasActivasNoVistasPorIdUsuario($idUsuario);
        } while (sizeof($arrayNoVistas) === 0);

        $arrayDeNivel = $this->seleccionarPreguntasDeNivel($arrayNoVistas, $nivel);
        $arrayPreguntas = sizeof($arrayDeNivel) !== 0 ? $arrayDeNivel : $arrayNoVistas;

        return $this->obtenerPreguntaPorId($arrayPreguntas[array_rand($arrayPreguntas)]['id_pregunta'], 2);
    }

    private function seleccionarPreguntasDeNivel($preguntas, $nivel)
    {
        foreach ($preguntas as $index => $pregunta) {
            if ($this->determinarDificultadPregunta($pregunta) !== $nivel)
                unset($preguntas[$index]);
        }
        return array_values($preguntas);
    }

    private function determinarDificultadPregunta($pregunta)
    {
        if ($pregunta['cantVistas_pregunta'] > 10) {
            $dificultad = ($pregunta['cantCorrectas_pregunta'] / $pregunta['cantVistas_pregunta']) * 100;

            if ($dificultad <= 30) {
                return 'dificil';
            } else if ($dificultad >= 70) {
                return 'facil';
            }
        }

        return 'medio';
    }

    /**
     * @throws PreguntaExpiradaException
     */
    public function getUltimaPreguntaEntregadaDePartida($idPartida)
    {
        $estado = 'a';
        $respondio = 0;
        $respondeCorrecto = 0;
        $query = $this->db->prepare("SELECT PP.id_pregunta, PP.fechaHoraEntrega_pregunta_partida FROM pregunta_partida PP
                                    JOIN partida PA ON PA.id_partida=PP.id_partida
                                    WHERE PA.estado_partida = ?
                                    AND PP.id_partida = ?
                                    AND PP.respondio_pregunta_partida = ?
                                    AND PP.respondeCorrecto_pregunta_partida = ?");
        $query->bind_param('siii', $estado, $idPartida, $respondio, $respondeCorrecto);
        $query->execute();
        $result = $query->get_result()->fetch_array(MYSQLI_ASSOC);

        if ($result != null) {
            if (time() - strtotime($result['fechaHoraEntrega_pregunta_partida']) > 30) {
                throw new PreguntaExpiradaException();
            }
            return $this->obtenerPreguntaPorId($result['id_pregunta'], 2);
        }
        return null;
    }

    public function obtenerPreguntaPorId($id, $estado)
    {
        $query = $this->db->prepare("SELECT P.id_pregunta,
                                        P.interrogante_pregunta,
                                        P.fechaCreacion_pregunta,
                                        P.cantVistas_pregunta,
                                        P.cantCorrectas_pregunta,
                                        P.id_categoria, 
                                        C.descripcion_categoria,
                                        C.img_categoria,
                                        C.color_categoria,
                                        E.descripcion_estado,
                                        U.userName_usuario 
                                 FROM Pregunta P
                                 JOIN Categoria C ON P.id_categoria=C.id_categoria
                                 JOIN Estado E ON P.id_estado=E.id_estado
                                 LEFT JOIN Usuario U ON P.id_usuarioCreador=U.id_usuario
                                 WHERE P.id_pregunta = ? AND P.id_estado = ?");

        $query->bind_param('ii', $id, $estado);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function getRespuestasPorIdPregunta($idPregunta)
    {
        $query = $this->db->prepare("SELECT * FROM respuesta WHERE id_pregunta = ?");
        $query->bind_param('i', $idPregunta);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @throws RespuestaIncorrectaException
     */
    public function respuestaEsCorrecta($respuesta)
    {
        if ($respuesta['esCorrecta_respuesta'] === 1)
            return true;

        throw new RespuestaIncorrectaException();
    }

    public function obtenerCategoriaPorId($id)
    {

        $query = $this->db->prepare("SELECT * FROM Categoria WHERE id_categoria = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);

    }

    public function obtenerEstadoPorId($id)
    {
        $query = $this->db->prepare("SELECT * FROM Estado WHERE id_estado = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function incrementarCantVistas($id_pregunta)
    {
        $incrementoVistas = 1;
        $estadoPregunta = 2;
        $query = $this->db->prepare("UPDATE `pregunta` SET `cantVistas_pregunta`= `cantVistas_pregunta` + ?
                                    WHERE id_pregunta = ? AND id_estado = ?");
        $query->bind_param('iii', $incrementoVistas, $id_pregunta, $estadoPregunta);
        return $query->execute();
    }

    public function incrementarCantCorrectas($id_pregunta)
    {
        $incrementoCorrectas = 1;
        $estadoPregunta = 2;
        $query = $this->db->prepare("UPDATE `pregunta` SET `cantCorrectas_pregunta`= `cantCorrectas_pregunta` + ?
                                    WHERE id_pregunta = ? AND id_estado = ?");
        $query->bind_param('iii', $incrementoCorrectas, $id_pregunta, $estadoPregunta);
        return $query->execute();
    }

    public function establecerPreguntaVista($idUsuario, $id_pregunta)
    {
        $query = $this->db->prepare("INSERT INTO `pregunta_vista`(
                                        `id_usuario`,
                                        `id_pregunta`
                                    )
                                    VALUES(?, ?)");
        $query->bind_param('ii', $idUsuario, $id_pregunta);
        return $query->execute();
    }

    public function getPreguntaVistaById($id)
    {
        $query = $this->db->prepare("SELECT * FROM `pregunta_vista` WHERE id_pregunta_vista = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function getRespuestaById($id_respuesta)
    {
        $query = $this->db->prepare("SELECT * FROM `respuesta` WHERE id_respuesta = ?");
        $query->bind_param('i', $id_respuesta);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);

    }

    public function getRespuestaCorrectaDePregunta($idPregunta)
    {
        $correcta = 1;
        $query = $this->db->prepare("SELECT * FROM `respuesta` WHERE id_pregunta = ? AND esCorrecta_respuesta = ?");
        $query->bind_param('ii', $idPregunta, $correcta);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function respondePregunta($idPartida, $idPregunta)
    {
        $responde = 1;
        $timestamp = time() - 30;
        $query = $this->db->prepare("UPDATE pregunta_partida SET respondio_pregunta_partida = ?
                                    WHERE id_partida = ?
                                    AND id_pregunta = ?
                                    AND fechaHoraEntrega_pregunta_partida > ?");
        $query->bind_param('iiii', $responde, $idPartida, $idPregunta, $timestamp);
        return $this->db->executeStmt($query) == 1;
    }

    public function respondeCorrecto($idPartida, $idPregunta)
    {
        $respondeCorrecto = 1;
        $query = $this->db->prepare("UPDATE pregunta_partida SET respondeCorrecto_pregunta_partida = ? WHERE id_partida = ? AND id_pregunta = ?");
        $query->bind_param('iii', $respondeCorrecto, $idPartida, $idPregunta);
        return $this->db->executeStmt($query) == 1;
    }

    private function eliminarPreguntasVistasDeUsuario($idUsuario)
    {
        $query = $this->db->prepare("DELETE FROM `pregunta_vista` WHERE id_usuario = ?");
        $query->bind_param('i', $idUsuario);
        return $this->db->executeStmt($query) == 35;
    }

    public function guardarPregunta($pregunta, $respuestaCorrecta, $respuestaIncorrecta1, $respuestaIncorrecta2, $respuestaIncorrecta3, $idCategoria, $usuarioCreador, $idEstado)
    {
        $queryPregunta = $this->db->prepare("INSERT INTO pregunta (
                                                interrogante_pregunta, 
                                                fechaCreacion_pregunta, 
                                                id_usuarioCreador, 
                                                id_categoria, 
                                                id_estado) 
                                            VALUES (?, NOW(), ?, ?, ?)");

        $queryPregunta->bind_param("siii", $pregunta, $usuarioCreador, $idCategoria, $idEstado);
        $queryPregunta->execute();

        $idPregunta = $queryPregunta->insert_id;

        $this->insertarRespuesta($respuestaCorrecta, 1, $idPregunta);
        $this->insertarRespuesta($respuestaIncorrecta1, 0, $idPregunta);
        $this->insertarRespuesta($respuestaIncorrecta2, 0, $idPregunta);
        $this->insertarRespuesta($respuestaIncorrecta3, 0, $idPregunta);
    }

    private function insertarRespuesta($respuesta, $esCorrecta, $idPregunta)
    {
        $query = $this->db->prepare("INSERT INTO respuesta (
                                        descripcion_respuesta, 
                                        esCorrecta_respuesta, 
                                        id_pregunta) 
                                    VALUES (?, ?, ?)");

        $query->bind_param("sii", $respuesta, $esCorrecta, $idPregunta);
        $query->execute();
    }

    public function modificarPregunta($idPregunta, $pregunta, $idCategoria)
    {
        $queryPregunta = $this->db->prepare("UPDATE pregunta 
                                         SET interrogante_pregunta = ?, 
                                             id_categoria = ?
                                         WHERE id_pregunta = ?");

        $queryPregunta->bind_param("sii", $pregunta, $idCategoria, $idPregunta);
        $queryPregunta->execute();
    }

    public function modificarRespuesta($idRespuesta, $respuesta)
    {
        $queryPregunta = $this->db->prepare("UPDATE respuesta 
                                         SET descripcion_respuesta = ?
                                         WHERE id_respuesta = ?");

        $queryPregunta->bind_param("si", $respuesta,$idRespuesta);
        $queryPregunta->execute();
    }

}