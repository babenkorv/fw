<?php

namespace vendor\components;


use application\models\User;

class Auth
{
    private static $user = null;

    private static $tableName = 'user';

    public static function signIn($email, $password, $repeatPassword)
    {
        if (!self::passwordValidate($password, $repeatPassword)) {
            return false;
        }

        self::$user = new User();

        self::$user->email = $email;
        self::$user->password = self::dataCrypt($password);
        self::$user->is_active = 0;

        if (self::checkOnExistUser()) {
            self::$user->save();
        } else {
            return false;
        }

        return true;
    }

    public static function getUserEmail()
    {
        return $_SESSION['loggedUser'];
    }

    public static function getUserToken()
    {
        return self::$user->token;
    }

    public static function logIn($email, $password)
    {
        self::$user = new User();
       
        self::$user->where('email', '=', "'" . $email . "'")->findOne();

        if (self::equalsCryptData($password, self::$user->password)) {

            $hash = self::dataCrypt(self::generateRandomString());
            self::$user->token = $hash;
            self::addToSession(self::$user->email);
        } else {
            throw new \Exception('Invalid email or password');
        }
    }

    public static function isGuest()
    {
        if(!isset($_SESSION['loggedUser'])) {
            return true;
        }

        return false;
    }

    
    private static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function logOut()
    {
        unset($_SESSION['loggedUser']);
        self::$user = null;
    }


    private static function addToSession($hash)
    {
        self::$user->token = $hash;
        $_SESSION['loggedUser'] = $hash;
    }

    private static function passwordValidate($password, $repeatPassword)
    {
        if ($password === $repeatPassword) {
            return true;
        }

        return false;
    }

    private static function checkOnExistUser()
    {
        if (!empty(self::$user->where('email', '=', "'" . self::$user->email . "'")->find())) {
            return false;
        }

        return true;
    }

    private static function dataCrypt($data)
    {
        return password_hash($data, PASSWORD_DEFAULT);
    }

    private static function equalsCryptData($data, $cryptData)
    {

        if (password_verify($data, $cryptData)) {
            return true;
        }

        return false;
    }
}