<?php


session_start();


require_once "./src/compiler.php";


Router::exe();

var_dump(ROOT);
