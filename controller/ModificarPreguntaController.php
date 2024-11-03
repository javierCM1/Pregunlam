<?php

class ModificarPreguntaController
{

    private $preguntaModel;
    private $presenter;

    public function __construct($preguntaModel, $presenter)
    {
        $this->preguntaModel = $preguntaModel;
        $this->presenter = $presenter;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $pregunta = $this->preguntaModel->obtenerPreguntaPorId($_GET['id'],$_GET['estado']);
        $respuestaCorrecta = $this->preguntaModel->getRespuestaCorrectaDePregunta($pregunta['id_pregunta']);

        $respuestasIncorrectas = array_filter($this->preguntaModel->getRespuestasPorIdPregunta($pregunta['id_pregunta']),
            function($value) use ($respuestaCorrecta) {
            return $value !== $respuestaCorrecta;
        });
        $respuestasIncorrectas = array_values($respuestasIncorrectas);

        $incorrecta1 = $respuestasIncorrectas[0];
        $incorrecta2 = $respuestasIncorrectas[1];
        $incorrecta3 = $respuestasIncorrectas[2];

        $this->presenter->show("modificarPregunta", ['pregunta' => $pregunta,
                                                    'correcta' => $respuestaCorrecta,
                                                    'incorrecta1' => $incorrecta1,
                                                    'incorrecta2' => $incorrecta2,
                                                    'incorrecta3' => $incorrecta3]);
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