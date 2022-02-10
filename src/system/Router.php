<?php


class Router


{


    private static $controller_name = "Home";


    private static $method_name = "index";


    private static $controller;





    private static function create_controller()


    {


        require_once ROOT . "/src/controllers/" . self::$controller_name . ".php";


        self::$controller = new self::$controller_name;


    }








    private static function execute_method()


    {


        $method = self::$method_name;


        self::$controller->$method();


    }





    public static function exe()


    {


        if (isset($_GET["url"])) {


            $url = rtrim($_GET["url"], "/");


            $url = filter_var($url, FILTER_SANITIZE_URL);


            $url = explode("/", $url);





            //check controller's name


            if (file_exists(ROOT . "/src/controllers/" . ucwords($url[0]) . ".php")) {


                self::$controller_name = ucwords($url[0]);


                unset($url[0]);


                self::create_controller();





                //check controller's method


                if (isset($url[1])) {


                    if (method_exists(self::$controller, $url[1])) {


                        self::$method_name = $url[1];


                        unset($url[1]);


                    }


                }


            }


        }


        self::create_controller();


        self::execute_method();


    }


}


