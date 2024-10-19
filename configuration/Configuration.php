<?php
include_once("helper/MysqlObjectDatabase.php");
include_once("helper/IncludeFilePresenter.php");
include_once("helper/Router.php");
include_once("helper/MustachePresenter.php");
include_once("helper/FileEmailSender.php");
include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once("model/UserModel.php");
include_once("controller/RegisterController.php");
include_once("controller/LoginController.php");
include_once("controller/LobbyController.php");
include_once("controller/ActivarController.php");
include_once("controller/PerfilController.php");


class Configuration
{
    public function __construct()
    {
    }

    private function getPresenter()
    {
        return new MustachePresenter("./view");
    }


    public function getRouter()
    {
        return new Router($this, 'getLoginController', 'index');
    }

    private function getDatabase()
    {

        $config = parse_ini_file('configuration/config.ini');
        return new MysqlObjectDatabase(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config["database"]
        );

    }

    private function getUserModel()
    {
        return new UserModel($this->getDatabase(), $this->getFileEmailSender());
    }

    public function getRegisterController()
    {
        return new RegisterController($this->getUserModel(), $this->getPresenter());
    }

    public function getLoginController()
    {
        return new LoginController($this->getUserModel(), $this->getPresenter());
    }

    public function getLobbyController()
    {
        return new LobbyController($this->getUserModel(), $this->getPresenter());
    }

    public function getActivarController()
    {
        return new ActivarController($this->getUserModel(), $this->getPresenter());
    }
    public function getPerfilController()
    {
        return new PerfilController($this->getUserModel(), $this->getPresenter());
    }
    private function getFileEmailSender()
    {
        return new FileEmailSender();
    }

}