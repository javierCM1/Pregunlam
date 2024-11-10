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
    $whiteListNoUser = ['login','register'];

    if(isset($_SESSION['user'])) {
        $tipoUsuario = $configuration->getUserModel()->getTipoUsuario($_SESSION['user']);

        $whiteListAdmin = ['administrador'];
        $whiteListEditor = ['editor','crearPregunta','modificarPregunta','sugerencias','reportes'];
        $whiteListJugador = ['activar','jugar','lobby','modificarPerfil','ranking','respuesta','perfil','crearPregunta'];

        switch ($tipoUsuario)
        {
            case 1:
                if(!in_array($page,$whiteListAdmin)) {
                    header('Location: /administrador');
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
    else if(!in_array($page,$whiteListNoUser)) {
        header('Location: /login');
        exit();
    }
}