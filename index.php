<?php
session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

validarAccesoUsuario($configuration,$_GET['page']); //agregado

$methodName = isset($_GET['action']) ? $_GET['action'] : '';
$router->route($_GET['page'], $methodName);

//agregado
function validarAccesoUsuario($configuration,$page)
{
    if(isset($_SESSION['user'])) {
        $tipoUsuario = $configuration->getUserModel()->getTipoUsuario($_SESSION['user']);

        $whiteListAdmin = ['admin'];
        $whiteListEditor = ['editor','crearPregunta'];
        $whiteListJugador = ['activar','jugar','lobby','modificarPerfil','ranking','respuesta','perfil'];

        switch ($tipoUsuario)
        {
            case 1:
                if(!in_array($page,$whiteListAdmin)) {
                    header('Location: /admin');
                    exit();
                }
                break;
            case 2:
                if(!in_array($page,$whiteListEditor)) {
                    header('Location: /editor');
                    exit();
                }
                break;
            case 3:
                if(!in_array($page,$whiteListJugador)) {
                    header('Location: /lobby');
                    exit();
                }
                break;
        }
    }
}