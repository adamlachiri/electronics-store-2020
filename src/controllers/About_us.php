<?php
class About_us extends Controller
{
    public function index()
    {
        //serve
        $this->view("about_us/index");
    }

    public function terms_of_service()
    {
        //serve
        $this->view("about_us/terms");
    }
}
