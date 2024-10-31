<?php
session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

validarAccesoUsuario($configuration,$_GET['page']); //agregado

$methodName = isset($_GET['action']) ? $_GET['action'] : '';
$router->route($_GET['page'], $methodName);


function validarAccesoUsuario($configuration,$page)
{
    if(isset($_SESSION['user'])) {
        $tipoUsuario = $configuration->getUserModel()->getTipoUsuario($_SESSION['user']);

        $whiteListAdmin = ['login','admin'];
        $whiteListEditor = ['editor','login'];
        $whiteListJugador = ['activar','codigoActivado','jugar','lobby','login','modificarPerfil','ranking','register','respuesta','perfil'];

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