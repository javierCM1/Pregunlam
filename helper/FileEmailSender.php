<?php

class FileEmailSender
{
    //implementar envio de correos
    public function sendEmailToFile($to,$subject,$message)
    {
        file_put_contents($to, $message, FILE_APPEND);
    }
}