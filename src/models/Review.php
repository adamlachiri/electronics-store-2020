<?php

class Review extends Database
{

    public function register_review($product_id, $rating, $comment)
    {
        $sql = "insert into reviews 
        (product_id, user_id, rating, comment, comment_date)
        values (:product_id, :user_id, :rating, :comment, now())
        ";

        $info = [":product_id" => $product_id, ":user_id" => $_SESSION["user_id"], ":rating" => $rating, ":comment" => $comment];

        $this->post_data($sql, $info);
    }

    public function register_fake_review($product_id, $rating, $comment, $user_id)
    {
        $sql = "insert into reviews 
        (product_id, user_id, rating, comment, comment_date)
        values (:product_id, :user_id, :rating, :comment, now())
        ";

        $info = [":product_id" => $product_id, ":user_id" => $user_id, ":rating" => $rating, ":comment" => $comment];

        $this->post_data($sql, $info);
    }

    public function get_user_reviews()
    {
        $sql = "SELECT product_id from reviews
        where user_id = :user_id
        ";

        $info = [':user_id' => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }

    public function get_user_review($product_id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT rating, comment from reviews
        where user_id = :user_id and product_id = :product_id
        ";

        $info = [':user_id' => $user_id, ':product_id' => $product_id];

        return $this->get_data($sql, $info)[0];
    }

    public function edit_review($product_id, $rating, $comment)
    {
        $sql = "UPDATE reviews
        set  rating = :rating,
        comment = :comment,
        comment_date = now()
        where product_id = :product_id and user_id = :user_id
        ";

        $info = [":product_id" => $product_id, ":user_id" => $_SESSION["user_id"], ":rating" => $rating, ":comment" => $comment];

        $this->post_data($sql, $info);
    }

    public function edit_fake_review($product_id, $rating, $comment, $user_id)
    {
        $sql = "UPDATE reviews
        set  rating = :rating,
        comment = :comment,
        comment_date = now()
        where product_id = :product_id and user_id = :user_id
        ";

        $info = [":product_id" => $product_id, ":user_id" => $user_id, ":rating" => $rating, ":comment" => $comment];

        $this->post_data($sql, $info);
    }

    public function get_product_reviews($product_id, $order_command, $limit_command)
    {

        $sql = "SELECT u.first_name, u.last_name, u.image_name,
        r.rating, 
        r.comment, 
        r.comment_date, 
        r.id, 
        r.helpful
        from reviews r
        join users u
        on r.user_id = u.id
        where r.product_id = :product_id
        and r.comment is not null 
        " . $order_command . $limit_command;

        $info = [":product_id" => $product_id];

        return $this->get_data($sql, $info);
    }

    public function count_product_reviews($product_id)
    {

        $sql = "SELECT count(*)
        from reviews 
        where product_id = :product_id
        and comment is not null";

        $info = [":product_id" => $product_id];

        return (int)$this->get_data($sql, $info)[0]["count(*)"];
    }

    public function add_reaction($comment_id)
    {
        $sql =
            "UPDATE reviews
        set helpful = helpful + 1
        where id = :comment_id";

        $info = ['comment_id' => $comment_id];

        $this->post_data($sql, $info);
    }

    public function remove_reaction($comment_id)
    {
        $sql =
            "UPDATE reviews
        set helpful = helpful - 1
        where id = :comment_id";

        $info = ['comment_id' => $comment_id];

        $this->post_data($sql, $info);
    }

    public function get_product_reviews_ids($product_id)
    {
        $sql = "SELECT user_id from reviews
        where product_id = :product_id
        ";

        $info = [":product_id" => $product_id];

        return  $this->get_data($sql, $info);
    }

    public function get_fake_rating($user_id, $product_id)
    {
        $sql = "SELECT rating from reviews
        where user_id = :user_id
        and product_id = :product_id
        ";

        $info = [":user_id" => $user_id, ":product_id" => $product_id];

        return $this->get_data($sql, $info)[0]["rating"];
    }
}
