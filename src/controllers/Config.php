<?php
class Config extends Controller
{
    public function index()
    {
        $this->send_404();
    }

    public function select_language()
    {
        //security
        $this->sanitize();

        //input
        $language = $this->get("language");

        //alter session
        $_SESSION["language"] = $language;

        //redirect
        $this->send_back();
    }
}
