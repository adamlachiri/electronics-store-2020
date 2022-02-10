<?php

class Favourite extends Database
{
    public function add_product($product_id)
    {
        $sql = "INSERT into favourites
        (product_id, user_id)
        values (:product_id, :user_id)
        ";

        $info = [":product_id" => $product_id, ":user_id" => $_SESSION["user_id"]];

        $this->post_data($sql, $info);
    }

    public function remove_product($product_id)
    {
        $sql = "DELETE from favourites
        where product_id = :product_id
        and user_id = :user_id
        ";

        $info = [":product_id" => $product_id, ":user_id" => $_SESSION["user_id"]];

        $this->post_data($sql, $info);
    }

    public function get_user_favourites()
    {
        $sql = "SELECT product_id from favourites
        where user_id = :user_id
        ";

        $info = [":user_id" => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }
}
