<?php

class JugarController
{

  public function __construct($model,$presenter)
  {
      $this->model = $model;
      $this->presenter = $presenter;
  }

    public function index()
    {

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        if (isset($_GET['categoria'])) {
            $categoria = $_GET['categoria'];
        } else {
            header("Location: /categoria");
            exit();
        }

        $pregunta = $this->model->obtenerPreguntaPorCategoria($categoria);

        if (!$pregunta) {
            echo "No se encontró ninguna pregunta para la categoría seleccionada.";
            exit();
        }

        $respuestas = $this->model->getRespuestasPorIdPregunta($pregunta['id_pregunta']);

        $data = [
            'categoria'      => $categoria,
            'pregunta'       => $pregunta['interrogante_pregunta'],
            'color_categoria' => $pregunta['color_categoria'],
            'respuestas'     => $respuestas,
        ];

        $this->presenter->show('jugar', $data);

    }


}