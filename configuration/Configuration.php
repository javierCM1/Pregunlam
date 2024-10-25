<?php
include_once("helper/MysqlObjectDatabase.php");
include_once("helper/IncludeFilePresenter.php");
include_once("helper/Router.php");
include_once("helper/MustachePresenter.php");
include_once("helper/FileEmailSender.php");
include_once("helper/ProfilePicHandler.php");
include_once("helper/InputFormatValidator.php");
include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once("vendor/phpqrcode/qrlib.php");
include_once("model/UserModel.php");
include_once("model/PreguntaModel.php");
include_once("model/PartidaModel.php");
include_once("controller/RegisterController.php");
include_once("controller/LoginController.php");
include_once("controller/LobbyController.php");
include_once("controller/ActivarController.php");
include_once("controller/PerfilController.php");
include_once("controller/ModificarPerfilController.php");
include_once("controller/CategoriaController.php");
include_once("controller/JugarController.php");

//excepciones
include_once("exeption/InvalidNameException.php");
include_once("exeption/InvalidUsernameException.php");
include_once("exeption/InvalidEmailException.php");
include_once("exeption/InvalidPasswordException.php");
include_once("exeption/InvalidDateException.php");
include_once("exeption/InvalidGenderException.php");
include_once("exeption/EmailExistsException.php");
include_once("exeption/UsernameExistsException.php");

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
        return new UserModel($this->getDatabase());
    }

    private function getPreguntaModel()
    {
        return new PreguntaModel($this->getDatabase());
    }

    public function getJugarController()
    {
        return new JugarController($this->getPreguntaModel(),$this->getPresenter());
    }


    public function getRegisterController()
    {
        return new RegisterController($this->getUserModel(), $this->getPresenter(), $this->getProfilePicHandler(), $this->getFileEmailSender(), $this->getInputFormatValidator());
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
    public function getModificarPerfilController()
    {
        return new ModificarPerfilController($this->getUserModel(), $this->getPresenter(), $this->getProfilePicHandler(), $this->getInputFormatValidator());
    }

    public function getCategoriaController()
    {
        return new CategoriaController($this->getPreguntaModel(), $this->getPresenter());
    }





    private function getFileEmailSender()
    {
        return new FileEmailSender();
    }
    private function getProfilePicHandler()
    {
        return new ProfilePicHandler();
    }
    private function getInputFormatValidator()
    {
        return new InputFormatValidator();
    }

}