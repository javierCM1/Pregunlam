<?php

class CrearPreguntaController
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
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['username'] = $_SESSION['user'];

        $usuarioEsJugador = $data['usuario']['id_tipo_usuario'] === 3;
        $headerJugador = $usuarioEsJugador;
        $headerEditor = !$headerJugador;
        $data['header'] = ['jugador' => $headerJugador, 'editor' => $headerEditor];
        $data['estadoPregunta'] = $usuarioEsJugador ? 'Sugerir ' : 'Crear ';

        $this->presenter->show('crearPregunta', $data);
    }

    public function guardarPreguntaCreada()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        if (!isset(
            $_POST['respuestaCorrecta'],
            $_POST['respuestaincorrecta1'],
            $_POST['respuestaincorrecta2'],
            $_POST['respuestaincorrecta3'],
            $_POST['pregunta'],
            $_POST['id_categoria']
        )) {
            throw new Exception('Faltan campos obligatorios');
        }

        $pregunta = $_POST['pregunta'];
        $respuestaCorrecta = $_POST['respuestaCorrecta'];
        $respuestaIncorrecta1 = $_POST['respuestaincorrecta1'];
        $respuestaIncorrecta2 = $_POST['respuestaincorrecta2'];
        $respuestaIncorrecta3 = $_POST['respuestaincorrecta3'];
        $categoria = $_POST['id_categoria'];

        $usuarioCreador = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
        $estadoPregunta = $usuarioCreador['id_tipo_usuario'] != 2 ? 1 : 2;

        $this->preguntaModel->guardarPregunta($pregunta, $respuestaCorrecta, $respuestaIncorrecta1, $respuestaIncorrecta2,
            $respuestaIncorrecta3, $categoria, $usuarioCreador['id_usuario'], $estadoPregunta);

        header("Location: /editor");
        exit();
    }
}