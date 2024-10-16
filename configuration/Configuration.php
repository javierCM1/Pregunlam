<?php
include_once("helper/MysqlDatabase.php");
include_once("helper/MysqlObjectDatabase.php");
include_once("helper/IncludeFilePresenter.php");
include_once("helper/Router.php");
include_once("helper/MustachePresenter.php");
include_once("controller/RegisterController.php");
include_once("controller/LoginController.php");
include_once("controller/LobbyController.php");
include_once('vendor/mustache/src/Mustache/Autoloader.php');

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
        /*
        $config = parse_ini_file('configuration/config.ini');
        return new MysqlObjectDatabase(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config["database"]
        );
        */
    }

    public function getRegisterController()
    {
        return new RegisterController($this->getDatabase(), $this->getPresenter());
    }

    public function getLoginController()
    {
        return new LoginController($this->getDatabase(), $this->getPresenter());
    }

    public function getLobbyController()
    {
        return new LobbyController($this->getDatabase(), $this->getPresenter());
    }


}