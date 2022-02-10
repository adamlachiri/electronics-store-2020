<?php

class Order extends Database
{

    public function register_order($product_id, $quantity, $total_price, $payment_method)
    {
        $sql = "INSERT into orders 
        (product_id, user_id, quantity, total_price, order_date, payment_method, delivery_address, delivery_city) 
        values (:product_id, :user_id, :quantity, :total_price, NOW(), :payment_method, :delivery_address, :delivery_city)";

        $info = [
            ":product_id" => $product_id,
            ":user_id" => $_SESSION["user_id"],
            ":quantity" => $quantity,
            ":total_price" => $total_price,
            ":payment_method" => $payment_method,
            ":delivery_address" => $_SESSION["user_address"],
            ":delivery_city" => $_SESSION["user_city"]
        ];

        $this->post_data($sql, $info);
    }

    public function get_user_orders()
    {
        $sql = "SELECT product_id from orders 
        where user_id = :user_id";

        $info = [":user_id" => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }

    public function get_user_orders_details()
    {
        $sql = "SELECT p.image_1, p.name, o.quantity, o.total_price, o.order_date, o.product_id
        from orders o
        join products p
        on o.product_id = p.id
        where o.user_id = :user_id
        order by order_date desc
        ";

        $info = [":user_id" => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }

    public function get_all_spendings()
    {
        $sql = "SELECT total_price from orders 
        where user_id = :user_id";

        $info = [":user_id" => $_SESSION["user_id"]];

        return $this->get_data($sql, $info);
    }
}
