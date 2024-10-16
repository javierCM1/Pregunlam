<?php

class FileEmailSender
{
    public function sendEmailToFile($to,$subject,$message)
    {
        file_put_contents($to, $message, FILE_APPEND);
    }
}