<?php

function recover_post()
{
    if (isset($_SESSION["post"])) {
        $_POST = $_SESSION["post"];
        unset($_SESSION["post"]);
    }
}

function recover_get()
{
    if (isset($_SESSION["get"])) {
        $_GET = $_SESSION["get"];
        unset($_SESSION["get"]);
    }
}

function translator($fr, $eng)
{
    return (isset($_SESSION["language"]) && $_SESSION["language"] == "english") ? $eng : $fr;
}

function get($str)
{
    return isset($_GET[$str]) ? $_GET[$str] : null;
}

function post($str)
{
    return isset($_POST[$str]) ? $_POST[$str] : null;
}
