<?php

class ModificarPreguntaController
{

    private $preguntaModel;
    private $userModel;
    private $presenter;

    public function __construct($preguntaModel, $userModel, $presenter)
    {
        $this->preguntaModel = $preguntaModel;
        $this->userModel = $userModel;
        $this->presenter = $presenter;
    }

    public function index()
    {
        $this->presenter->show("modificarPregunta" , []);
    }

    public function buscarPreguntasporId()
    {
        if (isset($_POST['buscarPreguntaId'])) {
            $preguntaId = filter_var($_POST['buscarPreguntaId']);

            $pregunta = $this->preguntaModel->obtenerPreguntaPorId($preguntaId, 2);
            $respuestas = $this->preguntaModel->getRespuestasPorIdPregunta($preguntaId);

            $respuestaCorrecta = null;
            $respuestasIncorrectas = [];
            $idsRespuestasIncorrectas = [];

            foreach ($respuestas as $respuesta) {
                if ($respuesta['esCorrecta_respuesta'] == 1) {
                    $respuestaCorrecta = $respuesta['descripcion_respuesta'];
                } else {
                    $respuestasIncorrectas[] = $respuesta['descripcion_respuesta'];
                    $idsRespuestasIncorrectas[] = $respuesta['id_respuesta'];
                }
            }

            if ($pregunta) {
                $preguntaText = $pregunta['interrogante_pregunta'];
                $categoria = $pregunta['id_categoria'];

                $respuestaIncorrecta1 = $respuestasIncorrectas[0] ?? null;
                $respuestaIncorrecta2 = $respuestasIncorrectas[1] ?? null;
                $respuestaIncorrecta3 = $respuestasIncorrectas[2] ?? null;

                $idrespuestaIncorrecta1 = $idsRespuestasIncorrectas[0] ?? null;
                $idrespuestaIncorrecta2 = $idsRespuestasIncorrectas[1] ?? null;
                $idrespuestaIncorrecta3 = $idsRespuestasIncorrectas[2] ?? null;

                $this->presenter->show('modificarPregunta', [
                    'preguntaId' => $pregunta['id_pregunta'],
                    'preguntaText' => $preguntaText,
                    'id_categoria' => $categoria,
                    'respuestaCorrecta' => $respuestaCorrecta,
                    'respuestaIncorrecta1' => $respuestaIncorrecta1,
                    'respuestaIncorrecta2' => $respuestaIncorrecta2,
                    'respuestaIncorrecta3' => $respuestaIncorrecta3,
                    'idrespuestaIncorrecta1' => $idrespuestaIncorrecta1,
                    'idrespuestaIncorrecta2' => $idrespuestaIncorrecta2,
                    'idrespuestaIncorrecta3' => $idrespuestaIncorrecta3
                ]);
            } else {
                return $this->presenter->show('modificarPregunta', ['mensaje' => 'Pregunta no encontrada.']);
            }
        } else {
            return $this->presenter->show('modificarPregunta', ['mensaje' => 'ID de pregunta no proporcionado.']);
        }
    }


    public function guardarPreguntamodificada() {

        if (isset($_POST['id_preguntaMandado'], $_POST['pregunta'], $_POST['respuestaCorrecta'], $_POST['id_respuestaIncorrecta1'], $_POST['respuestaincorrecta1'], $_POST['id_respuestaIncorrecta2'], $_POST['respuestaincorrecta2'], $_POST['id_respuestaIncorrecta3'], $_POST['respuestaincorrecta3'], $_POST['id_categoriaMandado'])) {

            $idPregunta = $_POST['id_preguntaMandado'];
            $pregunta = $_POST['pregunta'];
            $respuestaCorrecta = $_POST['respuestaCorrecta'];
            $idRespuestaIncorrecta1 = $_POST['id_respuestaIncorrecta1'];
            $respuestaIncorrecta1 = $_POST['respuestaincorrecta1'];
            $idRespuestaIncorrecta2 = $_POST['id_respuestaIncorrecta2'];
            $respuestaIncorrecta2 = $_POST['respuestaincorrecta2'];
            $idRespuestaIncorrecta3 = $_POST['id_respuestaIncorrecta3'];
            $respuestaIncorrecta3 = $_POST['respuestaincorrecta3'];
            $idCategoria = $_POST['id_categoriaMandado'];

            $this->preguntaModel->modificarPregunta($idPregunta, $pregunta, $idCategoria);

            $this->preguntaModel->modificarRespuesta($idRespuestaIncorrecta1, $respuestaIncorrecta1);
            $this->preguntaModel->modificarRespuesta($idRespuestaIncorrecta2, $respuestaIncorrecta2);
            $this->preguntaModel->modificarRespuesta($idRespuestaIncorrecta3, $respuestaIncorrecta3);
            $this->preguntaModel->modificarRespuesta($idPregunta,$respuestaCorrecta);

            $this->presenter->show('/modificarPregunta', ['mensaje' => 'Pregunta modificada correctamente.']);
        } else {
            $this->presenter->show('modificarPregunta', ['mensaje' => 'Faltan datos en el formulario.']);
        }


    }






}