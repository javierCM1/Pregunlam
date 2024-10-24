<?php

class InputFormatValidator
{
    /**
     * @throws InvalidNameException
     */
    public function validateNames($fullname)
    {
        if(preg_match('/^[\s\p{L}]+$/u',$fullname) == 1)
            return $fullname;

        throw new InvalidNameException();
    }

    /**
     * @throws InvalidUsernameException
     */
    public function validateUsername($username)
    {
        if(preg_match('/\W/',$username) == 0)
            return $username;

        throw new InvalidUsernameException();
    }

    /**
     * @throws InvalidEmailException
     */
    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ?? throw new InvalidEmailException();
    }

    /**
     * @throws InvalidPasswordException
     */
    public function validatePassword($password)
    {
        if(preg_match('/\s/',$password) == 0)
            return $password;

        throw new InvalidPasswordException();
    }

    /**
     * @throws InvalidDateException
     */
    public function validateDate($date)
    {
        if($date <= date("Y-m-d"))
            return $date;

        throw new InvalidDateException();
    }
}