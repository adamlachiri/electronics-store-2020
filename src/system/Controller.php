<?php





class Controller


{


    protected function model($name)


    {


        require_once ROOT . "/src/models/" . $name  . ".php";
    }





    protected function view($name = "home/index", $data = [])


    {


        require_once ROOT . "/src/views/" . $name  . ".php";


        die();
    }





    protected function check_if_logged()


    {


        if (!isset($_SESSION["user_id"])) {


            $this->view("errors/page_not_found");


            die();
        }
    }





    protected function check_if_not_logged()


    {


        if (isset($_SESSION["user_id"])) {


            $this->view("errors/page_not_found");


            die();
        }
    }





    protected function check_if_admin()


    {


        if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "admin") {


            $this->view("errors/page_not_found");


            die();
        }
    }





    protected function sanitize()


    {


        $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);


        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }





    protected function post($string)


    {


        return (isset($_POST[$string]) && $_POST[$string]) ? $_POST[$string] : null;
    }





    protected function get($string)


    {


        return (isset($_GET[$string]) && $_GET[$string]) ? $_GET[$string] : null;
    }





    protected function file($string)


    {


        return (isset($_FILES[$string]) && $_FILES[$string]["size"] > 0) ?


            $_FILES[$string] : null;
    }





    protected function session($string)


    {


        return (isset($_SESSION[$string]) && $_SESSION[$string]) ?


            $_SESSION[$string] : null;
    }





    protected function send_home()


    {


        header("location:" . URLROOT);


        die();
    }





    protected function send_error($type, $span)


    {


        $_SESSION["error"] = ["type" => $type, "span" => $span];


        $this->send_back();
    }





    protected function send_back()


    {


        if (isset($_SERVER['HTTP_REFERER'])) {


            $_SESSION["get"] = $_GET;


            $_SESSION["post"] = $_POST;


            header("location:" . $_SERVER['HTTP_REFERER']);


            die();
        } else {


            $_SESSION["failure"] = "we're sorry a little have occured, please try later";


            $this->send_home();
        }
    }





    protected function get_page($limit)


    {


        if (isset($_GET["page"])) {


            if ($_GET["page"] > $limit) {


                $_GET["page"] = $limit;
            }
        } else {


            $_GET["page"] = 1;
        }
    }





    protected function send_404()


    {


        $this->view("errors/page_not_found");
    }





    protected function translator($fr, $eng)


    {


        return (isset($_SESSION["language"]) && $_SESSION["language"] == "english") ? $eng : $fr;
    }
}
