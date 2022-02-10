<?php

class Report extends Database
{
    public function add_report($title, $description)
    {
        $sql = "INSERT into reports
        (user_id, title, description, date) 
        values 
        (:user_id, :title, :description, now())
        ";

        $info = [":user_id" => $_SESSION["user_id"], ":title" => $title,  ":description" => $description];

        $this->post_data($sql, $info);
    }

    public function get_reports()
    {
        $sql = "SELECT r.id, r.title, r.description, r.date, u.first_name, u.last_name  
        from reports r
        join users u
        on r.user_id = u.id 
        ";

        return $this->get_data($sql);
    }

    public function delete_report($report_id)
    {
        $sql = "DELETE from reports
        where id = :report_id
        ";

        $info = [":report_id" => $report_id];

        $this->post_data($sql, $info);
    }
}
