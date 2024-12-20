<?php
//helper
include_once("helper/MysqlObjectDatabase.php");
include_once("helper/IncludeFilePresenter.php");
include_once("helper/Router.php");
include_once("helper/MustachePresenter.php");
include_once("helper/FileEmailSender.php");
include_once("helper/ProfilePicHandler.php");
include_once("helper/InputFormatValidator.php");
include_once("helper/QRCodeGenerator.php");
include_once("helper/ChartGenerator.php");
include_once("helper/PDFGenerator.php");

//vendor
include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once("vendor/phpqrcode/qrlib.php");

//model
include_once("model/UserModel.php");
include_once("model/PreguntaModel.php");
include_once("model/PartidaModel.php");
include_once("model/ReporteModel.php");

//controller
include_once("controller/RegisterController.php");
include_once("controller/LoginController.php");
include_once("controller/LobbyController.php");
include_once("controller/ActivarController.php");
include_once("controller/PerfilController.php");
include_once("controller/ModificarPerfilController.php");
include_once("controller/JugarController.php");
include_once("controller/RespuestaController.php");
include_once("controller/EditorController.php");
include_once("controller/RankingController.php");
include_once("controller/CrearPreguntaController.php");
include_once("controller/ModificarPreguntaController.php");
include_once("controller/ReportesController.php");
include_once("controller/SugerenciasController.php");
include_once("controller/AdministradorController.php");
include_once("controller/RecuperarContraseniaController.php");

//excepciones
include_once("model/exeption/InvalidNameException.php");
include_once("model/exeption/InvalidUsernameException.php");
include_once("model/exeption/InvalidEmailException.php");
include_once("model/exeption/InvalidPasswordException.php");
include_once("model/exeption/InvalidDateException.php");
include_once("model/exeption/InvalidGenderException.php");
include_once("model/exeption/EmailExistsException.php");
include_once("model/exeption/UsernameExistsException.php");
include_once("model/exeption/PreguntaExpiradaException.php");
include_once("model/exeption/PartidaActivaNoExisteException.php");
include_once("model/exeption/RespuestaIncorrectaException.php");

class Configuration
{
    public function __construct()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
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

    public function getUserModel()
    {
        return new UserModel($this->getDatabase());
    }

    private function getPartidaModel()
    {
        return new PartidaModel($this->getDatabase());
    }

    private function getPreguntaModel()
    {
        return new PreguntaModel($this->getDatabase());
    }

    private function getReporteModel()
    {
        return new ReporteModel($this->getDatabase());
    }

    public function getCrearPreguntaController()
    {
        return new CrearPreguntaController($this->getPreguntaModel(), $this->getUserModel(), $this->getPresenter());
    }

    public function getModificarPreguntaController()
    {
        return new ModificarPreguntaController($this->getPreguntaModel(), $this->getPresenter());
    }

    public function getEditorController()
    {
        return new EditorController($this->getPreguntaModel(),$this->getPresenter());
    }

    public function getAdministradorController()
    {
        return new AdministradorController($this->getPreguntaModel(),$this->getUserModel(),$this->getPresenter(),$this->getChartGenerator(),$this->getPDFGenerator());
    }

    public function getReportesController()
    {
        return new ReportesController($this->getReporteModel(),$this->getPresenter());
    }

    public function getSugerenciasController()
    {
        return new SugerenciasController($this->getPreguntaModel(),$this->getPresenter());
    }

    public function getRegisterController()
    {
        return new RegisterController($this->getUserModel(), $this->getPresenter(), $this->getProfilePicHandler(), $this->getFileEmailSender(), $this->getInputFormatValidator());
    }
    
    public function getRecuperarContraseniaController(){
        return new RecuperarContraseniaController($this->getUserModel(),$this->getPresenter(),$this->getInputFormatValidator());
    }

    public function getLoginController()
    {
        return new LoginController($this->getUserModel(), $this->getPresenter());
    }

    public function getLobbyController()
    {
        return new LobbyController($this->getUserModel(), $this->getPartidaModel(), $this->getPresenter());
    }

    public function getActivarController()
    {
        return new ActivarController($this->getUserModel(), $this->getPresenter());
    }

    public function getPerfilController()
    {
        return new PerfilController($this->getUserModel(), $this->getPartidaModel(), $this->getPresenter(), $this->getQRCodeGenerator());
    }

    public function getModificarPerfilController()
    {
        return new ModificarPerfilController($this->getUserModel(), $this->getPresenter(), $this->getProfilePicHandler(), $this->getInputFormatValidator());
    }

    public function getJugarController()
    {
        return new JugarController($this->getPartidaModel(),$this->getUserModel(),$this->getPreguntaModel(),$this->getPresenter());
    }

    public function getRespuestaController()
    {
        return new RespuestaController($this->getPartidaModel(),$this->getUserModel(),$this->getPreguntaModel(),$this->getReporteModel(),$this->getPresenter());
    }

    public function getRankingController()
    {
        return new RankingController($this->getUserModel(),$this->getPresenter(), $this->getQRCodeGenerator());
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

    private function getQRCodeGenerator()
    {
        return new QRCodeGenerator();
    }

    private function getChartGenerator()
    {
        return new ChartGenerator();
    }

    private function getPDFGenerator()
    {
        return new PDFGenerator();
    }

}