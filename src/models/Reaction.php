<?php
class Reaction extends Database
{
    public function get_user_reactions()
    {
        $sql = "select comment_id 
        from reactions 
        where user_id = :user_id
        ";

        $info = [":user_id" => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }

    public function add_reaction($comment_id)
    {

        $sql = "insert into reactions 
        (comment_id, user_id)
        values (:comment_id, :user_id)
        ";

        $info = [":comment_id" => $comment_id, ":user_id" => $_SESSION["user_id"]];

        $this->post_data($sql, $info);
    }

    public function remove_reaction($comment_id)
    {

        $sql = "delete from reactions 
        where comment_id = :comment_id
        and user_id = :user_id
        ";

        $info = [":comment_id" => $comment_id, ":user_id" => $_SESSION["user_id"]];

        $this->post_data($sql, $info);
    }
}
