<?php

class Check_input
{
    public static function check_name($name)
    {
        return preg_match('/^[a-zA-Z\s]*$/', $name);
    }

    public static function check_address($address)
    {
        $regex = '/[A-Za-z0-9\-\\,.]+/';
        return preg_match($regex, $address);
    }

    public static function check_phone($phone)
    {
        return preg_match('/^06[0-9]{8}$/', $phone);
    }

    public static function check_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function check_password($password)
    {
        return preg_match('/^[a-zA-Z0-9$]{9,}$/', $password);
    }

    public static function check_password_confirmation($password, $confirmed_password)
    {
        return $password === $confirmed_password;
    }

    public static function check_upload($file, $extentions, $size_limit)
    {
        $file_name = $file["name"];
        $file_error = $file["error"];
        $file_size = $file["size"];
        $array = explode(".", $file_name);
        $file_extention = strtolower(end($array));

        if (!in_array($file_extention, $extentions)) {
            return false;
            die();
        }
        if ($file_size > $size_limit) {
            return false;
            die();
        }
        if ($file_error != 0) {
            return false;
            die();
        }
        return true;
    }
}
